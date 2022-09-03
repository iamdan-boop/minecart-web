<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApproveCashoutRequest;
use App\Models\Cashout;
use Illuminate\Http\RedirectResponse;
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


    public function approveCashout(ApproveCashoutRequest $request, Cashout $cashout): RedirectResponse
    {
        $cashout->update([
            'status' => Cashout::$CASHOUT_STATUS_FOR_CLAIMING,
            'release_date' => $request->date('release_date'),
            'approved_date' => now(),
        ]);

        notify()->success('Cashout approved successfully.');
        return redirect()->route('cashouts.index');
    }


    public function declineCashout(Cashout $cashout): RedirectResponse
    {
        $cashout->update(['status' => Cashout::$CASHOUT_STATUS_PENDING]);

        notify()->warning('Cashout decline successfully.');
        return redirect()->route('cashouts.index');
    }


    public function approveCashoutClaimed(Cashout $cashout): RedirectResponse
    {
        $cashout->update(['status' => Cashout::$CASHOUT_STATUS_CLAIMED]);

        notify()->success('Cashout claimed successfully.');
        return redirect()->route('cashouts.claim.index');
    }
}
