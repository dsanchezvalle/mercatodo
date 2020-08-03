<div>
    <form action="{{ $route }}" method="get">
        <div class="form-group row">
            <label for="author" class="col-md-4 col-form-label text-md-right">{{ __('Author') }}</label>
            <div class="col-md-6">
                <input
                    id="author"
                    type="text"
                    class="form-control @error('filter.author') is-invalid @enderror"
                    name="filter[author]"
                    value="{{ old('filter.author',request('filter.author')) }}"
                    placeholder="Type the author"
                >

                @error('filter.author')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
            <div class="col-md-6">
                <input
                    id="title"
                    type="text"
                    class="form-control @error('filter.title') is-invalid @enderror"
                    name="filter[title]"
                    value="{{ old('filter.title',request('filter.title')) }}"
                    placeholder="Type the title"
                >

                @error('filter.title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <label for="isbn" class="col-md-4 col-form-label text-md-right">{{ __('ISBN') }}</label>

            <div class="col-md-6">
                <input
                    id="isbn"
                    type="text"
                    class="form-control @error('filter.isbn') is-invalid @enderror"
                    name="filter[isbn]"
                    value="{{ old('filter.isbn',request('filter.isbn')) }}"
                    placeholder="Type the ISBN"
                >

                @error('filter.isbn')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            @if($route === route('books.index'))
                <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Book status') }}</label>
                <div class="col-md-6">
                    <table>
                        <tr class="mt-2">
                            <td>
                                <label for="active">Active</label>
                                <input type="radio" id="active" name="filter[status]" value= "true" @if(old('filter.status',request('filter.status')) == 'true') checked @endif>
                            </td>
                            <td>
                                <label for="inactive">Inactive</label>
                                <input type="radio" id="inactive" name="filter[status]" value="false"  @if(old('filter.status',request('filter.status')) == 'false') checked @endif>
                            </td>
                        </tr>
                    </table>

                </div>
            @endif
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="btn-group btn-group-sm">
                    <button type="submit" class="btn btn-success">
                        {{__('Search')}}
                    </button>
                    <a href="{{ $route }}" class="btn btn-link">
                        {{ __('Clear') }}
                    </a>
                </div>
            </div>
        </div>

    </form>
</div>
