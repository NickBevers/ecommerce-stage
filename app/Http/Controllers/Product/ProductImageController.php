<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{

    public function store($id, $link, $publicId, $alt, $type = 'image')
    {
        return ProductImage::create([
            'sku_id' => $id,
            'image_type' => $type,
            'image_link' => $link,
            'image_public_id' => $publicId,
            'alt' => $alt,
        ]);
    }
}