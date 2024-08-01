<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponceTrait;
use App\Traits\AuthenticateTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class AuthenticateApiController extends Controller
{
    // Traits
    use ApiResponceTrait, AuthenticateTrait;

    // Login
    public function userLogin(Request $request)
    {
        // Request data
        $username = $request->username;
        $password = $request->password;

        // Validation
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        // Validation
        $validationResponce = $this->validateRequest($request, $rules);
        if ($validationResponce) {
            return $validationResponce;
        }

        // Check with api 
        $isValid = $this->authenticateWithHono($username, $password);

        if (!$isValid) {
            return $this->error(__('messages.INVALID_CREDENTIALS'));
        } else {
            // Generate token
            $token = Str::random(60) . strtotime('now');

            // Employee data
            $userData = User::getUserDetails($username);

            $data = [
                'token' => $token,
                'user_data' => $userData
            ];
            return $this->success($data);
        }
    }
}
