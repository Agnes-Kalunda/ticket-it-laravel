<?php

namespace App\Http\Controllers\Auth\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    use AuthenticatesUsers;

    protected $redirectTo = "/customer/dashboard";

    public function __construct(){
        $this->middleware("customer.guest")->except("logout");
    }

    public function showLoginForm(){
        return view("auth.customer.login");
    }

    protected function guard(){
        return Auth::guard("customer");
    }
}
