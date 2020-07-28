<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class BookController extends Controller
{

    /**
     * BookController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Book::class, 'book');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::paginate(config('view.paginate'));

        return response()->view('book.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('book.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $book = new Book();

        $validatedData = $request->validate([
            'isbn' => ['required', 'string', 'min:10', 'max:13', Rule::unique('books')->ignore($book)],
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'max:500000'],
            'stock' => ['required', 'numeric', 'max:1000', ],
            'image_path' => ['required', 'url'],
        ]);

        $book->create([
            'isbn' => $validatedData['isbn'],
            'title' => $validatedData['title'],
            'author' => $validatedData['author'],
            'price' => $validatedData['price'],
            'stock' => $validatedData['stock'],
            'image_path' => $validatedData['image_path'],
            'is_active' => true,
        ]);


        return response()->redirectToRoute('books.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return response()->view('book.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        return response()->view('book.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
       $validatedData = $request->validate([
            'isbn' => ['required', 'string', 'min:10', 'max:13', Rule::unique('books')->ignore($book)],
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'max:500000'],
            'stock' => ['required', 'numeric', 'max:1000', ],
            'image_path' => ['required', 'url'],
        ]);

        $book->update([
            'isbn' => $validatedData['isbn'],
            'title' => $validatedData['title'],
            'author' => $validatedData['author'],
            'price' => $validatedData['price'],
            'stock' => $validatedData['stock'],
            'image_path' => $validatedData['image_path'],
            'is_active' => $request->is_active ? true : false,
        ]);

        return response()->redirectToRoute('books.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
    }
}
