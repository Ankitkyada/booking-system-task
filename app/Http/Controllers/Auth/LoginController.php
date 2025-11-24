<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class LoginController extends Controller
{
    // Show login page
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Login user
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email|exists:tbl_users,email',
            'password' => 'required',

        ]);

        if ($validator->fails()) {
            return back()->with('error', 'The given data was invalid.');
        }


        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->with('error', 'Invalid credentials');
        }

        $user_email = $request->email;

        $user = User::where('email', $user_email)->first();

        if (!$user) {
            return back()->with('error', 'User not found');
        }

        if ((!$user || !Hash::check($request->password, $user->password))) {
            return back()->with(
                'error',
                'The password is incorrect.'
            );
        }
        $user = Auth::user();
        if (is_null($user->email_verified_at)) {
            Auth::logout();
            return back()->with('error', 'Please verify your email before logging in.');
        }

        return redirect()->route('bookings.index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
