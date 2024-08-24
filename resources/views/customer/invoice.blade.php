@extends('layouts.customer')

@section('content')
<div class="container">
    <h1>Invoice</h1>
    <p>Order ID: {{ $order->id }}</p>
    <p>Menu: {{ $order->menu->name }}</p>
    <p>Quantity: {{ $order->quantity }}</p>
    <p>Delivery Date: {{ $order->delivery_date }}</p>
    <p>Total Price: {{ $order->menu->price * $order->quantity }}</p>
</div>
@endsection