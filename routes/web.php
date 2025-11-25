<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\BookingController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\HomeController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('auth.register');
});

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/email/verify', [VerificationController::class, 'notice'])->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', [VerificationController::class, 'resend'])->middleware('throttle:6,1')->name('verification.send');
});

// Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
Route::post('/bookings/store', [BookingController::class, 'store']);
Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
