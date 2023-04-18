<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CloudinaryService
{
    public function uploadImage($image, bool $isThumbnail = false)
    {
        $uploadedFile = Cloudinary::upload($image, ['folder' => $isThumbnail ? 'thumbnails' : 'products']);

        return [
            'public_id' => $uploadedFile->getPublicId(),
            'version' => $uploadedFile->getVersion(),
            'width' => $uploadedFile->getWidth(),
            'height' => $uploadedFile->getHeight(),
            'url' => $uploadedFile->getPath(),
            'secure_url' => $uploadedFile->getSecurePath(),
        ];
    }

    public function deleteImage($publicId)
    {
        try {
            Cloudinary::destroy($publicId);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}