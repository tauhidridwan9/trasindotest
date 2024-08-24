@extends('layouts.customer')@section('content')
<div class="container">
    <h1>Menu List</h1>
    <div class="row">
        @foreach($menus as $menu)
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="{{ asset('storage/' . $menu->photo) }}" class="card-img-top" alt="{{ $menu->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $menu->name }}</h5>
                    <p class="card-text">{{ $menu->description }}</p>
                    <p class="card-text"><strong>Price:</strong> ${{ $menu->price }}</p>
                    <a href="{{ route('customer.menu.order', $menu->id) }}" class="btn btn-primary">Order Now</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection