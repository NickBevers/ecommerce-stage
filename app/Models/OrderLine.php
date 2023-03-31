<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderLine extends Model
{
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

    public function product(): BelongsTo
    {
        return $this->BelongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->BelongsTo(Order::class);
    }
}