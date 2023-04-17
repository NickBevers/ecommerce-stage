<?php

namespace App\Services;


use App\Models\ProductImage;
use Illuminate\Support\Arr;
use PhpParser\Node\Expr\Array_;

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

    public function uploadVariationImage(Array $images, Array $urls): array
    {
        foreach ($images as $image) {
            $type = 'image';
            $isThumbnail = false;
            if ($images[0] == $image) {
                $type = ('thumbnail');
                $isThumbnail = true;
            }
            $cloudinaryData = $this->cloudinaryService->uploadImage($image->getRealPath(), $isThumbnail);

            $urls[] = [
                'url' => $cloudinaryData['secure_url'],
                'public_id' => $cloudinaryData['public_id'],
            ];
        }
            return $urls;
    }

    public function deleteVariationImage(string $publicId)
    {
        return $this->cloudinaryService->deleteImage($publicId);
    }

    public function delete($skuId)
    {
        $productImages = ProductImage::where('sku_id', $skuId)->get();
        foreach ($productImages as $productImage) {
            $this->cloudinaryService->deleteImage($productImage->public_id);
            $productImage->delete();
        }
    }
}