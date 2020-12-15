@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header h4 d-inline-block"> Book information </div>
                <div class="card-body">
                    <div>
                        <form action="/cart/{{$book->id}}" method="POST">
                            @csrf
                            <div>
                                <input type="number" min="1" name="items" id="items" class="form-control form-control-sm col-1 d-inline-block" value="1">
                                <button class="btn btn-outline-primary btn-sm d-inline-block" type="submit">Add to Cart</button>
                                <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">Back</a>
                            </div>
                        </form>
                    </div>
                    <br>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
