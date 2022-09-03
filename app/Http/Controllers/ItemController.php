<?php

namespace App\Http\Controllers;

use App\Http\Requests\Item\StoreItemRequest;
use App\Http\Requests\UpdateItemClaimRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ItemController extends Controller
{

    public function approvalItemsView(): View
    {
        $items = Item::query()
            ->with('owner')
            ->where('status', Item::$ITEM_STATUS_PENDING)
            ->paginate(10);

        return view('dashboard.admin.item.approval-index', compact('items'));
    }


    public function claimingItemsView(): View
    {
        $items = Item::query()
            ->with('owner')
            ->where('status', Item::$ITEM_STATUS_CLAIMING)
            ->paginate(10);

        return view('dashboard.admin.item.for-claiming-index', compact('items'));
    }

    public function claimedItemsView(): View
    {
        $items = Item::query()
            ->with('owner')
            ->where('status', Item::$ITEM_STATUS_CLAIMED)
            ->paginate(10);

        return view('dashboard.admin.item.claimed-index', compact('items'));
    }


    public function pulloutItemsView(): View
    {
        $items = Item::query()
            ->with('owner')
            ->where('status', Item::$ITEM_STATUS_PULLOUT)
            ->paginate(10);

        return view('dashboard.admin.item.pullout-index', compact('items'));
    }

    public function store(StoreItemRequest $request, int $accountId): RedirectResponse
    {
        Item::create($request->validated() + ['user_id' => $accountId, 'drop_date' => now()]);

        notify()->success('Item created successfully. ');
        return back();
    }


    public function update(UpdateItemRequest $request, Item $item): RedirectResponse
    {
        if ($request->has('sellers_price')) {
            $item->price = $request->sellers_price;
        }
        $item->update($request->validated());

        notify()->success('Item dropped successfully.');
        return redirect()->route('items.for-claiming.index');
    }


    public function destroy(Item $item): RedirectResponse
    {
        $item->delete();

        notify()->warning('Item deleted successfully.');
        return back();
    }


    public function updateApprove(UpdateItemRequest $request, Item $item): RedirectResponse
    {
        $item->update($request->validated() + ['status' => Item::$ITEM_STATUS_CLAIMING]);

        notify()->success('Item dropped successfully.');
        return redirect()->route('items.for-approval.index');
    }


    public function updateMoveToPullout(Item $item): RedirectResponse
    {
        $item->update(['status' => Item::$ITEM_STATUS_PULLOUT]);

        notify()->success('Item moved to pullout successfully.');
        return redirect()->route('items.for-claiming.index');
    }


    public function updateItemClaim(UpdateItemClaimRequest $request, Item $item): RedirectResponse
    {
        $item->update([
            'display_price' => $request->sellers_money,
            'status' => Item::$ITEM_STATUS_CLAIMED,
            'claimed_date' => now()
        ]);

        notify()->success('Item claimed successfully.');
        return redirect()->route('items.for-claiming.index');
    }
}
