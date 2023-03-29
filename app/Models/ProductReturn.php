<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductReturn extends Model
{
    protected $fillable = [
        'user_id',
        'sku_id',
        'order_id',
        'reason',
        'status',
        'tracking_number',
        'received_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'received_at' => 'datetime',
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

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*
     * |--------------------------------------------------------------------------
     * | SCOPES
     * |--------------------------------------------------------------------------
     */

    public function scopeWithSku($query)
    {
        return $query
            ->with('order')
            ->with('sku')
            ->with('sku.product')
            ->with('sku.product.brand')
            ->with('sku.productImages')
            ->with('sku.attributeValues')
            ->with('sku.promos');
    }
}