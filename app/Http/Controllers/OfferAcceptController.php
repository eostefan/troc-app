<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferAcceptController extends Controller
{
    public function __invoke(Offer $offer, Item $item)
    {
        $this->authorize('update', $offer->item);

        // // // accept
        $offer->update(['accepted_at' => now()]);
        $offer->item->sold_at = now();
        $offer->item->save();

        // // reject other offers
        $offer->item->offers()->except($offer)->update(['rejected_at' => now()]);
        
        // bid offers sold_at
        $bid_item = $item->where('id', $offer->offered_item_id)->first();
        $bid_item->sold_at = now();
        $bid_item->save();

        return redirect()->back()->with('success', "Offer #{$offer->name} accepted!");
    }
}
