@extends('layouts.customer')
@section('content')
<div class="container mt-5">
    <h1>Welcome, {{ auth()->user()->name }}!</h1>
    @if(session('success-reset'))
    <div class="alert alert-success">
        {{ session('success-reset') }}
    </div>
    @endif


    <form action="{{ route('customer.dashboard') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="search" value="{{ request()->input('search') }}" class="form-control" placeholder="Search for catering">
            </div>

            <div class="col-md-2">
                <input type="number" name="price_min" value="{{ request()->input('price_min') }}" class="form-control mb-2" placeholder="Min Price">

            </div>
            <div class="col-md-2">
                <input type="number" name="price_max" value="{{ request()->input('price_max') }}" class="form-control" placeholder="Max Price">
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>


    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif


    <!-- Displaying Search Results -->
    <h2>Available Menus</h2>
    @if($menus->isEmpty())
    <p>No menus found.</p>
    @else
    <ul class="list-group">
        @foreach ($menus as $menu)
        <li class="list-group-item">
            <div class="row">
                <div class="col-md-4">
                    <!-- Displaying the menu image -->
                    <img src="{{asset('storage/' . $menu->photo)}}" alt="{{ $menu->name }}" class="img-fluid">
                </div>
                <div class="col-md-8">
                    <h5>{{ $menu->name }}</h5>
                    <p>{{ $menu->description }}</p>
                    <p>Price: Rp. {{ number_format($menu->price, 0, ',', '.') }}</p>
                    <p><strong>Merchant:</strong> {{ $menu->merchant->name }}</p>
                    <a href="{{ route('customer.order.create', ['menu_id' => $menu->id]) }}" class="btn btn-primary">Order Now</a>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
    @endif

</div>
@endsection