@extends('layouts.admin')
@section('content')
<div class="container mt-5">
    <h1>Welcome, {{ auth()->user()->name }}!</h1>
    @if(session('success-reset'))
    <div class="alert alert-success">
        {{ session('success-reset') }}
    </div>
    @endif

    <div class="container">
        <h1>Hai Admin</h1>
    </div>


    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
</div>
@endsection