@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header h4">Import Book List</div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{session('success')}}
                        </div>
                    @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    <form action="{{route('books.import')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row align-content-center">
                            <div class="col">
                                <input
                                    id="book-import"
                                    name="book-import"
                                    type="file"
                                    accept="

                                        application/vnd.ms-excel,
                                        application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
                                        "
                                    class="form-control @error('book-import') is-invalid @enderror"
                                >
                                @error('book-import')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col">
                                <button class="btn btn-primary" type="submit">Import books</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header h4">Export Books</div>
                    <div class="card-body">
                        <a href="{{ route('books.export') }}" class="btn btn-primary">Export all</a>
                    </div>
            </div>
        </div>
    </div>
</div>

@endsection
