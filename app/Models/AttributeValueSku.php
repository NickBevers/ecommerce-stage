<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AttributeValueSku extends Pivot
{
    public function attribute_value(): belongsTo
    {
        return $this->belongsTo(AttributeValue::class);
    }

    public function sku(): belongsTo
    {
        return $this->belongsTo(Sku::class);
    }

    public function color_size(): belongsTo
    {
        return $this->belongsTo(ColorSize::class);
    }
}