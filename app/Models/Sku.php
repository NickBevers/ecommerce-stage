<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    protected $hidden = [
        'created_at',
        'updated_at',
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

    public function promos(): HasMany
    {
        return $this->HasMany(Promo::class);
    }

    public function attributeValues(): BelongsToMany
    {
        return $this->belongsToMany(AttributeValue::class, 'attribute_value_sku', 'sku_id', 'attribute_value_id');
    }

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'sku_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'product_order', 'sku_id', 'order_id');
    }

    public function productReturns(): HasMany
    {
        return $this->hasMany(ProductReturn::class);
    }

    /*
     * |--------------------------------------------------------------------------
     * | SCOPES
     * |--------------------------------------------------------------------------
     */

    public function scopeSearch($query, $searchTerm)
    {
        return $query->whereHas('product', function ($query) use ($searchTerm) {
            $query->where('title', 'like', '%' . $searchTerm . '%');
        });
    }

    public function scopeWithAllRelations($query)
    {
        return $query->with('product')
            ->with('product.subCategory')
            ->with('product.subCategory.category')
            ->with('product.brand')
            ->with('productImages')
            ->with('attributeValues')
            ->with('attributeValues.attributeType')
            ->with('promos')
            ->with('reviews')
            ->with('carts')
            ->with('wishlists')
            ->with('orders')
            ->with('productReturns');
    }
}
