<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisterController extends Controller
{

    public function index(): View
    {
        return view('auth.register');
    }


    public function signUp(RegisterUserRequest $request): RedirectResponse
    {
        $user = User::create($request->validated())->assignRole('user');
        auth()->login($user);

        notify()->success('Welcome aboard. ' . $user->name);
        return redirect()->route('dashboard.index');
    }
}
