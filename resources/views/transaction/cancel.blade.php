@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header h4"> Your Shopping Cart </div>
                <div class="card-body">
                    <h3> Your payment has been rejected. :( </h3>
                    <p> Reference: {{$reference}} </p>
                    <br>
                    <a href="{{ route('cart.checkout', ['reference' => $reference]) }}" class="btn btn-primary">Try again</a>
                    <a href="{{ route('order.list') }}" class="btn btn-secondary">Check your orders</a>
                </h3>

            </div>
        </div>
    </div>






</div>

@endsection
