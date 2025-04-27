<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{

    public function store(Item $item, Request $request)
    {
        $this->authorize('view', $item);

        $user = Auth::user();

        $request->validate([
            'item_id' => 'required|exists:items,id',
            'offered_item_id' => 'required|exists:items,id'
        ]);

        $offeredItem = Item::where('id', $request->offered_item_id)->where('user_id', $user->id)->first();

        if (!$offeredItem) {
            return back()->withErrors(['item_id' => 'You can only offer items you own!']);
        }

        $item = Item::findOrFail($request->item_id);
        if ($item->user_id == $user->id) {
            return back()->withErrors(['item_id' => 'You cannot make an offer on your own item.']);
        }

        Offer::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'item_id' => $request->item_id,
            'offered_item_id' => $request->offered_item_id
        ]);

        return redirect()->back()->with('success', 'Offer made successfully!');
    }

}
