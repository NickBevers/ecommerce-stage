<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ColorSize extends Model
{
    protected $fillable = [
        'color_id',
        'size_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    // public function to morph many on attribute value sku
    public function color(): belongsTo
    {
        return $this->belongsTo(AttributeValue::class, 'color_id');
    }

    public function size(): belongsTo
    {
        return $this->belongsTo(AttributeValue::class, 'size_id');
    }

    public function attributeValues(): belongsTo
    {
        return $this->belongsTo(AttributeValue::class);
    }

    public function skus(): hasMany
    {
        return $this->hasMany(SkuVariation::class, 'variation_id')
            ->where('variation_type', 'color_size');
    }
}