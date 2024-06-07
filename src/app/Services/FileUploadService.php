<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FileUploadService
{
    /**
     * @throws \Exception
     */
    const THUMB_DIR = 'public/thumbnails';
    const POST_IMAGE_DIR = 'public/postImages';

    public static function fileUploader(Request $request): void
    {
        try {
            $request->validate([
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg',
                'postImage' => 'required|array',
                'postImage.*' => 'image|mimes:jpeg,png,jpg'
            ]);

            $request->thumbnail->store(self::THUMB_DIR);

            for ($files = 0; $files < count($request->postImage); $files++) {
                $request->postImage[$files]->store(self::POST_IMAGE_DIR);
            }

        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
}
