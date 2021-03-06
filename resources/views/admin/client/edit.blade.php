@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Editing client</div>

                <div class="card-body">
                    <form action="/clients/{{$client->id}}" method="POST">
                        @method('PUT')
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $client->name) }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('Surname') }}</label>

                            <div class="col-md-6">
                                <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname', $client->surname) }}" required autocomplete="surname" autofocus>

                                @error('surname')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="document_type" class="col-md-4 col-form-label text-md-right">{{ __('Document type') }}</label>

                            <div class="col-md-6">
                                <select id="document_type"class="form-control @error('document_type') is-invalid @enderror" name="document_type" required autofocus>
                                    <option value="CC" @if($client->document_type === 'CC') selected @endif>Cédula de Ciudadanía</option>
                                    <option value="CE" @if($client->document_type === 'CE') selected @endif>Cédula de Extranjería</option>
                                    <option value="PP" @if($client->document_type === 'PP') selected @endif>Pasaporte</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="document_number" class="col-md-4 col-form-label text-md-right">{{ __('Document number') }}</label>

                            <div class="col-md-6">
                                <input id="document_number" type="text" class="form-control @error('document_number') is-invalid @enderror" name="document_number" value="{{old('document_number', $client->document_number)}}" required autocomplete="document_number" autofocus>

                                @error('document_number')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email',$client->email) }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone_number" class="col-md-4 col-form-label text-md-right">{{ __('Phone number') }}</label>

                            <div class="col-md-6">
                                <input id="phone_number" type="phone_number" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{old('phone_number', $client->phone_number)}}" required autocomplete="phone_number">

                                @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>
                            <div class="col-md-6">
                                <select class="form-control" id="role_id" type="role_id" class="form-control" @error('role_id') is-invalid @enderror name="role_id" >
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" @if($client->role_id == $role->id) selected="selected" @endif>
                                            {{ $role->name }}
                                            </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="is_active" class="col-md-4 col-form-label text-md-right">{{ __('User status') }}</label>

                            <div class="col-md-6">
                                <table>
                                    <tr class="mt-2">
                                        <td class="pr-2">Disable</td>
                                        <td class="custom-control custom-switch justify-content-center">
                                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" @if($client->isActive() === 'Yes') checked @endif>
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
