@extends('layouts.merchant')
@section('content')
<div class="container">
    <h1>Edit Menu</h1>

    <form action="{{ route('merchant.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $menu->name) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" required>{{ old('description', $menu->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" id="price" name="price" class="form-control" value="{{ old('price', $menu->price) }}" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="photo">Photo</label>
            <input type="file" id="photo" name="photo" class="form-control">
            @if ($menu->photo)
            <img src="{{ asset('storage/' . $menu->photo) }}" alt="Menu Photo" class="img-thumbnail mt-2" style="max-width: 200px;">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Menu</button>
    </form>
</div>
@endsection