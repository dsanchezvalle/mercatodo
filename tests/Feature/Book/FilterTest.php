<?php

namespace Tests\Feature\Book;

use App\Book;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilterTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     * @dataProvider searchItemsProvider
     * @param string $field
     * @param string $value
     * @return       void
     */

    public function testAdminCanSearchBooksWithFilters(string $field, string $value)
    {
        $user = factory(User::class)->create(['role_id' => '1']);
        factory(Book::class, 5)->create();
        $book = factory(Book::class)->create(
            [
                'author' => 'Carlos Perez',
                'title' => 'Tom Sawyer',
                'isbn' => '2222222222222',
            ]
        );

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

    /**
     *
     * @dataProvider searchItemsProvider
     * @param string $field
     * @param string $value
     * @return       void
     */

    public function testEditorCanSearchBooksWithFilters(string $field, string $value)
    {
        $user = factory(User::class)->create(['role_id' => '2']);
        factory(Book::class, 5)->create();
        $book = factory(Book::class)->create(
            [
                'author' => 'Carlos Perez',
                'title' => 'Tom Sawyer',
                'isbn' => '2222222222222',
            ]
        );

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

    /**
     *
     * @dataProvider searchItemsProvider
     * @param string $field
     * @param string $value
     * @return       void
     */

    public function testBuyerCanSearchBooksWithFiltersInBookshelf(string $field, string $value)
    {
        $user = factory(User::class)->create(['role_id' => '3']);
        factory(Book::class, 5)->create();
        $book = factory(Book::class)->create(
            [
                'author' => 'Carlos Perez',
                'title' => 'Tom Sawyer',
                'isbn' => '2222222222222',
            ]
        );

        $filters = [
            'filter' => [
                $field => $value
            ]
        ];

        $response = $this->actingAs($user)
            ->get(route('bookshelf', $filters));

        $responseBooks = $response->getOriginalContent()['books'];
        $this->assertTrue($responseBooks->contains($book));
    }

    /**
     * @return string[][]
     */
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
