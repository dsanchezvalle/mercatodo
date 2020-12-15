<?php

namespace Tests\Feature\Book;

use App\Book;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanSeeShowBookView()
    {
        $user = factory(User::class)->create(['role_id' => '1']);
        $book = factory(Book::class)->create(['isbn' => '1111111111111']);

        $response = $this->actingAs($user)->get("/books/$book->id");

        $response->assertSuccessful();
        $response->assertViewIs('admin.book.show');
        $response->assertSeeText('1111111111111');
    }

    public function testEditorCanSeeShowBookView()
    {
        $user = factory(User::class)->create(['role_id' => '2']);
        $book = factory(Book::class)->create(['isbn' => '1111111111111']);

        $response = $this->actingAs($user)->get("/books/$book->id");

        $response->assertSuccessful();
        $response->assertViewIs('admin.book.show');
        $response->assertSeeText('1111111111111');
    }

    public function testBuyerCanSeeShowBookView()
    {
        $user = factory(User::class)->create(['role_id' => '3']);
        $book = factory(Book::class)->create(['isbn' => '1111111111111']);

        $response = $this->actingAs($user)->get(route('books.show', $book->id));

        $response->assertSuccessful();
        $response->assertViewIs('admin.book.show');
        $response->assertSeeText('1111111111111');
    }

    public function testNonAuthenticatedUserCanNotShowBooks()
    {
        $book = factory(Book::class)->create();
        Storage::fake('local');

        $this->get("/books/$book->id")->assertRedirect(route('verification.notice'));
    }
}
