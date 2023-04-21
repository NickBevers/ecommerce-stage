<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderLine extends Model
{
    protected $table = 'order_lines';

    protected $fillable = [
        'product_id',
        'order_id',
        'quantity',
        'price',
        'attributes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'attributes' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function sku(): BelongsTo
    {
        return $this->BelongsTo(Sku::class);
    }

    public function order(): BelongsTo
    {
        return $this->BelongsTo(Order::class);
    }

    /*
     * |--------------------------------------------------------------------------
     * | SCOPES
     * |--------------------------------------------------------------------------
     */

    public function scopeWithAllRelations($query)
    {
        return $query->with([
            'sku',
            'sku.product',
            'sku.product.brand',
            'sku.product.subCategory',
            'sku.product.subCategory.category',
            'sku.attributeValues',
            'sku.attributeValues.attributeType',
            'sku.promos',
            'sku.productImages',
        ]);
    }
}