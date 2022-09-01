<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(): View
    {
        $accounts = User::query()
            ->with('roles')
            ->role([User::$ROLE_BANTAY, User::$ROLE_USER])
            ->paginate(10);


        return view('dashboard.admin.account.index', compact('accounts'));
    }


    public function show(User $account): View
    {
        return view('dashboard.admin.account.show', compact('account'));
    }


    public function update(UpdateUserRequest $request, User $account): RedirectResponse
    {
        if ($request->has('password')) {
            $account->password = $request->password;
        }
        $account->update($request->except('password'));

        notify()->success('Account updated successfully. ' . $account->name);
        return redirect()->route('accounts.index');
    }


    public function updateToBantayRole(User $account): RedirectResponse
    {
        $account->syncRoles(User::$ROLE_BANTAY);

        notify()->success('Role updated successfully. ' . $account->name);
        return redirect()->route('accounts.index');
    }


    public function updateToUserRole(User $account): RedirectResponse
    {
        $account->syncRoles(User::$ROLE_USER);

        notify()->success('Role updated successfully. ' . $account->name);
        return redirect()->route('accounts.index');
    }
}
