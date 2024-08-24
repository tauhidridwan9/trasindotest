@extends('layouts.merchant')

@section('content')
<div class="container mt-5">
    <h1>Edit Profile</h1>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <form action="{{ route('merchant.update-profile') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $merchant->name }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $merchant->email }}" required>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" id="alamat" class="form-control" value="{{ $merchant->alamat }}" required>
        </div>

        <div class="form-group">
            <label for="kontak">Kontak</label>
            <input type="text" name="kontak" id="kontak" class="form-control" value="{{ $merchant->kontak }}" required>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" required>{{ $merchant->deskripsi}}</textarea>
        </div>
      

        <button type="submit" class="btn btn-primary mt-5">Update Profile</button>
    </form>
</div>
@endsection