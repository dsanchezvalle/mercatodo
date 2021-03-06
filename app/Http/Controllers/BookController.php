<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\BookFilterRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    /**
     * @param BookFilterRequest $request
     * @return Response
     */
    public function bookshelf(BookFilterRequest $request): Response
    {
        Log::channel('single')
            ->notice("User with ID " . $request->user()->id . " has arrived at the Bookshelf.");

        $books = Book::author($request->input('filter.author'))
            ->title($request->input('filter.title'))
            ->isbn($request->input('filter.isbn'))
            ->status('true')
            ->paginate(config('view.paginate'));

        return response()->view('book.bookshelf', compact('books'));
    }
}
