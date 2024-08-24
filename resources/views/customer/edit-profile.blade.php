@extends('layouts.customer')

@section('content')
<div class="container mt-5">
    <h1>Edit Profile</h1>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <form action="{{ route('customer.update-profile') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $customer->name }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $customer->email }}" required>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" id="alamat" class="form-control" value="{{ $customer->alamat }}" required>
        </div>

        <div class="form-group">
            <label for="kontak">Kontak</label>
            <input type="text" name="kontak" id="kontak" class="form-control" value="{{ $customer->kontak }}" required>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" required>{{ $customer->deskripsi}}</textarea>
        </div>

        <!-- Add other fields as necessary -->

        <button type="submit" class="btn btn-primary mt-5">Update Profile</button>
    </form>
</div>
@endsection