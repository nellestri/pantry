@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="mb-4">Register</h2>

        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <!-- Add Bootstrap CSS in your layout or here for demo -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Create Account</button>
        </form>

        <a href="{{ route('login') }}">
            <button type="button" class="btn btn-primary w-100 mb-2">Login</button>
        </a>

        <a href="{{ route('register') }}">
            <button type="button" class="btn btn-outline-secondary w-100">Register</button>
        </a>
    </div>
</div>
@endsection
