<?php

namespace App\Http\Controllers;

use App\Exceptions\ImportValidationException;
use App\Http\Requests\ImportBooksRequest;
use App\Imports\BooksImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function import(ImportBooksRequest $request)
    {
        $import = new BooksImport;
        try{
            Excel::import($import, $request->file('book-import'));
        } catch (ImportValidationException $e){
            return redirect('books')->withErrors($e->errors());
        }

        return redirect('books')->with([
            'success' => 'All good!',
            'booksCreated' => $import->getBooksCreated(),
            'booksUpdated' => $import->getBooksUpdated(),
            ]);
    }
}
