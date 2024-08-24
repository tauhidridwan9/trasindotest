@extends('layouts.customer')
@section('content')
<div class="container mt-5">
    <h1>Create Order</h1>
    <form action="{{ route('customer.order.store') }}" method="POST">
        @csrf
        <input type="hidden" name="menu_id" value="{{ $menu_id }}">
        <div class="form-group">
            <label for="menu_id">Menu</label>
            <select name="menu_id" id="menu_id" class="form-control">
                @foreach ($menus as $menu)
                <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
        </div>

        <div class="form-group">
            <label for="delivery_date">Delivery Date</label>
            <input type="date" name="delivery_date" id="delivery_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="delivery_address">Delivery address</label>
            <input type="text" name="delivery_address" id="delivery_address" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-5">Place Order</button>
    </form>
</div>
@endsection