<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LoginController extends Controller
{


    public function index(): View
    {
        return view('auth.login');
    }


    public function authenticate(LoginRequest $request): RedirectResponse
    {
        if (!auth()->attempt($request->validated())) {
            return back()->withErrors(['message' => 'Invalid Email or Password']);
        }

        notify()->success('Welcome aboard. ' . auth()->user()->name);
        return auth()->user()->isAdmin()
            ? redirect()->route('dashboard.index')
            : redirect()->route('customer.dashboard.index');
    }
}
