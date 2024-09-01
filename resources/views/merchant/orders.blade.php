@extends('layouts.merchant')

@section('content')
<div class="container mt-5">
    <h1>Your Orders</h1>

    @if($orders->isEmpty())
    <p>No orders found.</p>
    @else
    <ul class="list-group">
        @foreach ($orders as $order)
        <li class="list-group-item">
            <h5>Order #{{ $order->id }}</h5>
            <p>Menu: {{ $order->menu->name }}</p>
            <p>Quantity: {{ $order->quantity }}</p>
            <p>Delivery Date: {{ $order->delivery_date }}</p>
            <p>Status: {{ $order->status }}</p>
            <a href="{{ route('merchant.order.details', $order->id) }}" class="btn btn-info">View Details</a>

            @if($order->status === 'paid')
            <form action="{{ route('merchant.order.deliver', $order->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-success">Deliver</button>
            </form>
            @endif
        </li>
        @endforeach
    </ul>
    @endif
</div>
@endsection