<?php

namespace Tests\Feature\Book;

use App\Book;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanSeeBookDashboard()
    {
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create(['role_id' => '1']);

        $response = $this->actingAs($user)->get('/books');

        $response->assertSuccessful();
        $response->assertViewIs('admin.book.index');
        $response->assertSeeText($book->name);
    }

    public function testEditorCanSeeBookDashboard()
    {
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create(['role_id' => '2']);

        $response = $this->actingAs($user)->get('/books');

        $response->assertSuccessful();
        $response->assertViewIs('admin.book.index');
        $response->assertSeeText($book->name);
    }

    public function testBuyerCanNotSeeBookDashboard()
    {
        $user = factory(User::class)->create(['role_id' => '3']);

        $response = $this->actingAs($user)->get('/books');

        $response->assertForbidden();
    }

    public function testNonAuthenticatedUserCanNotSeeBookDashboard()
    {
        $this->get(route('books.index'))->assertRedirect(route('verification.notice'));
    }
}
