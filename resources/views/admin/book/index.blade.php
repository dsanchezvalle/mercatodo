@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header h4">{{__('Filters')}}</div>
                <div class="card-body">
                    <x-book-filter route="{{ route('books.index') }}"></x-book-filter>
                </div>
            </div>

            <div class="card">
                <div class="card-header h4">Books' dashboard </div>
                <div class="card-body">
                    @can('viewAny', \App\Book::class)

                        <div class="pb-4">
                            <a href="{{ route('books.create') }}" class="btn btn-primary">Create New Book</a>
                            <a href="{{ route('books.export') }}" class="btn btn-primary">Export all books</a>
                            <a
                                class="btn btn-primary"
                                data-toggle="collapse"
                                href="#collapse1"
                                role="button"
                                aria-expanded="false"
                                aria-controls="collapse1"
                            >
                                Import books
                            </a>

                            @if(session('success'))
                                <p>
                                    <div class="alert alert-success">
                                        {{
                                            session('success') .
                                            " Created: " . session('booksCreated') .
                                            " Updated: " . session('booksUpdated')
                                        }}
                                    </div>
                                </p>
                            @endif

                            @if ($errors->any())
                                <p>
                                <div class="alert alert-danger pb-0">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                </p>
                            @endif

                            <div class="collapse" id="collapse1">
                                <div class="card-body">


                                    <form action="{{route('books.import')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row align-content-center">
                                            <div class="col">
                                                <input
                                                    id="book-import"
                                                    name="book-import"
                                                    type="file"
                                                    accept="

                                        application/vnd.ms-excel,
                                        application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
                                        "
                                                    class="form-control @error('book-import') is-invalid @enderror"
                                                >
                                            </div>
                                            <div class="col">
                                                <button class="btn btn-primary" type="submit">Import</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    @endcan
                    <table class="table table-striped table-hover">
                        <tr>
                            <th class="text-center">ISBN</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Active</th>
                            <th></th>
                        </tr>

                        @if(count($books)>0)
                            @foreach($books as $book)
                                <tr>
                                    <td class="text-center"><a href="{{ route('books.show', $book) }}">{{ $book->isbn  }} </a></td>
                                    <td>{{ $book->title }}</td>
                                    <td>{{ $book->author }}</td>
                                    <td class="text-center">{{ $book->stock }}</td>
                                    <td class="text-center">{{ $book->getFormattedPrice() }}</td>
                                    <td class="text-center @if($book->is_active) text-success @else text-danger @endif">{{ $book->isActive() }}</td>
                                    <td><a href="{{ route('books.edit', $book) }}">Edit</a></td>
                                </tr>
                            @endforeach
                        @else
                            <td class="alert-info" colspan="7" style="text-align: center">There are no books to show.</td>
                        @endif

                    </table>
                    {{ $books->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
