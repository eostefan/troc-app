<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
    protected $sortable = ['name', 'created_at'];

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

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query->when(
            $filters['name'] ?? false,
            fn($query, $value) => $query->where('name', 'LIKE', '%' . $value . '%')
        )->when(
            $filters['deleted'] ?? false,
            fn($query, $value) => $query->withTrashed()
        );
    }
}
