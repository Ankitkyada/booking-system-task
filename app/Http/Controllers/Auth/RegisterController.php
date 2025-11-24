<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
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
                return back()->with('error', $validator->errors()->first());
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
            Auth::login($user);
            $user->sendEmailVerificationNotification();
            return redirect()->route('verification.notice')->with('success', 'Account created! Please verify your email');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
