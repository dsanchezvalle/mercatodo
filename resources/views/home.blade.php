@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h4">Bienvenido a MercaTodo</div>

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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
