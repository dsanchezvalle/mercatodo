<?php

namespace Tests\Feature;

use App\Address;
use App\Book;
use App\Order;
use App\Services\PlacetoPayServiceInterface;
use App\Transaction;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\PlacetoPayServiceMock;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function testClientIsRedirectedToPay()
    {
        $this->app->singleton(PlacetoPayServiceInterface::class, PlacetoPayServiceMock::class);
        $client = factory(User::class)->create();
        $book = factory(Book::class)->create();
        $order = Order::create(['user_id' => $client->id, 'status' => 'open']);
        $order->books()->attach($book, ['quantity' => 1, 'unit_price' => $book->price]);
        $order->save();

        $this->actingAs($client)->post(
            route('cart.payment'),
            [
            'street' => '223 Ocean Avenue',
            'city' => 'Medellin',
            'state' => 'Antioquia',
            'country' => 'CO',
            'mobile' => '3332221234'
            ]
        )->assertRedirect('http://mock.service');

        $this->assertEquals('closed', Order::first()->status);
        $this->assertDatabaseCount('transactions', 1);
    }

    public function testClientIsRedirectedToBookshelfIfRequestFails()
    {
        $this->app->singleton(
            PlacetoPayServiceInterface::class,
            function () {
                $service = new PlacetoPayServiceMock();
                $service->setResponse(
                    [
                    'status' => [
                    'status' => 'FAILED',
                    'reason' => '401',
                    'message' => '',
                    'date' => now(),
                    ]
                    ]
                );
                return $service;
            }
        );
        $client = factory(User::class)->create();
        $book = factory(Book::class)->create();
        $order = Order::create(['user_id' => $client->id, 'status' => 'open']);
        $order->books()->attach($book, ['quantity' => 1, 'unit_price' => $book->price]);
        $order->save();

        $this->actingAs($client)->post(
            route('cart.payment'),
            [
            'street' => '223 Ocean Avenue',
            'city' => 'Medellin',
            'state' => 'Antioquia',
            'country' => 'CO',
            'mobile' => '3332221234'
            ]
        )->assertRedirect(route('bookshelf'))->assertSessionHas('message');

        $this->assertEquals('open', Order::first()->status);
        $this->assertDatabaseCount('transactions', 0);
    }

    public function testWhenClientCancelTransactionInPlaceToPayItIsUpdatedInDatabase()
    {
        $this->app->singleton(
            PlacetoPayServiceInterface::class,
            function () {
                $service = new PlacetoPayServiceMock();
                $service->setResponse(
                    [
                    'status' => [
                    'status' => 'REJECTED',
                    'reason' => '401',
                    'message' => '',
                    'date' => now(),
                    ]
                    ]
                );
                return $service;
            }
        );
        $client = factory(User::class)->create();
        $book = factory(Book::class)->create();
        $order = Order::create([
            'user_id' => $client->id,
            'status' => 'open',
            'address_id' => factory(Address::class)->create(['user_id' => $client->id])->id
        ]);
        $order->books()->attach($book, ['quantity' => 1, 'unit_price' => $book->price]);
        $order->save();
        Transaction::create(
            [
                'order_id' => $order->id,
                'amount' => $order->getSubtotal(),
                'request_id' => 12345,
                'status' => 'PENDING',
                'process_url' => 'http://mock.service',
                'reference' => '1233789899',
            ]
        );

        $this->actingAs($client)->get(route('transaction.cancel', 1233789899))
            ->assertSuccessful()
            ->assertViewIs('transaction.cancel');

        $this->assertEquals('REJECTED', Transaction::first()->status);
    }

    public function testClientCanRetryRejectedTransactions()
    {
        $this->app->singleton(PlacetoPayServiceInterface::class, PlacetoPayServiceMock::class);
        $client = factory(User::class)->create();
        $book = factory(Book::class)->create();
        $order = Order::create([
            'user_id' => $client->id,
            'status' => 'open',
            'address_id' => factory(Address::class)->create(['user_id' => $client->id])->id
        ]);
        $order->books()->attach($book, ['quantity' => 1, 'unit_price' => $book->price]);
        $order->save();
        Transaction::create(
            [
                'order_id' => $order->id,
                'amount' => $order->getSubtotal(),
                'request_id' => 12345,
                'status' => 'REJECTED',
                'process_url' => 'http://mock.service',
                'reference' => '1233789899',
            ]
        );

        $this->actingAs($client)->get(route('transaction.retry', 1233789899))->assertRedirect('http://mock.service');

        $this->assertDatabaseCount('transactions', 2);

    }
}
