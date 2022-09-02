<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Item\StoreItemRequest;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CustomerItemController extends Controller
{
    public function index(): View
    {
        $items = Item::where('user_id', auth()->id())->paginate(10);
        return view('dashboard.customer.item.index', compact('items'));
    }


    public function store(StoreItemRequest $request): RedirectResponse
    {
        Item::create($request->validated() + ['user_id' => auth()->id()]);

        notify()->success('Item created successfully.');
        return redirect()->route('customer.items.index');
    }
}
