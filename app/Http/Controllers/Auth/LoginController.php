<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponceTrait;
use App\Traits\AuthenticateTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class LoginController extends Controller
{
    // Traits
    use ApiResponceTrait, AuthenticateTrait;

    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Login
    public function userLogin(Request $request)
    {
        // Request data
        $username = $request->username;
        $password = $request->password;

        // Validate the input
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check with hono api 
        $isValid = $this->authenticateWithHono($username, $password);

        if ($isValid) {
            // Generate token
            $token = Str::random(60) . strtotime('now');

            // Employee data
            $userData = User::getUserDetails($username);
            Session::put('user_data', $userData);

            // Authentication passed
            return redirect()->intended('dashboard');
        }

        // Authentication failed
        return redirect()->back()->withErrors(['message' => __('messages.INVALID_CREDENTIALS')]);
    }

    public function logout()
    {
        Session::flush(); // Clear all session data
        return redirect('/login');
    }
}
