<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        
        if (auth()->guard('customer')->check()) {
            return view('dashboard.customer'); 
        }

        return view('dashboard.user'); 
    }
}
