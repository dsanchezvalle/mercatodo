@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header h4"> Your Shopping Cart </div>
                @if($userCart != null and count($userCart->books)>0)
                   <div class="card-body">
                        <table class="table table-striped table-hover">
                            <tr>
                                <th>Book ISBN</th>
                                <th>Title</th>
                                <th class="text-center">Unit Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Amount</th>
                                <th></th>
                            </tr>
                            <h4>Hi {{Auth::user()->name}} !</h4>

                            @foreach($userCart->books as $book)
                                <tr>
                                    <td>{{$book->isbn}}</td>
                                    <td>{{$book->title}} </td>
                                    <td class="text-center">{{ $book->formattedPrice($book->pivot->unit_price)}}</td>
                                    <td class="text-center">{{$book->pivot->quantity}}</td>
                                    <td class="text-center">{{ $book->formattedPrice($book->pivot->quantity * $book->pivot->unit_price)}}</td>
                                    <td class="small"><form action="/cart/{{$book->id}}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-outline-danger btn-sm" type="submit">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                        </button>
                                    </form></td>

                                </tr>
                            @endforeach
                            <tr class="bg-secondary text-white">
                                <td colspan="4" class="text-right p-2"><h6>Subtotal: </h6></td>
                                <td class="text-center p-2"><h5> {{$userCart->getSubtotal()}} </h5></td>
                                <td></td>
                            </tr>
                        </table>
                        <a class="btn btn-outline-primary justify-content-end" href="{{route('bookshelf')}}">
                                   Get more books
                                   <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-book" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                       <path fill-rule="evenodd" d="M1 2.828v9.923c.918-.35 2.107-.692 3.287-.81 1.094-.111 2.278-.039 3.213.492V2.687c-.654-.689-1.782-.886-3.112-.752-1.234.124-2.503.523-3.388.893zm7.5-.141v9.746c.935-.53 2.12-.603 3.213-.493 1.18.12 2.37.461 3.287.811V2.828c-.885-.37-2.154-.769-3.388-.893-1.33-.134-2.458.063-3.112.752zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
                                   </svg>
                        </a>
                        <a class="btn btn-success justify-content-end" href="{{ route('cart.checkout') }}">
                            Proceed to checkout
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cart2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/>
                            </svg>
                        </a>

                   </div>
                @else
                    <br>
                    <p class="alert-info" colspan="5" style="font-size:110%; text-align: center">Ups! Your Shopping Cart is empty. Fill it with your favorite books! :)</p>
                @endif
            </div>
        </div>
    </div>






</div>

@endsection
