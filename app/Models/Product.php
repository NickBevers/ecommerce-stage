<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Product extends Model
{

    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'audience',
        'sub_category_id',
        'extra_info',
        'is_active',
        'user_id',
        'brand_id',

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

    public function subCategory(): HasOne
    {
        return $this->hasOne(SubCategory::class);
    }

    public function category(): HasOneThrough
    {
        return $this->hasOneThrough(Category::class, SubCategory::class);
    }

    public function brand(): HasOne
    {
        return $this->hasOne(Brand::class);
    }

    public function skus(): HasMany
    {
        return $this->hasMany(Sku::class);
    }
}