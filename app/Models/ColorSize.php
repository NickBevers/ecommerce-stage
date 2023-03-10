<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ColorSize extends Model
{
    protected $fillable = [
        'color_id',
        'size_id',
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
    public function attributeValues(): MorphMany
    {
        return $this->morphMany(AttributeValue::class, 'attribute_value');
    }
}