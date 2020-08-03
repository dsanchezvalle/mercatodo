@extends('layouts.app')

@section('content')

    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header h4">{{__('Filters')}}</div>
                <div class="card-body">
                    <x-book-filter route="{{ route('bookshelf') }}"></x-book-filter>
                </div>
            </div>
            <hr>
        </div>
        <div class="row row-cols-lg-5 row-cols-2">
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
</div>
@endsection
