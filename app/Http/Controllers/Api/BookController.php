<?php

namespace App\Http\Controllers\Api;

use App\Book;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::paginate(10);
        return (new BookResourceCollection($books))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        /*if (!request()->file) {
            return redirect('/books/create')
                ->withInput($request->all())
                ->withErrors(['file' => 'You need to add a book cover image.']);
        }*/
        //$imagePath = $this->get_image_path();
        //$this->store_image($imagePath);
        $imagePath = 'http://fakePath.com';
        $book = Book::create(
            [
                'isbn' => $request->input('isbn'),
                'title' => $request->input('title'),
                'author' => $request->input('author'),
                'price' => $request->input('price'),
                'stock' => $request->input('stock'),
                'image_path' => $imagePath,
                'is_active' => true,
            ]
        );
        $idLastBookCreated = DB::table('books')->latest('id')->first()->id;
        Log::channel('single')
            ->notice("A new book with ID " . $idLastBookCreated . " has been created successfully by admin with ID: " . $request->user()->id);
        Log::channel('slack')
            ->notice("A new book has been created successfully. Find it at:  http://mercatodo.test/books/" . $idLastBookCreated);
        return (new BookResource($book))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return (new BookResource($book))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request, Book $book)
    {
        /*if (request()->file) {
            $imagePath = $this->get_image_path();
            $this->store_image($imagePath);
            unlink(storage_path() . '/app' . $book->image_path);
        } else {
            $imagePath = $book->image_path;
        }*/
        $imagePath = 'http://fakePath.com';
        $book->update(
            [
                'isbn' => $request->input('isbn'),
                'title' => $request->input('title'),
                'author' => $request->input('author'),
                'price' => $request->input('price'),
                'stock' => $request->input('stock'),
                'image_path' => $imagePath,
                'is_active' => $request->is_active ? true : false,
            ]
        );

        Log::channel('single')
            ->notice("The book with ID " . $book->id . " has been updated successfully by admin with ID: " . $request->user()->id);

        return (new BookResource($book))->response();
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
