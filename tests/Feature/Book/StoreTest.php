<?php

namespace Tests\Feature\Book;

use App\Book;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Support\DataProvider\BookHasDataProvider;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase, BookHasDataProvider;

    public function testAdminCanCreateNewBook()
    {
        $user = factory(User::class)->create(['role_id' => '1']);
        $book = factory(Book::class)->make();
        Storage::fake('local');
        $file = UploadedFile::fake()->create('file.jpg', 50);

        $response = $this->actingAs($user)->post(route('books.store')
            ,
            [
                'isbn' => $book->isbn,
                'title' => $book->title,
                'author' => $book->author,
                'price' => $book->price,
                'stock' => $book->stock,
                'file' => $file,
            ]
        );

        $response->assertRedirect('books');
        $this->assertDatabaseHas( 'books',
            [
                'isbn' => $book->isbn,
            ]
        );
    }

    public function testEditorCanCreateNewBook()
    {
        $user = factory(User::class)->create(['role_id' => '2']);
        $book = factory(Book::class)->make();
        Storage::fake('local');
        $file = UploadedFile::fake()->create('file.jpg', 50);

        $response = $this->actingAs($user)->post(route('books.store')
            ,
            [
                'isbn' => $book->isbn,
                'title' => $book->title,
                'author' => $book->author,
                'price' => $book->price,
                'stock' => $book->stock,
                'file' => $file,
            ]
        );

        $response->assertRedirect('books');
        $this->assertDatabaseHas( 'books',
            [
                'isbn' => $book->isbn,
            ]
        );
    }

    public function testBuyerCanNotCreateNewBook()
    {
        $user = factory(User::class)->create();
        $book = factory(Book::class)->make();
        Storage::fake('local');
        $file = UploadedFile::fake()->create('file.jpg', 50);

        $response = $this->actingAs($user)->post(route('books.store')
            ,
            [
                'isbn' => $book->isbn,
                'title' => $book->title,
                'author' => $book->author,
                'price' => $book->price,
                'stock' => $book->stock,
                'file' => $file,
            ]
        );

        $response->assertForbidden();
    }

    public function testNonAuthenticatedUserCanNotCreateBooks()
    {
        $book = factory(Book::class)->create();
        Storage::fake('local');
        $file = UploadedFile::fake()->create('file.jpg', 50);

        $response = $this->put(
            "/books/$book->id",
            [
                'isbn' => '1111111111111',
                'title' => 'Hamlet',
                'author' => 'William Shakespeare',
                'price' => '54543',
                'stock' => '999',
                'file' => $file
            ]
        );

        $response->assertRedirect(route('verification.notice'));
    }

    /**
     * @dataProvider bookStoreProvider
     * @param $book
     * @param $field
     */
    public function testBookCanNotBeCreatedDueValidationError($book, $field)
    {
        $user = factory(User::class)->create(['role_id' => '1']);

        $response = $this->actingAs($user)->post(route('books.store'), $book);

        $response->assertRedirect();
        $response->assertSessionHasErrors($field);
    }
}
