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
            <p class="
    @if($order->status === 'pending')
        text-warning
    @elseif($order->status === 'paid')
        text-primary
    @elseif($order->status === 'delivered')
        text-info
    @elseif($order->status === 'confirmed')
        text-success
    @else
        text-secondary
    @endif
">
                Status: {{ ucfirst($order->status) }}
            </p>



            <a href="{{ route('customer.order.details', $order->id) }}" class="btn btn-info">View Details</a>
            @if($order->status === 'confirmed')
            <form action="{{ route('customer.order.destroy', $order->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this order?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>

            @endif


            @if($order->status === 'pending')
            <form action="{{ route('customer.order.checkout', $order->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-primary">Checkout</button>
            </form>
            @endif


            @if($order->status === 'delivered')
            <form action="{{ route('customer.order.confirm', $order->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-success">Confirm Arrival</button>
            </form>
            @endif
        </li>
        @endforeach
    </ul>
    @endif
</div>
@endsection