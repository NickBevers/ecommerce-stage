<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductImage extends Model
{
protected $fillable = [
        'sku_id',
        'image_type',
        'image_link',
        'image_public_id',
        'alt',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function sku(): BelongsTo
    {
        return $this->belongsTo(Sku::class);
    }
}