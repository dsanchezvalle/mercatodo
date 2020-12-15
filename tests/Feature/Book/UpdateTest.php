<?php

namespace Tests\Feature\Book;

use App\Book;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanUpdateBookInfo()
    {
        $user = factory(User::class)->create(['role_id' => '1']);
        $book = factory(Book::class)->create();

       $this->actingAs($user)->put(
            "/books/$book->id",
            [
                'isbn' => '1111111111111',
                'title' => 'Hamlet',
                'author' => 'William Shakespeare',
                'price' => '54543',
                'stock' => '999',
                'is_active' => 'on'
            ]
        )->assertRedirect(route('books.index'));

        $expectedData = Book::find(1);

        $this->assertEquals('1111111111111', $expectedData->isbn);
        $this->assertEquals('Hamlet', $expectedData->title);
        $this->assertEquals('William Shakespeare', $expectedData->author);
        $this->assertEquals('54543.0', $expectedData->price);
        $this->assertEquals('999', $expectedData->stock);
    }

    public function testEditorCanUpdateBookInfo()
    {
        $user = factory(User::class)->create(['role_id' => '2']);
        $book = factory(Book::class)->create();

        $this->actingAs($user)->put(
            "/books/$book->id",
            [
                'isbn' => '1111111111111',
                'title' => 'Hamlet',
                'author' => 'William Shakespeare',
                'price' => '54543',
                'stock' => '999',
                'is_active' => 'on'
            ]
        )->assertRedirect(route('books.index'));

        $expectedData = Book::find(1);

        $this->assertEquals('1111111111111', $expectedData->isbn);
        $this->assertEquals('Hamlet', $expectedData->title);
        $this->assertEquals('William Shakespeare', $expectedData->author);
        $this->assertEquals('54543.0', $expectedData->price);
        $this->assertEquals('999', $expectedData->stock);
    }

    /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function testBuyerCanNotUpdateBookInfo()
    {
        $user = factory(User::class)->create();
        $book = factory(Book::class)->create();

        $response = $this->actingAs($user)->put(
            "/books/$book->id",
            [
                'isbn' => '1111111111111',
                'title' => 'Hamlet',
                'author' => 'William Shakespeare',
                'price' => '54543',
                'stock' => '999',
                'image_path' => 'https://lorempixel.com/400/350/?61443',
                'is_active' => 'on'
            ]
        );

        $response->assertForbidden();
    }

    public function testNonAuthenticatedUserCanNotUpdateBooks()
    {
        $book = factory(Book::class)->create();

        $response = $this->put(
            "/books/$book->id",
            [
                'isbn' => '1111111111111',
                'title' => 'Hamlet',
                'author' => 'William Shakespeare',
                'price' => '54543',
                'stock' => '999',
                'image_path' => 'https://lorempixel.com/400/350/?61443',
                'is_active' => 'on'
            ]
        );

        $response->assertRedirect(route('verification.notice'));
    }
}
