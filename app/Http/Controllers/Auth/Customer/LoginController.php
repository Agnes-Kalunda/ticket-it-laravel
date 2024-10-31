<?php

namespace App\Http\Controllers\Auth\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/customer/dashboard';

    public function __construct()
    {
        $this->middleware('customer.guest')->except('logout');
    }

   
    public function username()
    {
        return 'username';
    }

    public function showLoginForm()
    {
        return view('auth.customer.login');
    }

    protected function guard()
    {
        return Auth::guard('customer');
    }

    // overide logout method
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }
}