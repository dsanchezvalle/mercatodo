<?php

namespace App\Http\Controllers\Api;

use App\Book;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookResourceCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $books = Book::paginate(10);
        return (new BookResourceCollection($books))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BookRequest $request
     * @return JsonResponse
     */
    public function store(BookRequest $request): JsonResponse
    {
        $book = Book::create(
            [
                'isbn' => $request->input('isbn'),
                'title' => $request->input('title'),
                'author' => $request->input('author'),
                'price' => $request->input('price'),
                'stock' => $request->input('stock'),
                'image_path' => $request->input('image_path'),
                'is_active' => true,
            ]
        );
        $idLastBookCreated = DB::table('books')->latest('id')->first()->id;

        Log::channel('single')
            ->notice("A new book with ID " . $idLastBookCreated . " has been created successfully by admin with ID: " . $request->user()->id);
        Log::channel('slack')
            ->notice("A new book has been created successfully. Find it at:  http://mercatodo.test/books/" . $idLastBookCreated);
        return (new BookResource($book))->response();
    }

    /**
     * Display the specified resource.
     *
     * @param Book $book
     * @return JsonResponse
     */
    public function show(Book $book): JsonResponse
    {
        return (new BookResource($book))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BookRequest $request
     * @param Book $book
     * @return JsonResponse
     */
    public function update(BookRequest $request, Book $book): JsonResponse
    {
        $book->update(
            [
                'isbn' => $request->input('isbn'),
                'title' => $request->input('title'),
                'author' => $request->input('author'),
                'price' => $request->input('price'),
                'stock' => $request->input('stock'),
                'image_path' => $request->input('image_path'),
                'is_active' => $request->is_active ? true : false,
            ]
        );

        Log::channel('single')
            ->notice("The book with ID " . $book->id . " has been updated successfully by admin with ID: " . $request->user()->id);

        return (new BookResource($book))->response();
    }
}
