<?php

namespace Tests\Feature\Book;

use App\Book;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanSeeEditBookView()
    {
        $user = factory(User::class)->create(['role_id' => '1']);
        $book = factory(Book::class)->create();

        $response = $this->actingAs($user)->get(route('books.edit', $book->id));

        $response->assertSuccessful();
        $response->assertViewIs('admin.book.edit');
    }

    public function testEditorCanSeeEditBookView()
    {
        $user = factory(User::class)->create(['role_id' => '2']);
        $book = factory(Book::class)->create();

        $response = $this->actingAs($user)->get(route('books.edit', $book->id));

        $response->assertSuccessful();
        $response->assertViewIs('admin.book.edit');
    }

    public function testBuyerCanNotSeeEditBookView()
    {
        $user = factory(User::class)->create(['role_id' => '3']);
        $book = factory(Book::class)->create();

        $response = $this->actingAs($user)->get(route('books.edit', $book->id));

        $response->assertForbidden();
    }

    public function testNonAuthenticatedUserCanNotSeeEditBookView()
    {
        $book = factory(Book::class)->create();

        $this->get(route('books.edit', $book->id))->assertRedirect(route('verification.notice'));
    }
}
