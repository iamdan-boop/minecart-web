<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{

    public function __invoke(Request $request): RedirectResponse
    {
        auth()->logout();
        $request->session()->invalidate();

        notify()->success('Please login.');
        return redirect()->route('login.index');
    }
}
