@extends('layouts.app')

@section('content')
<h2>
    <strong>Mercatodo - Orders Report</strong>
</h2>
<p>From {{ $fromDate }} to {{ $toDate }}</p>

<p>
    <strong>Order Status Resume</strong>
</p>
<table border="1" style="height: 44px; width: 58.7177%; border-collapse: collapse; margin-left: auto; margin-right: auto;" height="44">
    <tbody>
        <tr>
            <td style="width: 50%; text-align: center;"><strong>Order status</strong></td>
            <td style="width: 50%; text-align: center;"><strong>Orders</strong></td>
        </tr>
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
<br>
<p>
    <strong>Orders Details</strong>
</p>
<table class="table" border="1" style="border-collapse: collapse; width: 100%; height: 63px;">
    <thead class="thead-dark">
        <tr style="height: 21px;">
            <td scope="col" style="width: 15.268%; height: 21px; text-align: center;"><strong>Order ID</strong></td>
            <td scope="col" style="width: 25.6993%; text-align: center; height: 21px;"><strong>Date/Time</strong></td>
            <td scope="col" style="width: 25.6993%; height: 21px; text-align: center;"><strong>Status</strong></td>
            <td scope="col" style="width: 33.3333%; height: 21px; text-align: center;"><strong>Amount</strong></td>
        </tr>
    </thead>
    <tbody>
        @if(count($orders)>0)
            @foreach ($orders as $order)
                <tr style="height: 21px;">
                    <td style="width: 15.268%; height: 21px; text-align: center;">{{$order->id}}</td>
                    <td style="width: 25.6993%; height: 21px; text-align: center;">{{$order->created_at}}</td>
                    <td style="width: 25.6993%; height: 21px; text-align: center;">{{ $order->paymentStatus() }}</td>
                    <td style="width: 33.3333%; height: 21px; text-align: center;">{{ $order->formattedPrice($order->total_amount) }}</td>
                </tr>
            @endforeach
        @else
            <tr style="height: 21px;">
                <td colspan="4" style="text-align: center"> There are no orders in this date range. </td>
            </tr>
        @endif
    </tbody>
</table>

@endsection

