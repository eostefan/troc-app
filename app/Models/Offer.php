<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder as Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Offer extends Model
{

    protected $fillable = [
        'offered_item_id',
        'item_id', 
        'name',
        'user_id', 
        'accepted_at', 
        'rejected_at'
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function offered(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'offered_item_id');
    }

    public function scopeByMe(Builder $query): Builder
    {
        return $query->where('user_id', Auth::user()?->id);
    }

    public function scopeExcept(Builder $query, Offer $offer): Builder
    {
        return $query->where('id', '!=', $offer->id);
    }
}
