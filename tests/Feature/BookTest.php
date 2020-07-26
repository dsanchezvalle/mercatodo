<?php

namespace Tests\Feature;

use App\Book;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
        $response->assertViewIs('book.index');
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
            'image_path' => 'https://lorempixel.com/400/350/?61443',
            'is_active' => 'on'
        ]);

        //$response->assertRedirect(route('books.index'));
        $expectedData = Book::find(1);

        $this->assertEquals('1111111111111',$expectedData->isbn);
        $this->assertEquals('Hamlet',$expectedData->title);
        $this->assertEquals('William Shakespeare',$expectedData->author);
        $this->assertEquals('54543',$expectedData->price);
        $this->assertEquals('999',$expectedData->stock);
        $this->assertEquals('https://lorempixel.com/400/350/?61443',$expectedData->image_path);

    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function non_admin_cannot_update_book_info (){

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
        $response->assertViewIs('book.create');
    }


}
