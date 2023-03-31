<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
    ];

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/

    public function user():  BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function addresses(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function skus(): BelongsToMany
    {
        return $this->belongsToMany(Sku::class, 'order_lines', 'order_id', 'sku_id');
    }

    public function productReturns(): HasMany
    {
        return $this->hasMany(ProductReturn::class);
    }

}