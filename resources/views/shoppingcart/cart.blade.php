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
                                            <button class="btn btn-outline-danger btn-sm" type="submit">Delete</button>
                                        </form></td>

                                    </tr>
                                @endforeach

                            </table>
                            <button class="btn btn-primary justify-content-end">Proceed to checkout</button>
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
