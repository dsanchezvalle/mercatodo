<?php

namespace Tests\Feature\Book;

use App\Book;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanSeeNewBookView()
    {
        $user = factory(User::class)->create(['role_id' => '1']);

        $response = $this->actingAs($user)->get(route('books.create'));

        $response->assertSuccessful();
        $response->assertViewIs('admin.book.create');
    }

    public function testEditorCanSeeNewBookView()
    {
        $user = factory(User::class)->create(['role_id' => '2']);

        $response = $this->actingAs($user)->get(route('books.create'));

        $response->assertSuccessful();
        $response->assertViewIs('admin.book.create');
    }
    public function testBuyerCanNotSeeNewBookView()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('books.create'));

        $response->assertForbidden();
    }

    public function testNonAuthenticatedUserCanNotSeeNewBookView()
    {
        $this->get(route('books.create'))->assertRedirect(route('verification.notice'));
    }
}
