<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Sku extends Model
{

    use HasFactory;

    protected $table = 'skus';

    protected $fillable = [
        'sku',
        'product_id',
        'amount',
        'price',
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

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variations(): HasMany
    {
        return $this->hasMany(SkuVariation::class);
    }

    public function promo(): HasOne
    {
        return $this->hasOne(Promo::class);
    }

//    public function attributeValues(): BelongsToMany
//    {
//        return $this->belongsToMany(AttributeValue::class, 'sku_variations', 'sku_id', 'variation_id');
//    }
//
//    public function colorSizes(): BelongsToMany
//    {
//        return $this->belongsToMany(ColorSize::class, 'sku_variations', 'sku_id', 'variation_id');
//    }

    public function colorSizes()
    {
        return $this->morphedByMany(ColorSize::class, 'variation');
    }

    public function attributeValues()
    {
        return $this->morphedByMany(AttributeValue::class, 'variation');
    }
}