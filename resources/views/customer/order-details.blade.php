@extends('layouts.customer')

@section('content')
<div class="container mt-5">
    <h1>Order Details</h1>

    <table class="table">
        <tr>
            <th>Menu</th>
            <td>{{ $order->menu->name }}</td>
        </tr>
        <tr>
            <th>Quantity</th>
            <td>{{ $order->quantity }}</td>
        </tr>
        <tr>
            <th>Delivery Address</th>
            <td>{{ $order->delivery_address }}</td>
        </tr>
        <tr>
            <th>Delivery Address</th>
            <td>{{ $order->delivery_date }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $order->status }}</td>
        </tr>
    </table>

    <a href="{{ route('customer.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
</div>
@endsection