<?php

namespace Tests\Feature\Book;

use App\Book;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookshelfTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     */
    public function testAdminCanSeeBookshelf()
    {
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create(['role_id' => '1']);

        $response = $this->actingAs($user)->get(route('bookshelf'));

        $response->assertSuccessful();
        $response->assertViewIs('book.bookshelf');
        $response->assertSeeText($book->name);
    }

    public function testEditorCanSeeBookshelf()
    {
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create(['role_id' => '2']);

        $response = $this->actingAs($user)->get(route('bookshelf'));

        $response->assertSuccessful();
        $response->assertViewIs('book.bookshelf');
        $response->assertSeeText($book->name);
    }

    public function testBuyerCanSeeBookshelf()
    {
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create(['role_id' => '3']);

        $response = $this->actingAs($user)->get(route('bookshelf'));

        $response->assertSuccessful();
        $response->assertViewIs('book.bookshelf');
        $response->assertSeeText($book->name);
    }

    public function testNonAuthenticatedUserCanNotSeeBookshelf()
    {
        $this->get(route('bookshelf'))->assertRedirect(route('verification.notice'));
    }
}
