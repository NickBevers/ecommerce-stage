<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttributeType extends Model
{
    protected $fillable = [
        'name',
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
     * ---------------------------------------------------------------
     * RELATIONS
     * ---------------------------------------------------------------
     */

    public function attributeValues(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }
}