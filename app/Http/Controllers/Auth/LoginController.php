<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use App\Traits\AuthenticateTrait;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, AuthenticateTrait;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        $username = $request->username;
        $password = $request->password;
        try {

            // Check with hono api 
            $isValid = $this->authenticateWithHono($username, $password);

            if ($isValid) {
                // Employee data
                $userData = Employee::getUserDetails($username);
                $name = $userData['DISPLAYNAME'];
                $email = $userData['EMAIL'];
                $contact_no = $userData['MOBILE'];
                $emp_code = $userData['EMPLOYEECODE'];
                $designation = $userData['DESIGNATION'];

                $user = User::updateOrCreate([
                    'username' => $username,
                    'contact_no' => $contact_no,
                ],[
                    'email' => $email,
                    'name' => $name,
                    'emp_code' => $emp_code,
                    'designation' => $designation,
                    'password' => $password,
                ]);
 
                if ($this->attemptLogin($request)) {
                    if ($request->hasSession()) {
                        $request->session()->put('auth.password_confirmed_at', time());
                    }
        
                    return $this->sendLoginResponse($request);
                }
        
                return $this->sendFailedLoginResponse($request);
                
            } else {
                return $this->sendFailedLoginResponse($request);
            }
        } catch (\Exception $e) {
            return $this->sendFailedLoginResponse($request);
        }
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }
}
