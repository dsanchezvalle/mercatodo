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
            <hr>
        </div>
            <div class="m-2 row justify-content-center align-content-center">
                <h2>Find the perfect Book for you!</h2>
            </div>

            <div class="card-group row row-cols-lg-5 row-cols-2">
            @foreach($books as $book)
                <div class="col mb-4">
                    <div class="card">
                        <img src="{{$book->image_path}}" class="card-img-top" alt="book-cover">
                        <div class="card-body">
                            <h5 class="card-title">{{ $book->title }}</h5>
                            <p class="card-text">Author: {{ $book->author }}</p>
                            <p class="card-text">Price: {{ $book->formattedPrice($book->price) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>

        {{ $books->withQueryString()->links() }}
</div>
@endsection
