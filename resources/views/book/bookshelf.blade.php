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
            @if(session('message'))
                <div class="alert alert-success">
                    {{session('message')}}
                    <a class="btn btn-primary btn-sm" href="{{route('cart.index')}}">Cart</a>
                    <button class="btn btn-success btn-sm">
                        Proceed to checkout
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cart2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/>
                        </svg>
                    </button>
                </div>
            @endif
            <div class="card-group row row-cols-lg-5 row-cols-2">
            @foreach($books as $book)
                    <div class="col mb-4 d-flex">
                        <div class="card">
                            <img class="card-img-top" src="{{$book->image_path}}" alt="book-cover">
                            <div class="card-body">
                                <h5 class="card-title">{{ $book->title }}</h5>
                                <p class="card-subtitle mb-2 text-muted">Author: {{ $book->author }}</p>
                                <form action="/cart/{{$book->id}}" method="POST">
                                    @csrf
                                   <div>
                                       <input type="number" min="1" name="items" id="items" class="form-control form-control-sm col-4 d-inline-block" value="1">
                                       <button class="btn btn-outline-primary btn-sm d-inline-block" type="submit">Add to Cart</button>
                                   </div>
                                </form>
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
