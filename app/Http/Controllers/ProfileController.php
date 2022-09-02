<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{

    public function __invoke(UpdateProfileRequest $request): RedirectResponse
    {
        auth()->user()->fill($request->validated())->save();

        notify()->success('Profile updated successfully');
        return back();
    }
}
