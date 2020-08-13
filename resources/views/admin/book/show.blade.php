@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header h4">Book information</div>

                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <tr>
                            <td class="font-weight-bold">ISBN: </td>
                            <td> {{ $book->isbn }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Book title: </td>
                            <td>{{ $book->title }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Author: </td>
                            <td>{{ $book->author }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Price: </td>
                            <td>{{ $book->formattedPrice($book->price) }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Stock: </td>
                            <td>{{ $book->stock }}</td>
                        </tr>

                        <tr>
                            <td class="font-weight-bold">Book cover: </td>
                            <td><img src="{{$book->image_path}}" class="img-thumbnail" alt="Book cover" width="250" height="400"></td>
                        </tr>

                        <tr>
                            <td class="font-weight-bold">Book status: </td>
                            <td>{{ $book->is_active ? 'Active':'Inactive' }}</td>
                        </tr>
                    </table>
                    <a href="{{route('books.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
