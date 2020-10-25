<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportBooksRequest;
use App\Imports\BooksImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function importForm()
    {
        return view('admin.book.importer');
    }

    public function import(ImportBooksRequest $request)
    {
        Excel::import(new BooksImport, $request->file('book-import'));

        return redirect('importer')->with('success', 'All good!');
    }
}
