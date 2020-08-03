<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\BookFilterRequest;


class BookController extends Controller
{
    public function bookshelf(BookFilterRequest $request)
    {
        $books = Book::author($request->input('filter.author'))
            ->title($request->input('filter.title'))
            ->isbn($request->input('filter.isbn'))
            ->paginate(config('view.paginate'));

        return response()->view('book.bookshelf', compact('books'));
    }
}
