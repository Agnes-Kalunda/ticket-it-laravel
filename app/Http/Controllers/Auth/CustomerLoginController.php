<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerLoginController extends Controller
{
    //
    public function showLoginForm(){
        return view("auth.customer_login");
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'username'=>'required',
            'password'=> 'required',
        ]);

        if(Auth::guard('customer')->attempt($credentials)){
            return redirect()->intended('/customer/dashboard');
        }

        return back()->withErrors([
            'username'=>'The provided credentials do not match our records.',
        ]);
}

}
