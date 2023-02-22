<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $fillable = [
        'title',
        'description',
        'audience',
        'price',
        'stock',
        'category_id',
        'promos',
        'extra_info',
        'images',
        'sku',
        'is_promotion',
        'is_active',

    ];

    protected $casts = [
        'created_at' => 'datetime',
        'modified_at' => 'datetime',
        'deleted_at' => 'datetime',
        'images' => 'json',
        'promos' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function category(): HasOne
    {
        return $this->hasOne(Category::class);
    }

    public function subCategory(): HasOne
    {
        return $this->hasOne(SubCategory::class);
    }

    public function productOrder(): HasMany
    {
        return $this->hasMany(ProductOrder::class);
    }

    public function productVariation(): HasMany
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function promo(): HasMany
    {
        return $this->hasMany(Promo::class);
    }

    public function wishlist(): BelongsToMany
    {
        return $this->belongsToMany(Wishlist::class);
    }

    public function cart(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class);
    }
}