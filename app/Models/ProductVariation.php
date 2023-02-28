<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductVariation extends Model
{

    use HasFactory;

    protected $table = 'product_variation';

    protected $fillable = [
        'color_variation_id',
        'product_id',
        'price',
        'amount',
        'variation_number',
        'images',
        'sizes',
        'in_stock'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'sizes' => 'array',
        'images' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function colorVariation(): HasOne
    {
        return $this->HasOne(ColorVariation::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}