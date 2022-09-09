<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApproveCashoutRequest;
use App\Models\Cashout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CashoutController extends Controller
{

    public function index(): View
    {
        $cashouts = Cashout::query()
            ->with('owner')
            ->where('status', Cashout::$CASHOUT_STATUS_PENDING)
            ->paginate(10);
        return view('dashboard.admin.cashouts.index', compact('cashouts'));
    }


    public function toClaimCashoutsView(): View
    {
        $cashouts = Cashout::query()
            ->with('owner')
            ->where('status', Cashout::$CASHOUT_STATUS_FOR_CLAIMING)
            ->paginate(10);


        return view('dashboard.admin.cashouts.claim-index', compact('cashouts'));
    }


    public function cashoutLogsView(): View
    {
        $cashouts = Cashout::query()
            ->with('owner')
            ->where('status', Cashout::$CASHOUT_STATUS_CLAIMED)
            ->paginate(10);

        return view('dashboard.admin.cashouts.logs-index', compact('cashouts'));
    }


    /**
     * @throws \Throwable
     */
    public function approveCashout(ApproveCashoutRequest $request, Cashout $cashout): RedirectResponse
    {

        $cashout->update([
            'status' => Cashout::$CASHOUT_STATUS_FOR_CLAIMING,
            'release_date' => $request->date('release_date'),
            'approved_date' => now(),
        ]);
        $cashout->owner->deposit($cashout->amount);

        notify()->success('Cashout approved successfully.');
        return redirect()->route('cashouts.index');
    }


    public function declineCashout(Cashout $cashout): RedirectResponse
    {
        $cashout->update(['status' => Cashout::$CASHOUT_STATUS_PENDING]);

        notify()->warning('Cashout decline successfully.');
        return redirect()->route('cashouts.index');
    }


    /**
     * @throws \Throwable
     */
    public function approveCashoutClaimed(Cashout $cashout): RedirectResponse
    {
        $cashout->update(['status' => Cashout::$CASHOUT_STATUS_CLAIMED]);
        $cashout->owner->withdraw($cashout->amount);

        notify()->success('Cashout claimed successfully.');
        return redirect()->route('cashouts.claim.index');
    }
}
