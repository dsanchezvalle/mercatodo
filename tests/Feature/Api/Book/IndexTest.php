<?php

namespace Tests\Feature\Api\Book;

use App\Book;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticatedUserCanSeeBookIndex()
    {
        factory(Book::class, 10)->create();
        Sanctum::actingAs(factory(User::class)->create(['role_id' => 1]), ['*']);

        $response = $this->getJson(route('api.books.index'));

        $response->assertSuccessful();
        $response->assertJsonCount(10, 'data');
    }

    public function testUnauthenticatedUserCanNotSeeBookIndex()
    {
        $response = $this->getJson(route('api.books.index'));

        $response->assertUnauthorized();
        $response->assertExactJson(['message' => 'Unauthenticated.']);
    }
}
