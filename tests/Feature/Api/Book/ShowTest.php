<?php

namespace Tests\Feature\Api\Book;

use App\Book;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticatedUserCanSeeBookDetails()
    {
        $book = factory(Book::class)->create();
        Sanctum::actingAs(factory(User::class)->create(['role_id' => 1]), ['*']);

        $response = $this->getJson(route('api.books.show', $book->id));

        $response->assertSuccessful();
        $response->assertExactJson([
            'data' => [
                'id' => $book->id,
                'isbn' => $book->isbn,
                'title' => $book->title,
                'author' => $book->author,
                'price' => (string) number_format($book->price,1, '.', ''),
                'stock' => (string) $book->stock,
                'image_path' => $book->image_path,
                'is_active' => (string) $book->is_active,
                'created_at' => $book->created_at,
                'updated_at' => $book->updated_at,
            ],
        ]);
    }

    public function testUnauthenticatedUserCanNotSeeBookDetails()
    {
        $book = factory(Book::class)->create();

        $response = $this->getJson(route('api.books.show', $book->id));

        $response->assertUnauthorized();
        $response->assertExactJson(['message' => 'Unauthenticated.']);
    }
}
