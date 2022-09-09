<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cashout;
use App\Models\Item;
use Illuminate\View\View;

class CustomerDashboardController extends Controller
{


    public function index(): View
    {
        $receivedCashouts = Cashout::where([
            'status' => Cashout::$CASHOUT_STATUS_CLAIMED,
            'user_id' => auth()->id(),
        ])->sum('amount');

        $itemsClaimed = Item::where([
            'user_id' => auth()->id(),
            'status' => Item::$ITEM_STATUS_CLAIMED,
        ])->sum('price');


        return view('dashboard.customer.dashboard', [
            'itemsClaimedCost' => $itemsClaimed,
            'receivedCashouts' => $receivedCashouts
        ]);
    }
}
