<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Item::class, 'item');
    }

    public function index()
    {
        $acceptedItemID = Offer::whereNotNull('accepted_at')->pluck('offered_item_id')->toArray();

        return inertia('Items/Index', [
            'items' => Item::orderByDesc('created_at')
                            ->with('photos')
                            ->whereNotIn('id', $acceptedItemID)
                            ->where('sold_at', null)
                            ->paginate(6)
                            ->withQueryString(),
            'categories' => Category::get()
        ]);
    }

    public function show(Item $item)
    {

        $user = Auth::user();

        // $offeredItemID = Offer::pluck('offered_item_id')->toArray();
        $acceptedItemID = Offer::whereNotNull('accepted_at')->pluck('offered_item_id')->toArray();

        if ($user) {
            $availableItems = Item::where('user_id', $user->id)
                                    // ->whereNotIn('id', $offeredItemID)
                                    ->whereNotIn('id', $acceptedItemID)
                                    ->where('sold_at', null)
                                    ->get();

            // $allUserItems = $user->items()->get();
        } else {
            $availableItems = null;
            // $allUserItems = null;
        }

        return inertia('Items/Show', [
            'item' => $item->load(['address', 'photos', 'user', 'offers']),
            'availableUserItems' => $availableItems
        ]);
    }
}
