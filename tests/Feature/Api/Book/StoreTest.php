<?php

namespace Tests\Feature\Api\Book;

use App\Book;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticatedUserCanCreateABook()
    {
        $book = factory(Book::class)->make();
        Sanctum::actingAs(factory(User::class)->create(['role_id' => 1]), ['*']);

        $response = $this->postJson(route('api.books.store'), [
            'isbn' => $book->isbn,
            'title' => $book->title,
            'author' => $book->author,
            'price' => $book->price,
            'stock' => $book->stock,
            'image_path' => $book->image_path
        ]);

        $response->assertSuccessful();
        $book = Book::first();
        $response->assertExactJson([
            'data' => [
                'id' => $book->id,
                'isbn' => $book->isbn,
                'title' => $book->title,
                'author' => $book->author,
                'price' => (int) $book->price,
                'stock' => (int) $book->stock,
                'image_path' => $book->image_path,
                'is_active' => true,
                'created_at' => $book->created_at,
                'updated_at' => $book->updated_at,
            ],
        ]);
        $this->assertDatabaseCount('books', 1);
    }

    public function testUnauthenticatedUserCanNotCreateABook()
    {
        $book = factory(Book::class)->make();

        $response = $this->postJson(route('api.books.store'), [
            'isbn' => $book->isbn,
            'title' => $book->title,
            'author' => $book->author,
            'price' => $book->price,
            'stock' => $book->stock,
            'image_path' => $book->image_path
        ]);

        $response->assertUnauthorized();
        $response->assertExactJson(['message' => 'Unauthenticated.']);
        $this->assertDatabaseCount('books', 0);
    }
}
