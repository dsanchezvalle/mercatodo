<?php

namespace Tests\Feature\Book;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ImportTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanImportBooks()
    {
        $user = factory(User::class)->create(['role_id' => '1']);
        $file = UploadedFile::fake()->createWithContent('ImportBookOk.xlsx', file_get_contents(base_path('tests/Stubs/ImportBookOk.xlsx')));

        $response = $this->actingAs($user)->post(route('books.import'), ['book-import' => $file]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseCount('books', 48);
    }

    public function testEditorCanImportBooks()
    {
        $user = factory(User::class)->create(['role_id' => '2']);
        $file = UploadedFile::fake()->createWithContent('ImportBookOk.xlsx', file_get_contents(base_path('tests/Stubs/ImportBookOk.xlsx')));

        $response = $this->actingAs($user)->post(route('books.import'), ['book-import' => $file]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseCount('books', 48);
    }

    public function testBuyerCanNotImportBooks()
    {
        $user = factory(User::class)->create(['role_id' => '3']);
        $file = UploadedFile::fake()->createWithContent('ImportBookOk.xlsx', file_get_contents(base_path('tests/Stubs/ImportBookOk.xlsx')));

        $response = $this->actingAs($user)->post(route('books.import'), ['book-import' => $file]);

        $response->assertForbidden();
        $this->assertDatabaseCount('books', 0);
    }

    public function testNonAuthenticatedUserCanNotImportBooks()
    {
        $file = UploadedFile::fake()->createWithContent('ImportBookOk.xlsx', file_get_contents(base_path('tests/Stubs/ImportBookOk.xlsx')));

        $response = $this->post(route('books.import'), ['book-import' => $file]);

        $response->assertRedirect(route('verification.notice'));
        $this->assertDatabaseCount('books', 0);
    }

    public function testImportFailsDueToValidationErrors()
    {
        $user = factory(User::class)->create(['role_id' => '1']);
        $file = UploadedFile::fake()->createWithContent('ImportBookFail.xlsx', file_get_contents(base_path('tests/Stubs/ImportBookFail.xlsx')));

        $response = $this->actingAs($user)->post(route('books.import'), ['book-import' => $file]);

        $response->assertRedirect();
        $response->assertSessionHasErrors();
        $this->assertDatabaseCount('books', 0);
    }
}
