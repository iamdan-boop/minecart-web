<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Cashout;
use App\Models\Item;
use Illuminate\View\View;

class CustomerDashboardController extends Controller
{


    public function index(): View
    {

        return view('dashboard.customer.dashboard', [
            'itemsClaimedCost' => Item::where([
                'user_id' => auth()->id(),
                'status' => Item::$ITEM_STATUS_CLAIMED,
            ])->sum('price'),
            'receivedCashouts' =>  Cashout::where([
                'status' => Cashout::$CASHOUT_STATUS_CLAIMED,
                'user_id' => auth()->id(),
            ])->sum('amount'),
            'announcements' => Announcement::orderBy('created_at', 'desc')
                ->paginate(5),
        ]);
    }
}
