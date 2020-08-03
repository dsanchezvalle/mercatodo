@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Editing book</div>

                <div class="card-body">
                    <form action="/books/{{$book->id}}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="form-group row">
                            <label for="isbn" class="col-md-4 col-form-label text-md-right">{{ __('ISBN') }}</label>

                            <div class="col-md-6">
                                <input id="isbn" type="text" class="form-control @error('isbn') is-invalid @enderror" name="isbn" value="{{ old('isbn', $book->isbn) }}" required autocomplete="isbn" autofocus>

                                @error('isbn')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $book->title) }}" required autocomplete="title" autofocus>

                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="author" class="col-md-4 col-form-label text-md-right">{{ __('Author') }}</label>

                            <div class="col-md-6">
                                <input id="author" type="text" class="form-control @error('author') is-invalid @enderror" name="author" value="{{ old('author', $book->author) }}" required autocomplete="author" autofocus>

                                @error('author')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('Price') }}</label>

                            <div class="col-md-6">
                                <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{old('price', $book->price)}}" required autocomplete="price" autofocus>

                                @error('price')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="stock" class="col-md-4 col-form-label text-md-right">{{ __('Stock') }}</label>

                            <div class="col-md-6">
                                <input id="stock" type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{old('stock', $book->stock)}}" required autocomplete="stock" autofocus>

                                @error('stock')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="file" class="col-md-4 col-form-label text-md-right">{{ __('Image') }}</label>

                            <div class="col-md-6">
                                <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file" accept="image/*">

                                @error('file')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row">
                            <label for="book_cover" class="col-md-4 col-form-label text-md-right">{{ __('Book cover') }}</label>

                            <div class="col-md-6">
                                <img src="{{$book->image_path}}" class="img-thumbnail" alt="Book cover"  width="250" height="400">
                            </div>

                        </div>

                        <div class="form-group row">
                            <label for="is_active" class="col-md-4 col-form-label text-md-right">{{ __('Book status') }}</label>

                            <div class="col-md-6">
                                <table>
                                    <tr class="mt-2">
                                        <td class="pr-2">Disable</td>
                                        <td class="custom-control custom-switch justify-content-center">
                                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" @if($book->isActive() === 'Yes') checked @endif>
                                            <label class="custom-control-label" for="is_active"></label>
                                        </td>
                                        <td>Enable</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>

                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
