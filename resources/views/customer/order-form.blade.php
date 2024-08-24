@extends('layouts.customer')

@section('content')
<div class="container">
    <h1>Order Menu: {{ $menu->name }}</h1>

    <form action="{{ route('customer.order.place') }}" method="POST">
        @csrf
        <input type="hidden" name="menu_id" value="{{ $menu->id }}">

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required min="1">
        </div>

        <div class="mb-3">
            <label for="delivery_address" class="form-label">Delivery Address</label>
            <input type="text" class="form-control" id="delivery_address" name="delivery_address" required>
        </div>

        <button type="submit" class="btn btn-primary">Place Order</button>
    </form>
</div>
@endsection