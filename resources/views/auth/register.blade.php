@extends('layouts.auth')

@section('content')
<h2>Register</h2>

@if(session('success'))
<div class="alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert-error">{{ session('error') }}</div>
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf

    <label>First Name</label>
    <input type="text" name="first_name" placeholder="Enter first name" value="{{ old('first_name') }}" required>
    @error('first_name') <div class="error-msg">{{ $message }}</div> @enderror

    <label>Last Name</label>
    <input type="text" name="last_name" placeholder="Enter last name" value="{{ old('last_name') }}" required>
    @error('last_name') <div class="error-msg">{{ $message }}</div> @enderror

    <label>Email</label>
    <input type="email" name="email" placeholder="Enter email" value="{{ old('email') }}" required>
    @error('email') <div class="error-msg">{{ $message }}</div> @enderror

    <label>Password</label>
    <input type="password" name="password" placeholder="Enter password" minlength="8" required>
    @error('password') <div class="error-msg">{{ $message }}</div> @enderror

    <button type="submit">Register</button>

    <div class="auth-link">
        Already have an account? <a href="{{ route('login') }}">Login</a>
    </div>
</form>
@endsection