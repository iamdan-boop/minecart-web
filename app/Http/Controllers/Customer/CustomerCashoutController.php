<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCashoutRequest;
use App\Models\Cashout;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CustomerCashoutController extends Controller
{

    public function index(): View
    {
        $cashouts = Cashout::where('user_id', auth()->id())->paginate(10);
        $claimedItems = Item::where('status', Item::$ITEM_STATUS_CLAIMED)->get();
        return view('dashboard.customer.cashout.index', compact('cashouts', 'claimedItems'));
    }


    public function store(StoreCashoutRequest $request): RedirectResponse
    {

        if ($request->has('select_all_items')) {
            $amountCashout = Item::whereStatus(Item::$ITEM_STATUS_CLAIMED)->sum('price');
        } else {
            $amountCashout = Item::findMany($request->items)->sum('price');
        }

        Cashout::create($request->validated() + [
                'user_id' => auth()->id(),
                'request_date' => now(),
                'amount' => $amountCashout
            ]);

        notify()->success('Cashout request submitted successfully.');
        return redirect()->route('customer.dashboard.index');
    }
}
