<?php

namespace App\Services;

use App\Models\ProductImage;

class ProductImageService
{
    public function store($id, $link, $publicId, $alt, $type = 'image')
    {
        if (empty($id) || empty($link) || empty($publicId) || empty($alt)) {
            return response()->json([
                'message' => 'Please provide all required fields (id, link, publicId, alt)',
            ], 400);
        }

        return ProductImage::create([
            'sku_id' => $id,
            'image_type' => $type,
            'image_link' => $link,
            'image_public_id' => $publicId,
            'alt' => $alt,
        ]);
    }
}