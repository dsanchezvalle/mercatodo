@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header h4">{{__('Filters')}}</div>
                <div class="card-body">
                    <form action="{{ route('books.index') }}" method="get">
                        <div class="form-group row">
                            <label for="author" class="col-md-4 col-form-label text-md-right">{{ __('Author') }}</label>

                            <div class="col-md-6">
                                <input
                                    id="author"
                                    type="text"
                                    class="form-control @error('filter.author') is-invalid @enderror"
                                    name="filter[author]"
                                    value="{{ old('filter.author',request('filter.author')) }}"
                                    placeholder="Type the author"
                                >

                                @error('filter.author')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                            <div class="col-md-6">
                                <input
                                    id="title"
                                    type="text"
                                    class="form-control @error('filter.title') is-invalid @enderror"
                                    name="filter[title]"
                                    value="{{ old('filter.title',request('filter.title')) }}"
                                    placeholder="Type the title"
                                >

                                @error('filter.title')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="btn-group btn-group-sm">
                                    <button type="submit" class="btn btn-success">
                                        {{__('Search')}}
                                    </button>
                                    <a href="{{route('books.index')}}" class="btn btn-link">
                                        {{ __('Clear') }}
                                    </a>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <hr>
            <div class="card">
                <div class="card-header h4">Find the perfect Book for you! </div>
                @can('viewAny', \App\Book::class)
                    <div class="m-2">
                        <a href="{{ route('books.create') }}" class="btn btn-primary">Create New Book</a>
                    </div>
                @endcan
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
