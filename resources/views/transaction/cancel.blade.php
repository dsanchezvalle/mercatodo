@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-center">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <h2 class="card-title">Your payment has been rejected. :(</h2>
                    <h1>
                        <svg style="filter: invert(17%) sepia(51%) saturate(5437%) hue-rotate(355deg) brightness(91%) contrast(89%);" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x-circle" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                        </svg>
                    </h1>
                    <p class="card-text"> Your payment with reference: {{$reference}} has been rejected. </p>
                    <p><b>Don't worry, you can... </b></p>
                    <a href="{{ route('transaction.retry', ['reference' => $reference]) }}" class="btn btn-primary">Retry</a>
                    <a href="{{ route('order.list') }}" class="btn btn-secondary">Check your orders</a>
                </div>

            </div>
    </div>






</div>

@endsection
