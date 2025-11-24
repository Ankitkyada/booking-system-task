@extends('layouts.auth')

@section('content')
<h2>Login</h2>

@if(session('error'))
<div class="alert-error">{{ session('error') }}</div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <label>Email</label>
    <input type="email" name="email" placeholder="Enter your email" required>
    @error('email') <div class="error-msg">{{ $message }}</div> @enderror

    <label>Password</label>
    <input type="password" name="password" placeholder="Enter your password" required>
    @error('password') <div class="error-msg">{{ $message }}</div> @enderror

    <button type="submit">Login</button>

    <div class="auth-link">
        New user? <a href="{{ route('register') }}">Create an account</a>
    </div>
</form>
@endsection