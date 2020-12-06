<?php

namespace App\Http\Controllers;

use App\Exports\BooksExport;
use App\Imports\BooksImport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export(BooksExport $booksExport)
    {
        return $booksExport->download('books.xlsx');
    }

}
