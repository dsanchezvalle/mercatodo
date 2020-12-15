<?php

namespace Tests\Feature\Book;

use App\Book;
use App\Exports\BooksExport;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class ExportTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanExportBooks()
    {
        Excel::fake();
        $user = factory(User::class)->create(['role_id' => '1']);
        $books = factory(Book::class, 10)->create();

        $this->actingAs($user)->get(route('books.export'));

        Excel::assertDownloaded('books.xlsx', function (BooksExport $export) use ($books) {
            return $export->collection()->count() === $books->count();
        });
    }

    public function testEditorCanExportBooks()
    {
        Excel::fake();
        $user = factory(User::class)->create(['role_id' => '2']);
        $books = factory(Book::class, 10)->create();

        $this->actingAs($user)->get(route('books.export'));

        Excel::assertDownloaded('books.xlsx', function (BooksExport $export) use ($books) {
            return $export->collection()->count() === $books->count();
        });
    }

    public function testBuyerCanNotExportBooks()
    {
        $user = factory(User::class)->create(['role_id' => '3']);

        $response = $this->actingAs($user)->get(route('books.export'));

        $response->assertForbidden();
    }

    public function testNonAuthenticatedUserCanNotExportBooks()
    {
        $this->get(route('books.export'))->assertRedirect(route('verification.notice'));
    }
}
