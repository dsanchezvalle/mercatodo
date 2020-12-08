@extends('layouts.reportstyle')

@section('report-content')
    <body>
    <h2>
            <h1>
                <strong>Mercatodo - Orders Report</strong>
            </h1>
    </h2>
    <p>
        <strong>From {{ $fromDate }} to {{ $toDate }}</strong>
        <br><br>
    </p>

    <p>
        <strong>Orders Status Resume</strong>
    </p>
    <div style="line-height: 0.5">
        <table class="table" border="1" style="width: 58.7177%; border-collapse: collapse; margin-left: auto; margin-right: auto;">
        <thead class="thead-dark">
        <tr>
            <th scope="col" style="width: 50%; text-align: center;"><strong>Order status</strong></th>
            <th scope="col" style="width: 50%; text-align: center;"><strong>Orders</strong></th>
        </tr>
        </thead>
        <tbody>

        <tr>
            <td style="width: 50%; text-align: center;">{{__('APPROVED')}}</td>
            <td style="width: 50%; text-align: center;">{{$ordersStatusResume['APPROVED'] ?? '0'}}</td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: center;">{{__('REJECTED')}}</td>
            <td style="width: 50%; text-align: center;">{{$ordersStatusResume['REJECTED'] ?? '0'}}</td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: center;">{{__('PENDING')}}</td>
            <td style="width: 50%; text-align: center;">{{$ordersStatusResume['PENDING'] ?? '0'}}</td>
        </tr>
        </tbody>
    </table>
    </div>
    <br>
    <p>
        <strong>Orders Details</strong>
    </p>
    <div style="line-height: 0.5">
        <table class="table table-striped" style="width: 100%;">
        <thead>
        <tr style="height: 15px;">
            <th scope="col" style="width: 15.268%; text-align: center;"><strong>Order ID</strong></th>
            <th scope="col" style="width: 25.6993%; text-align: center;"><strong>Date/Time</strong></th>
            <th scope="col" style="width: 25.6993%; text-align: center;"><strong>Status</strong></th>
            <th scope="col" style="width: 33.3333%; text-align: center;"><strong>Amount</strong></th>
        </tr>
        </thead>
        <tbody>
        @if(count($orders)>0)
            @foreach ($orders as $order)
                <tr>
                    <th scope="row" style="width: 15.268%; text-align: center;">{{$order->id}}</th>
                    <td style="width: 25.6993%; text-align: center;">{{$order->created_at}}</td>
                    <td style="width: 25.6993%; text-align: center;">{{ $order->paymentStatus() }}</td>
                    <td style="width: 33.3333%; text-align: center;">{{ $order->formattedPrice($order->total_amount) }}</td>
                </tr>
            @endforeach
        @else
            <tr style="height: 21px;">
                <td colspan="4" style="text-align: center"> There are no orders in this date range. </td>
            </tr>
        @endif
        </tbody>
    </table>
    </div>
    </body>
@endsection
