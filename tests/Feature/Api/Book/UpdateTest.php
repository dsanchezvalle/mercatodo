<?php

namespace Tests\Feature\Api\Book;

use App\Book;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticatedUserCanUpdateABook()
    {
        $book = factory(Book::class)->create();
        Sanctum::actingAs(factory(User::class)->create(['role_id' => 1]), ['*']);

        $response = $this->putJson(route('api.books.update', $book->id), [
            'isbn' => '1111111111111',
            'title' => 'New Title',
            'author' => 'New Author',
            'price' => 50000,
            'stock' => 50,
            'image_path' => '/fakePath.png',
            'is_active' => null
        ]);
        $book->refresh();

        $response->assertSuccessful();
        $response->assertExactJson([
            'data' => [
                'id' => $book->id,
                'isbn' => $book->isbn,
                'title' => $book->title,
                'author' => $book->author,
                'price' => (int) $book->price,
                'stock' => (int) $book->stock,
                'image_path' => $book->image_path,
                'is_active' => false,
                'created_at' => $book->created_at,
                'updated_at' => $book->updated_at,
            ],
        ]);
        $this->assertEquals('1111111111111', $book->isbn);
        $this->assertEquals('New Title', $book->title);
        $this->assertEquals('New Author', $book->author);
        $this->assertEquals(50000, $book->price);
        $this->assertEquals(50, $book->stock);
        $this->assertEquals('/fakePath.png', $book->image_path);
        $this->assertEquals(0, $book->is_active);
    }

    public function testUnauthenticatedUserCanNotUpdateABook()
    {
        $book = factory(Book::class)->create();

        $response = $this->putJson(route('api.books.update', $book->id), [
            'isbn' => '1111111111111',
            'title' => 'New Title',
            'author' => 'New Author',
            'price' => 50000,
            'stock' => 50,
            'image_path' => '/fakePath.png',
            'is_active' => null
        ]);
        $book->refresh();

        $response->assertUnauthorized();
        $response->assertExactJson(['message' => 'Unauthenticated.']);
        $this->assertEquals($book->created_at, $book->updated_at);
    }
}
