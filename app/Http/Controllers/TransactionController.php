<?php

namespace App\Http\Controllers;

use App\Models\Cashout;
use App\Models\Item;
use App\Models\User;
use Bavix\Wallet\Models\Wallet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{

    public function index(Request $request): View
    {
        $itemsDropped = Item::where('status', Item::$ITEM_STATUS_PENDING)->count();
        $claimedItems = Item::where('status', Item::$ITEM_STATUS_CLAIMED)->count();
        $todayDropItems = Item::where('status', Item::$ITEM_STATUS_PENDING)->where('created_at', now())->count();
        $todayClaimedItems = Item::where('status', Item::$ITEM_STATUS_CLAIMED)
            ->where('created_at', now())->count();

        $droppedItems = [];

        $receivedHandlingFee = [];

        if ($request->isMethod('POST')) {
            $droppedItems = Item::query()
                ->with('owner')
                ->whereBetween('drop_date', [$request->date('from_date'), $request->date('to_date')])
                ->get();

            $receivedHandlingFee = Item::query()
                ->with('owner')
                ->whereBetween('drop_date', [$request->date('from_date'), $request->date('to_date')])
                ->where('status', Item::$ITEM_STATUS_CLAIMED)
                ->get();
        }
        return view('dashboard.admin.transactions.index', compact('itemsDropped', 'claimedItems', 'todayDropItems', 'todayClaimedItems', 'droppedItems', 'receivedHandlingFee'));
    }


    public function incomeLogView(): View
    {
        $overallReceivedSellersMoney = Item::query()
            ->where('status', Item::$ITEM_STATUS_CLAIMED)->sum('price');

        $todayReceivedSellersMoney = Item::query()
            ->whereDate('claimed_date', now())
            ->where('status', Item::$ITEM_STATUS_CLAIMED)
            ->sum('price');

        $overallHandlingFee = Item::query()
            ->where('status', Item::$ITEM_STATUS_CLAIMED)
            ->sum('handling_fee');

        $overallHandlingFeeToday = Item::where('status', Item::$ITEM_STATUS_CLAIMED)
            ->whereDate('claimed_date', now())
            ->sum('handling_fee');

        $overallUserWalletBalance = Wallet::query()->sum('balance');
        $users = User::query()->with('wallet')->paginate(10);

        return view('dashboard.admin.transactions.income-index', compact('overallReceivedSellersMoney', 'todayReceivedSellersMoney', 'overallHandlingFee', 'overallHandlingFeeToday', 'overallUserWalletBalance', 'users'));
    }


    public function incomeLogFilterAjax(Request $request): JsonResponse
    {
        $todayReceivedSellersMoneyFilter = Item::query()
            ->whereBetween('claimed_date', [$request->date('from_date'), $request->date('to_date')])
            ->where('status', Item::$ITEM_STATUS_CLAIMED)
            ->sum('price');

        $overallHandlingFeeTodayFilter = Item::query()
            ->whereBetween('claimed_date', [$request->date('from_date'), $request->date('to_date')])
            ->where('status', Item::$ITEM_STATUS_CLAIMED)
            ->sum('handling_fee');

        return response()->json([
            'todayReceivedSellersMoney' => number_format($todayReceivedSellersMoneyFilter, 2),
            'overallHandlingFee' => number_format($overallHandlingFeeTodayFilter, 2),
            'from_date' => $request->date('from_date')->format('d F Y'),
        ]);
    }


    public function userIncomeLogView(): View
    {
        $userWithItems = User::query()
            ->role(User::$ROLE_USER)
            ->addSelect([
                'total_item_claimed_income' => Item::whereUserId('users.id')
                    ->where('status', Item::$ITEM_STATUS_CLAIMED)
                    ->selectRaw('sum(price) as total_item_claimed_income'),
                'total_cashout_claimed' => Cashout::whereUserId('users.id')
                    ->where('status', Cashout::$CASHOUT_STATUS_CLAIMED)
                    ->selectRaw('sum(amount) as total_cashout_claimed'),
                'total_money' => Item::whereUserId('users.id')
                    ->where('status', Item::$ITEM_STATUS_CLAIMED)
                    ->selectRaw('sum(price) as total_money')
            ])->paginate(10);

        return view('dashboard.admin.transactions.user-income-index', compact('userWithItems'));
    }


    public function resetWallet(User $user)
    {
        $user->wallet->update(['balance' => 0]);

        notify()->success('Wallet successfully reset.');
        return back();
    }
}
