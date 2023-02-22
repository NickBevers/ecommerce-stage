<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Variation extends Model
{
    protected $fillable = [
        'attribute_id',
        'type',
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

    public function attributes(): HasOne
    {
        return $this->hasOne(Attribute::class);
    }

    public function productVariations(): BelongsToMany
    {
        return $this->belongsToMany(ProductVariation::class);
    }
}