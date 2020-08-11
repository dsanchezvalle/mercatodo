<?php

namespace Tests\Feature;

use App\Book;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Storage;

class BookTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function admin_can_see_book_dasboard()
    {
        $user = factory(User::class)->create(['is_admin' => true]);

        $response = $this->actingAs($user)->get('/books');

        $response->assertSuccessful();
        $response->assertViewIs('admin.book.index');
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function non_admins_cannot_see_book_index_view()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/books');

        $response->assertForbidden();
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function admin_can_update_book_info()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create(['is_admin' => true]);
        $book = factory(Book::class)->create();

        $response = $this->actingAs($user)->put("/books/$book->id", [
            'isbn' => '1111111111111',
            'title' => 'Hamlet',
            'author' => 'William Shakespeare',
            'price' => '54543',
            'stock' => '999',
            'is_active' => 'on'
        ]);

        //$response->assertRedirect(route('books.index'));
        $expectedData = Book::find(1);

        $this->assertEquals('1111111111111', $expectedData->isbn);
        $this->assertEquals('Hamlet', $expectedData->title);
        $this->assertEquals('William Shakespeare', $expectedData->author);
        $this->assertEquals('54543', $expectedData->price);
        $this->assertEquals('999', $expectedData->stock);
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function non_admin_cannot_update_book_info()
    {
        $user = factory(User::class)->create();
        $book = factory(Book::class)->create();

        $response = $this->actingAs($user)->put("/books/$book->id", [
            'isbn' => '1111111111111',
            'title' => 'Hamlet',
            'author' => 'William Shakespeare',
            'price' => '54543',
            'stock' => '999',
            'image_path' => 'https://lorempixel.com/400/350/?61443',
            'is_active' => 'on'
        ]);

        $response->assertForbidden();
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */

    public function admin_can_see_new_book_view()
    {
        $user = factory(User::class)->create(['is_admin' => true]);

        $response = $this->actingAs($user)->get('/books/create');

        $response->assertSuccessful();
        $response->assertViewIs('admin.book.create');
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */

    public function admin_can_create_new_book()
    {
        $user = factory(User::class)->create(['is_admin' => true]);
        $book = factory(Book::class)->make();
        Storage::fake('local');
        $file = UploadedFile::fake()->create('file.jpg', 50);

        $response = $this->actingAs($user)->post('/books', [
            'isbn' => $book->isbn,
            'title' => $book->title,
            'author' => $book->author,
            'price' => $book->price,
            'stock' => $book->stock,
            'file' => $file,
        ]);

        $response->assertRedirect('books');

        $this->assertDatabaseHas('books', [
            'isbn' => $book->isbn,
        ]);
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */

    public function admin_can_see_show_book_view()
    {
        $user = factory(User::class)->create(['is_admin' => true]);
        $book = factory(Book::class)->create(['isbn' => '1111111111111']);

        $response = $this->actingAs($user)->get("/books/$book->id");

        $response->assertSuccessful();
        $response->assertViewIs('admin.book.show');
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */


    public function non_admins_cannot_see_show_book_view()
    {
        $user = factory(User::class)->create();
        $book = factory(Book::class)->create();

        $response = $this->actingAs($user)->get("/books/$book->id");

        $response->assertForbidden();
    }

    /**
     * A basic feature test example.
     * @test
     * @dataProvider searchItemsProvider
     * @param string $field
     * @param string $value
     * @return void
     */

    public function admin_can_search_books_with_filters(string $field, string $value)
    {
        $user = factory(User::class)->create(['is_admin' => true]);
        factory(Book::class, 5)->create();
        $book = factory(Book::class)->create([
            'author' => 'Carlos Perez',
            'title' => 'Tom Sawyer',
            'isbn' => '2222222222222',
        ]);

        $filters = [
            'filter' => [
                $field => $value
            ]
        ];

        $response = $this->actingAs($user)
            ->get(route('books.index', $filters));

        $responseBooks = $response->getOriginalContent()['books'];
        $this->assertTrue($responseBooks->contains($book));
    }

    public function searchItemsProvider(): array
    {
        return [
            'admin can search books by author' => ['author', 'Carlos'],
            'admin can search books by title' => ['title', 'Tom Sawyer'],
            'admin can search books by isbn' => ['isbn', '2222222222222'],
            'admin can search books by status' => ['status', 'true'],
        ];
    }
}
