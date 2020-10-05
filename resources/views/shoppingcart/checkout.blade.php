@extends('layouts.app')

@section('content')
    <form action="{{route('cart.payment')}}" method="post">
        @csrf
    <div class="container">
        <div class="card">
            <div class="card-header h4"> Checkout </div>
              <div class="card-group pt-3 pb-3 px-3">
                    <div class="row">
                        <div class="col-9 p-1">
                        <div class="card">
                           <div class="card-header p-2">Shipping details</div>
                           <!-- Billing detail-->
                            <div class="card-body row p-2">
                                <div class="col-12 form-group">
                                    <label for="street">Street <span class="text-danger">*</span></label>
                                    <input class="form-control @error('street') is-invalid @enderror" type="text" value="" id="street" name="street">
                                    @error('street')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="state">State <span class="text-danger">*</span></label>
                                    <input class="form-control @error('state') is-invalid @enderror" type="text" value="" id="state" name="state">
                                    @error('state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="city">City <span class="text-danger">*</span></label>
                                    <input class="form-control @error('city') is-invalid @enderror" type="text" value="" id="city" name="city">
                                    @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="mobile">Mobile</label>
                                    <input class="form-control @error('mobile') is-invalid @enderror" type="text" value="" id="mobile" name="mobile">
                                    @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="country">Country <span class="text-danger">*</span></label>
                                    <select class="custom-select @error('country') is-invalid @enderror" id="country" name="country">
                                        <option selected>Select country</option>
                                        <option value="CO">Colombia</option>
                                    </select>
                                    @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                       </div>
                        </div>
                        <div class="col-3 p-1">
                       <div class="card">
                            <div class="card-header p-2">Order summary</div>
                            <div class="card-body p-2">

                                @foreach($userOrder->books as $book)
                                <div style="flex-wrap: wrap" class="media align-items-center pb-2 mb-2 mr-2 border-bottom"><img class="rounded-sm" width="64" src="{{$book->image_path}}" alt="Book Image">
                                    <div class="media-body pl-2">
                                        <h6> {{ $book->title }} </h6>
                                        <h6><small>Qty: {{$book->pivot->quantity}}</small></h6>
                                        <div class="text-sm-left"><span class="text-muted">{{ $book->formattedPrice($book->price) }}</span></div>
                                    </div>
                                </div>
                                @endforeach
                                <div style="flex-wrap: wrap" >
                                <ul class="list-unstyled font-size-sm py-3">
                                    <li class="d-flex justify-content-between align-items-center"><div class="mr-2">Subtotal:</div><div class="text-right">{{ $userOrder->getFormattedSubtotal() }}</div></li>
                                    <li class="d-flex justify-content-between align-items-center"><div class="mr-2">Taxes:</div><div class="text-right">0.00</div></li>
                                    <li class="d-flex justify-content-between align-items-center font-size-base"><span class="mr-2">Total:</span><span class="text-right font-weight-bolder">{{ $userOrder->getFormattedSubtotal() }}</span></li>
                                </ul>
                                </div>
                            </div>
                       </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <a class="btn btn-primary" href="{{ route('cart.index') }}">
                        Modify your order
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                        </svg>
                    </a>
                    <button class="btn btn-dark" type="submit">
                        Checkout with
                        <img src="/P2P_logo.png" alt="P2P_logo" width="95" height="21">
                    </button>

                </div>
                    <br>
        </div>
    </div>
    </form>
@endsection
