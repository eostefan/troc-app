<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description'];

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class, 'item_id');
    }

    public function offered(): HasMany
    {
        return $this->hasMany(Offer::class, 'offered_item_id');
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class, 'item_id');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class, 'item_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
