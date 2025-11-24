@extends('layouts.auth')

@section('content')
<h2>Please Verify Your Email</h2>

<p>We have sent a verification link to your email address.</p>

<form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button type="submit">Resend Verification Email</button>
</form>

<div class="auth-link">
    <a href="{{ route('login') }}">Back to Login</a>
</div>
@endsection