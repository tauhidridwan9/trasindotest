@extends('layouts.customer')

@section('content')
<div class="container mt-5">
    <h1>Create Order</h1>

    <div class="row">
        <div class="col-6">
            <img src="{{ asset('storage/' . $menu->photo) }}" class="card-img-top" alt="{{ $menu->name }}">
        </div>
        <div class="col-6">
            <div class="card-body">
                <h5 class="card-title">{{ $menu->name }}</h5>
                <p class="card-text">{{ $menu->description }}</p>
                <p class="card-text"><strong>Price:</strong> Rp. {{ number_format($menu->price, 0, ',', '.') }}</p>
                <form action="{{ route('customer.order.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">




                    <div class="form-group mb-2">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="address">alamat</label>
                        <input type="text" name="delivery_address" id="delivery_address" class="form-control" required>
                    </div>
                    <div class="form-group mb-5">
                        <label for="delivery_date">Delivery Date</label>
                        <input type="date" name="delivery_date" id="delivery_date" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Place Order</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection