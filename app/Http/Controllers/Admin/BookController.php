<?php

namespace App\Http\Controllers\Admin;

use App\Book;
use App\Http\{Controllers\Controller, Requests\BookFilterRequest, Requests\BookRequest};
use Carbon\Carbon;
use Illuminate\{
    Contracts\Foundation\Application,
    Http\RedirectResponse,
    Http\Response,
    Routing\Redirector,
    Support\Facades\DB,
    Support\Facades\Log,
    View\View
};

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
     * @param  BookFilterRequest $request
     * @return Response
     */
    public function index(BookFilterRequest $request): Response
    {
        $books = Book::author($request->input('filter.author'))
            ->title($request->input('filter.title'))
            ->isbn($request->input('filter.isbn'))
            ->status($request->input('filter.status'))
            ->paginate(config('view.paginate'));

        return response()->view('admin.book.index', compact('books'));
    }

    /**
     * Show the form for creating a new Book.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.book.create');
    }

    /**
     * Store a newly created Book.
     *
     * @param BookRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(BookRequest $request)
    {
        if (!request()->file) {
            return redirect('/books/create')
                ->withInput($request->all())
                ->withErrors(['file' => 'You need to add a book cover image.']);
        }
        $imagePath = $this->get_image_path();
        $this->store_image($imagePath);

        Book::create(
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
        return response()->redirectToRoute('books.index');
    }

    /**
     * Display the specified Book in storage.
     *
     * @param  Book $book
     * @return Response
     */
    public function show(Book $book): Response
    {
        Log::channel('single')->notice("User with ID " . auth()->user()->id . " has accessed to details for book with ID " . $book->id);
        return response()->view('admin.book.show', compact('book'));
    }

    /**
     * Show the form for editing the specified Book.
     *
     * @param  Book $book
     * @return Response
     */
    public function edit(Book $book): Response
    {
        return response()->view('admin.book.edit', compact('book'));
    }

    /**
     * Update the specified Book in storage.
     *
     * @param  BookRequest $request
     * @param  Book        $book
     * @return RedirectResponse
     */
    public function update(BookRequest $request, Book $book): RedirectResponse
    {
        if (request()->file) {
            $imagePath = $this->get_image_path();
            $this->store_image($imagePath);
            unlink(storage_path() . '/app' . $book->image_path);
        } else {
            $imagePath = $book->image_path;
        }

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

        return response()->redirectToRoute('books.index');
    }

    /**
     * Store book cover image.
     *
     * @param string $imagePath
     * @return mixed
     */
    public function store_image(string $imagePath)
    {
        return request()->file->storeAs('uploads', $this->get_image_name($imagePath));
    }

    /**
     * @return string
     */
    public function get_image_path(): string
    {
        $timeStamp = Carbon::now()->format('YmdHisu');
        $adminId = auth()->user()->id;
        $fileExtension = request()->file->extension();

        return '/uploads/' . $timeStamp . '_' .  $adminId . '.' . $fileExtension;
    }

    /**
     * @param string $image_path
     * @return string
     */
    public function get_image_name(string $image_path): string
    {
        $trimmed = trim($image_path, "/uploads/.");
        return $trimmed;
    }
}
