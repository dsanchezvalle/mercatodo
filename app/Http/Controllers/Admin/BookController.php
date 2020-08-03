<?php

namespace App\Http\Controllers\Admin;

use App\Book;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookFilterRequest;
use App\Http\Requests\BookRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

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
     * @param BookFilterRequest $request
     * @return Response
     */
    public function index(BookFilterRequest $request)
    {
        $books = Book::author($request->input('filter.author'))
            ->title($request->input('filter.title'))
            ->isbn($request->input('filter.isbn'))
            ->status($request->input('filter.status'))
            ->paginate(config('view.paginate'));

        return response()->view('admin.book.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
       return view('admin.book.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BookRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(BookRequest $request)
    {
        if(!request()->file) {
            return redirect('/books/create')
                ->withInput($request->all())
                ->withErrors(['image' => 'You need to add a book cover image.']);
        }
        $this->store_image();

        Book::create([
            'isbn' => $request->input('isbn'),
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'image_path' => $this->get_image_path(),
            'is_active' => true,
        ]);

        return response()->redirectToRoute('books.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Book $book
     * @return Response
     */
    public function show(Book $book)
    {
        return response()->view('admin.book.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Book $book
     * @return Response
     */
    public function edit(Book $book)
    {
        return response()->view('admin.book.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BookRequest $request
     * @param Book $book
     * @return Response
     */
    public function update(BookRequest $request, Book $book)
    {
       if(request()->file) {
           $imagePath = $this->get_image_path();
            $this->store_image();
            unlink(storage_path().'/app'.$book->image_path);
        }
       else {
           $imagePath = $book->image_path;
       }

       $book->update([
            'isbn' => $request->input('isbn'),
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'image_path' => $imagePath,
            'is_active' => $request->is_active ? true : false,
        ]);


        return response()->redirectToRoute('books.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Book $book
     * @return Response
     */
    public function destroy(Book $book)
    {
        //
    }

    /**
     * Store book cover image.
     * @return mixed
     */
    public function store_image () {
        request()->validate(['file' => 'image']);
        return request()->file->storeAs('uploads', request()->file->getClientOriginalName());
    }


    public function get_image_path() {

        return '/uploads/'.request()->file->getClientOriginalName();
    }

    public function get_image_name(String $image_path){
        $trimmed = trim($image_path, " /uploads/.");
        return $trimmed;
    }
}
