<?php

namespace App\Http\Controllers;

use App\Book;
use App\Exports\BooksExport;
use Illuminate\Support\Facades\Gate;

class ExportController extends Controller
{
    public function export(BooksExport $booksExport)
    {
        Gate::authorize('export', Book::class);
        return $booksExport->download('books.xlsx');
    }

}
