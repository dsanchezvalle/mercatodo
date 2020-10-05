@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-center">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <h2 class="card-title">Successful payment!</h2>
                    <h1>
                    <svg style="filter: invert(39%) sepia(95%) saturate(1073%) hue-rotate(85deg) brightness(112%) contrast(82%);" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check-circle" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
                    </svg>
                    </h1>
                    <p class="card-text"> Your order with reference: {{$reference}} has been received. </p>
                    <p><b>You will enjoy your favorite book(s) soon... :)</b></p>
                    <a href="{{route('bookshelf')}}" class="btn btn-primary">Continue shopping</a>
                    <a href="{{ route('order.list') }}" class="btn btn-secondary">Check your orders</a>
                </div>

            </div>
    </div>






</div>

@endsection
