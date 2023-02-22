<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'products',
        'modified_at',
    ];

    protected $casts = [
        'products' => 'array',
    ];

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}