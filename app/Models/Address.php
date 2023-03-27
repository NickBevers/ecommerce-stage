<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'address_line1',
        'address_line2',
        'city',
        'postal_code',
        'country',
        'btw_number',
        'address_type',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}