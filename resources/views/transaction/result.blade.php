@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-center">
                <div class="card-header">
                </div>
                <div class="card-body">
                    @if($status == 'APPROVED')
                        <h2 class="card-title">Successful payment!</h2>
                        <h1>
                        <svg style="filter: invert(39%) sepia(95%) saturate(1073%) hue-rotate(85deg) brightness(112%) contrast(82%);" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check-circle" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
                        </svg>
                        </h1>
                        <p class="card-text"> Your order with reference: {{$reference}} has been received. </p>
                        <p><b>You will enjoy your favorite book(s) soon... :)</b></p>
                    @elseif ($status == 'PENDING')
                        <h2 class="card-title">Pending payment</h2>
                        <h1>
                            <svg style="filter: invert(61%) sepia(69%) saturate(1340%) hue-rotate(338deg) brightness(86%) contrast(97%);" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-question-circle" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                            </svg>
                        </h1>
                        <p class="card-text"> Your payment with reference: {{$reference}} is pending for approval. </p>
                        <p><b>You can wait some minutes and...</b></p>
                    @endif
                        <a href="{{route('bookshelf')}}" class="btn btn-primary">Continue shopping</a>
                        <a href="{{ route('order.list') }}" class="btn btn-secondary">Check your orders</a>

                </div>

            </div>
    </div>






</div>

@endsection
