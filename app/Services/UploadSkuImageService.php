<?php

namespace App\Services;


class UploadSkuImageService
{
    private CloudinaryService $cloudinaryService;
    private ProductImageService $productImageService;

    public function __construct()
    {
        $this->cloudinaryService = new CloudinaryService();
        $this->productImageService = new ProductImageService();
    }

    public function upload(Array $images, Int $skuId)
    {
        foreach ($images as $image) {
            $type = 'image';
            $isThumbnail = false;
            if ($images[0] == $image) {
                $type = ('thumbnail');
                $isThumbnail = true;
            }
            $cloudinaryData = $this->cloudinaryService->uploadImage($image, $isThumbnail);
            $this->productImageService->store($skuId, $cloudinaryData['secure_url'], $cloudinaryData['public_id'], "productImage", $type);
        }
    }
}