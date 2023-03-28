<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AttributeValue extends Model
{
    protected $fillable = [
        'name',
        'attribute_type_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function attributeType(): BelongsTo
    {
        return $this->belongsTo(AttributeType::class);
    }

    public function skus(): BelongsToMany
    {
        return $this->belongsToMany(Sku::class, 'attribute_value_sku', 'attribute_value_id', 'sku_id');
    }
}