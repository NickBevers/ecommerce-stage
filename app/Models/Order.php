<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function productOrder(): HasMany
    {
        return $this->hasMany(ProductOrder::class);
    }
}