<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function registerPage()
    {
        return view('auth.register');
    }

    // Store new user
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:100',
                'last_name'  => 'required|string|max:100',
                'email'      => 'required|email|unique:tbl_users,email',
                'password'   => 'required|min:6',
            ]);

            if ($validator->fails()) {
                return back()->with('error', 'The given data was invalid.');
            }

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'password'   => bcrypt($request->password),
            ]);
            if (!$user) {
                return redirect()->back()->withInput()->with('error', 'Failed to create user. Please try again.');
            }

            $user->sendEmailVerificationNotification();
            return redirect()->route('login')->with('success', 'Account created! Please verify your email');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    // Show login page
    public function loginPage()
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

        return redirect()->route('booking.form');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
