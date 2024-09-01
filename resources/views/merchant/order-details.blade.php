@extends('layouts.merchant')

@section('content')
<div class="container mt-5">
    <h1>Order Details</h1>

    <div class="card">
        <div class="card-header">
            Order #{{ $order->id }}
        </div>
        <div class="card-body">
            <p><strong>Menu:</strong> {{ $order->menu->name }}</p>
            <p><strong>Quantity:</strong> {{ $order->quantity }}</p>
            <p><strong>Delivery Date:</strong> {{ $order->delivery_date }}</p>
            <p><strong>Delivery Address:</strong> {{ $order->delivery_address }}</p>
            <p><strong>Status:</strong> {{ $order->status }}</p>
            
        </div>
    </div>
</div>
@endsection