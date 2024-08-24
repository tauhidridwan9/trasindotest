@extends('layouts.customer')
@section('content')
<div class="container mt-5">
    <h1>Your Orders</h1>

    @if($orders->isEmpty())
    <p>You have no orders yet.</p>
    @else
    <ul class="list-group">
        @foreach ($orders as $order)
        <li class="list-group-item">
            <h5>Order #{{ $order->id }}</h5>
            <p>Menu: {{ $order->menu->name }}</p>
            <p>Quantity: {{ $order->quantity }}</p>
            <p>Delivery Date: {{ $order->delivery_date }}</p>
            <p>Status: {{ $order->status }}</p>
            <a href="{{ route('customer.order.details', $order->id) }}" class="btn btn-info">View Details</a>
        </li>
        @endforeach
    </ul>
    @endif
</div>
@endsection