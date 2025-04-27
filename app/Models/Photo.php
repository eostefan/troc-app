<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{

    protected $fillable = ['filename', 'public_id', 'url'];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

}
