<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CustomerDashboardController extends Controller
{


    public function index(): View
    {
        return view('dashboard.customer.dashboard');
    }
}
