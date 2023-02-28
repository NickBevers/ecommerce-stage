<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{

    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'audience',
        'category_id',
        'promos',
        'extra_info',
        'sku',
        'is_promotion',
        'is_active',
        'brand_id',

    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
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

    public function brand(): HasOne
    {
        return $this->hasOne(Brand::class);
    }

    public function material(): HasOne
    {
        return $this->hasOne(Material::class);
    }
}