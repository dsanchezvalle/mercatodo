@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header h4">Import Book List</div>
                <div class="card-body">
                    @if(session('message'))
                        <div class="alert alert-success">
                            {{session('message')}}
                        </div>
                    @endif
                <p>Todo bien!!</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
