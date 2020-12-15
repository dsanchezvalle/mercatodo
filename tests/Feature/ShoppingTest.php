<?php

namespace Tests\Feature;

use App\Book;
use App\Order;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShoppingTest extends TestCase
{
    use RefreshDatabase;

    public function testClientCanAddBookToShoppingCart()
    {
        $book = factory(Book::class)->create();
        $client = factory(User::class)->create();

        $this->actingAs($client)->post(route('cart.update', $book->id), ['items' => 1])
            ->assertRedirect('bookshelf')
            ->assertSessionHas('message');

        $this->assertDatabaseCount('orders', 1);
        $this->assertEquals(Order::first()->status, 'open');
        $this->assertCount(1, Order::first()->books);
    }

    public function testClientCanSeeShoppingCart()
    {
        $books = factory(Book::class, 3)->create();
        $client = factory(User::class)->create();
        $order = Order::create(['user_id' => $client->id, 'status' => 'open']);
        foreach ($books as $book) {
            $order->books()->attach($book, ['quantity' => 1, 'unit_price' => $book->price]);
        }
        $order->save();

        $response = $this->actingAs($client)->get(route('cart.index'))->assertSuccessful();

        foreach ($books as $book) {
            $response->assertSee($book->title);
        }
        $response->assertSee($order->getFormattedSubtotal());
    }

    public function testClientCanDeleteABookFromShoppingCart()
    {
        $book = factory(Book::class)->create();
        $client = factory(User::class)->create();
        $order = Order::create(['user_id' => $client->id, 'status' => 'open']);
        $order->books()->attach($book, ['quantity' => 1, 'unit_price' => $book->price]);
        $order->save();

        $this->actingAs($client)->delete(route('cart.remove', $book->id))->assertRedirect(route('cart.index'));

        $this->assertCount(0, $order->books);
    }

    public function testClientCanUpdateShoppingCart()
    {
        $book = factory(Book::class)->create();
        $client = factory(User::class)->create();
        $order = Order::create(['user_id' => $client->id, 'status' => 'open']);
        $order->books()->attach($book, ['quantity' => 1, 'unit_price' => $book->price]);
        $order->save();

        $this->actingAs($client)->put(route('cart.edit', $book->id), ['items' => 2])->assertRedirect(route('cart.index'));

        $this->assertEquals(2, $order->books->find($book->id)->pivot->quantity);
    }

    public function testClientCanSeeCheckoutForm()
    {
        $book = factory(Book::class)->create();
        $client = factory(User::class)->create();
        $order = Order::create(['user_id' => $client->id, 'status' => 'open']);
        $order->books()->attach($book, ['quantity' => 1, 'unit_price' => $book->price]);
        $order->save();

        $response = $this->actingAs($client)->get(route('cart.checkout'))->assertSuccessful();

        $response->assertViewIs('shoppingcart.checkout');
        $response->assertSee('form');
    }
}
