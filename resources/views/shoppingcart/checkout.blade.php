@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <a href="{{ route('cart.payment') }}">Pay</a>
                </div>
            </div>
        </div>
    </div>
@endsection
