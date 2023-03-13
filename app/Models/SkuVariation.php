<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SkuVariation extends Model
{
    protected $fillable = [
        'sku_id',
        'variation_id',
        'variation_type'
    ];

    public function variation(): MorphTo
    {
        return $this->morphTo();
    }

    public function sku(): belongsTo
    {
        return $this->belongsTo(Sku::class);
    }
}