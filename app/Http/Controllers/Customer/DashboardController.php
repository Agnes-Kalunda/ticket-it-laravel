<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('customer.auth');
    }

    public function index()
    {
        return view('customer.dashboard', ['customer' => auth('customer')->user()]);
    }
}