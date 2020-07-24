@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header h4">Find the perfect Book for you! </div>

                <div class="card-body">
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
                    </table>
                    {{ $books->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
