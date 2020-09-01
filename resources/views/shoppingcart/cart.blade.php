@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header h4"> Your Cart details </div>

                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>Book ISBN</th>
                            <th>Title</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Amount</th>
                            <th></th>
                        </tr>
                        <input type="hidden" value="{{ $total = 0 }}">
                        <p>Hi {{Auth::user()->name}} !</p>
                        <p>: {{Auth::user()->id}} </p>
                        {{$cart_details->first()}}

                        @foreach($cart_details as $cart_detail)
                            @if($cart_detail->shopping_cart_id == 2 )

                                <tr>
                                    <td>{{$cart_detail->book ['isbn']}}</td>
                                    <td>{{$cart_detail->book ['title']}}</td>
                                    <td>{{ $cart_detail->quantity}}</td>
                                    <td>{{ $cart_detail->formattedPrice($cart_detail->unit_price)}}</td>
                                    <td>{{ $cart_detail->formattedPrice($cart_detail->quantity * $cart_detail->unit_price)}}</td>
                                </tr>
                                <input type="hidden" value="{{$total += ($cart_detail->quantity * $cart_detail->unit_price) }}">
                            @endif
                        @endforeach
                        <div><p> Total: {{$total}}</p> </div>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
