@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h4">Welcome to MercaTodo</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!

                    @can('viewAny', \App\User::class)
                        <div class="m-2">
                            <a href="{{ route('clients.index') }}" class="btn btn-primary">Clients' Dashboard</a>
                        </div>
                    @endcan

                    @can('viewAny', \App\Book::class)
                        <div class="m-2">
                            <a href="{{ route('books.index') }}" class="btn btn-primary">Books' Dashboard</a>
                        </div>
                    @endcan

                    @can('viewAny', \App\Book::class)
                        <div class="m-2">
                            <a href="{{ route('bookshelf') }}" class="btn btn-primary">Bookshelf</a>
                        </div>
                    @endcan

                    @can('viewAny', \App\Order::class)
                        <div class="m-2">
                            <a href="{{route('order.list')}}" class="btn btn-primary">My orders</a>
                        </div>
                    @endcan

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
