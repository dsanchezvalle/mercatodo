@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header h4">Client information</div>

                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <tr>
                            <td class="font-weight-bold">Client: </td>
                            <td>{{ $client->name . " " . $client->surname }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Document: </td>
                            <td> {{ $client->document_type . " " . $client->document_number }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">E-mail address: </td>
                            <td>{{ $client->email }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Phone number: </td>
                            <td>{{ $client->phone_number }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">User status: </td>
                            <td>{{ $client->is_active ? 'Active':'Inactive' }}</td>
                        </tr>
                    </table>
                    <a href="{{route('clients.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
