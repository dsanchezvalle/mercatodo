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
            <hr>
            <div class="card">
                <div class="card-header h4">Books' dashboard </div>
                <div class="card-body">
                    @can('viewAny', \App\Book::class)
                        <div class="pb-4">
                            <a href="{{ route('books.create') }}" class="btn btn-primary">Create New Book</a>
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
                                    <td class="text-center">$ {{ $book->price }}</td>
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
