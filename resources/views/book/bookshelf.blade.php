@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header h4">{{__('Filters')}}</div>
                <div class="card-body">
                    <x-book-filter route="{{ route('bookshelf') }}"></x-book-filter>
                </div>
            </div>

        </div>
        <div class="m-2 row justify-content-center align-content-center">
            <h2>Find the perfect Book for you!</h2>
        </div>

        @if(count($books)>0)
            <div class="card-group row row-cols-lg-5 row-cols-2">
            @foreach($books as $book)
                    <div class="col mb-4 d-flex">
                        <div class="card">
                            <img class="card-img-top" src="{{$book->image_path}}" alt="book-cover">
                            <div class="card-body">
                                <h5 class="card-title">{{ $book->title }}</h5>
                                <p class="card-subtitle mb-2 text-muted">Author: {{ $book->author }}</p>
                                <button href="#" class="btn btn-outline-primary btn-sm" name="addbook" value="addbook" type="submit">Add to Cart</button>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Price: {{ $book->formattedPrice($book->price) }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
        @else
            <p class="alert-info" colspan="5" style="font-size:110%; text-align: center">There are no books to show. Try another filter.</p>
        @endif

        </div>
        <div class="m-2 row justify-content-center align-content-center">
            {{ $books->withQueryString()->links() }}
        </div>
    </div>
@endsection
