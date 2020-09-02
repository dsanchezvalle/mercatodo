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
                                            @csrf
                                            <input type="hidden" name="items" id="items" value="0">
                                            <button class="btn btn-outline-danger btn-sm" type="submit">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                </svg>
                                            </button>
                                        </form></td>

                                    </tr>
                                @endforeach

                            </table>
                            <button class="btn btn-success justify-content-end">
                                Proceed to checkout
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cart2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/>
                                </svg>
                            </button>
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
