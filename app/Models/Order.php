<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'shipping_address_id',
        'billing_address_id',
        'payment_method',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'images' => 'array',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function shippingAddress(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function billingAddress(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}