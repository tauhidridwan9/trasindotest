@extends('layouts.merchant')

@section('content')
<div class="container mt-5">
    <h1>Welcome, {{ auth()->user()->name }}!</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif



    <div class="container mt-3">
        <h2>Your Menus</h2>
        @if ($menus->isEmpty())
        <p>No menus available.</p>
        @else
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menus as $menu)
                <tr>
                    <td>{{ $menu->name }}</td>
                    <td>{{ $menu->description }}</td>
                    <td>{{ $menu->price }}</td>
                    <td>
                        <a href="{{ route('merchant.menu.edit', $menu->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('merchant.menu.delete', $menu->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection