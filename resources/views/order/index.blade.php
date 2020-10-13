@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header h4">Your orders</div>
                <div class="card-body">
                    <div class="container my-4">
                       <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center" scope="col">Order ID</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Order Status</th>
                                    <th scope="col">Details</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($orders)>0)
                                    @foreach($orders as $order)
                                        <tr class="accordion-toggle collapsed" id="accordion{{$order->id}}" data-toggle="collapse" data-parent="#accordion{{$order->id}}" href="#collapse{{$order->id}}">
                                            <td class="text-center">{{$order->id}}</td>
                                            <td>{{ $order->formattedPrice($order->total_amount) }}</td>
                                            <td class="@if($order->isApproved()) text-success @elseif ($order->isPending()) text-black-50 @else text-danger @endif">{{ $order->paymentStatus() }}</td>
                                            <td style="width: 15%;" class="expand-button">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-bar-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5zM8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6z"/>
                                                </svg>
                                                View details
                                            </td>
                                            @if($order->retryPayment())
                                                <td style="width: 10%;">
                                                    <a onclick="event.stopPropagation();" href="{{route('transaction.retry', $order->transactions->first()->reference)}}" class="btn btn-primary btn-sm">Try again</a>
                                                </td>
                                            @else
                                                <td style="width: 10%;"></td>
                                                @endif

                                        </tr>
                                        <tr class="hide-table-padding">
                                            <td class="m-0 p-1" style="width: 25%">
                                                <div id="collapse{{$order->id}}" class="collapse">
                                                    <div class="card">
                                                        <div class="card-header p-2"><b>Order summary</b></div>
                                                        <div class="card-body p-2">

                                                            @foreach($order->books as $book)
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
                                                                    <li class="d-flex justify-content-between align-items-center"><div class="mr-2">Subtotal:</div><div class="text-right">{{ $order->getFormattedSubtotal() }}</div></li>
                                                                    <li class="d-flex justify-content-between align-items-center"><div class="mr-2">Taxes:</div><div class="text-right">0.00</div></li>
                                                                    <li class="d-flex justify-content-between align-items-center font-size-base"><span class="mr-2">Total:</span><span class="text-right font-weight-bolder">{{ $order->getFormattedSubtotal() }}</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="m-0 p-1" colspan="4">
                                                <div id="collapse{{$order->id}}" class="collapse">
                                                    <div class="card">
                                                        <div class="card-header p-2"><b>Transactions summary</b></div>
                                                        <div class="card-body p-1">
                                                            <table class="table table-striped table-hover">
                                                                <tr>
                                                                    <th class="text-center"># Ref</th>
                                                                    <th class="text-center">Status</th>
                                                                    <th class="text-center">Date/Time</th>
                                                                </tr>
                                                                @if(count($order->transactions)>0)
                                                                    @foreach($order->transactions as $transaction)
                                                                        <tr style="font-size: smaller">
                                                                           <td class="text-center">{{ $transaction->reference }}</td>
                                                                           <td class="text-center">{{ $transaction->status }}</td>
                                                                           <td class="text-center">{{ $transaction->created_at }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <td class="alert-info" colspan="7" style="text-align: center">There are no transactions yet.</td>
                                                                @endif
                                                           </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <td class="alert-info" colspan="7" style="text-align: center">There are no orders to show.</td>
                                @endif
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
