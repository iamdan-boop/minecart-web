<?php

namespace App\Http\Controllers;

use App\Http\Requests\Item\StoreItemRequest;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;

class ItemController extends Controller
{

    public function store(StoreItemRequest $request, int $accountId): RedirectResponse
    {
        Item::create($request->validated() + ['user_id' => $accountId]);

        notify()->success('Item created successfully. ');
        return back();
    }
}
