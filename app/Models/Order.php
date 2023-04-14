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
        'total_price',
        'shipping_address_id',
        'billing_address_id',
        'order_date',
        'order_status',
        'preferred_delivery_date',
        'payment_type_id',
        'tracking_number',
        'tracking_url',
        'shipped_at',
        'firstname',
        'lastname',
        'phone_number',
        'email',
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

    public function addresses(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function skus(): BelongsToMany
    {
        return $this->belongsToMany(Sku::class, 'order_lines', 'order_id', 'sku_id')->withPivot('amount', 'price', 'discount', 'product_name');
    }

    public function productReturns(): HasMany
    {
        return $this->hasMany(ProductReturn::class);
    }

    /*
     * --------------------------------------------------------------------------
     * SCOPES
     * --------------------------------------------------------------------------
     */

    public function scopeWithRelations($query)
    {
        return $query->with([
            'user',
            'addresses',
            'skus',
            'productReturns',
        ]);
    }

}