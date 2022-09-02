<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCashoutRequest;
use App\Models\Cashout;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CustomerCashoutController extends Controller
{

    public function index(): View
    {
        $cashouts = Cashout::where('user_id', auth()->id())->paginate(10);
        return view('dashboard.customer.cashout.index', compact('cashouts'));
    }


    public function store(StoreCashoutRequest $request): RedirectResponse
    {
        Cashout::create($request->validated() + [
                'user_id' => auth()->id(),
                'request_date' => now(),
            ]);

        notify()->success('Cashout request submitted successfully.');
        return redirect()->route('dashboard.index');
    }
}
