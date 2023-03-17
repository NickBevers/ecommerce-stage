<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CloudinaryController extends Controller
{
    public function index()
    {
        $url = $this->uploadImage();
        return $url;
    }

    public function uploadImage()
    {
        $uploadedFileUrl = Cloudinary::upload(public_path('redballoon.jpg'))->getSecurePath();
        return $uploadedFileUrl;
    }
}