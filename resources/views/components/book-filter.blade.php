<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <form action="{{ $route }}" method="get">
            <div class="row">
                <div class="form-group col">
                    <label for="author">{{ __('Author') }}</label>
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

                <div class="form-group col">
                    <label for="title">{{ __('Title') }}</label>
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

                <div class="form-group col">
                    <label for="isbn"w>{{ __('ISBN') }}</label>
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
                    <div class="card">
                        <div class="form-group col">
                            <label for="status">{{ __('Book status') }}</label>
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
                    </div>
                @endif


            </div>

            <div class="form-group row justify-content-center">
                <div class="justify-content-center">
                    <div class="btn-group btn-group-sm">
                        <button type="submit" class="btn btn-success">
                            {{__('Search')}}
                        </button>
                    </div>
                    <div class="btn-group btn-group-sm">
                        <a href="{{ $route }}" class="btn btn-link">
                            {{ __('Clear') }}
                        </a>
                    </div>
                </div>
            </div>

        </form>
      </div>
    </div>
