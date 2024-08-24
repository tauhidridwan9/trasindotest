@extends('layouts.customer')

@section('content')
<div class="container">
    <h1>Search Results</h1>
    <form action="{{ route('customer.search') }}" method="GET">
        <input type="text" name="query" placeholder="Search for catering">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    @if($caterings->isEmpty())
    <p>No catering found.</p>
    @else
    <ul>
        @foreach ($caterings as $catering)
        <li>{{ $catering->name }} - {{ $catering->description }}</li>
        @endforeach
    </ul>
    @endif
</div>
@endsection