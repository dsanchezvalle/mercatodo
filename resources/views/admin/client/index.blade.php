@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header h4">Clients' Dashboard </div>

                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>Name</th>
                            <th>Document</th>
                            <th>E-mail</th>
                            <th class="text-center">Phone Number</th>
                            <th class="text-center">Role</th>
                            <th class="text-center">Active</th>
                            <th></th>
                        </tr>
                        @foreach($clients as $client)
                            <tr>
                                <td><a href="{{ route('clients.show', $client) }}">{{ $client->name  }} {{ $client->surname }}</a></td>
                                <td>{{ $client->document_type }} {{ $client->document_number }}</td>
                                <td>{{ $client->email }}</td>
                                <td class="text-center">{{ $client->phone_number }}</td>
                                <td class="text-center">{{ $client->role_id }}</td>
                                <td class="text-center @if($client->is_active) text-success @else text-danger @endif">{{ $client->isActive() }}</td>
                                <td><a href="{{ route('clients.edit', $client) }}">Edit</a></td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $clients->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
