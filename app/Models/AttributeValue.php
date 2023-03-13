<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class AttributeValue extends Model
{
    public function attributeType(): belongsTo
    {
        return $this->belongsTo(AttributeType::class, 'attribute_type_id');
    }

    public function colorSize(): belongsTo
    {
        return $this->belongsTo(ColorSize::class);
    }

    public function skus()
    {
        return $this->morphedByMany(Sku::class, 'variation', 'sku_variations', 'variation_id')
            ->where('variation_type', 'attribute_value');
    }
}