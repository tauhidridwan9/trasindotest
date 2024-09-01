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
    <div class="row m-5 align-items-start justify-content-start row-cols-2 row-cols-lg-5 g-2 g-lg-3">
        @foreach ($menus as $menu)
        <div class="card m-2 p-3" style="width: 18rem;">
             .
                    <img src="{{asset('storage/' . $menu->photo)}}" alt="{{ $menu->name }}" class="object-fit-cover rounded" style="height: 250px;">
                
                <div class="card-body">
                    <h5 class="h4">{{ $menu->name }}</h5>
                    <p class="text-body-secondary">{{ $menu->description }}</p>
                    <p class=" h5 text-success">Price: Rp. {{ number_format($menu->price, 0, ',', '.') }}</p>
                    <p><strong>Merchant:</strong> {{ $menu->merchant->name }}</p>
                    <a href="{{ route('customer.order.create', ['menu_id' => $menu->id]) }}" class="btn btn-primary">Order Now</a>
                </div>
    
        </div>
        @endforeach
    </div>
    @endif

</div>
@endsection