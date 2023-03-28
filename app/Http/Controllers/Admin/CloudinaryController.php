<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use PhpParser\Node\Expr\Cast\Object_;

class CloudinaryController extends Controller
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
}