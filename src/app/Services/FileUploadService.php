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
    public static function fileUploader(Request $request): void
    {
        $thumbDir = 'public/thumbnails';
        $postImageDir = 'public/postImages';

        try {
            $request->validate([
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg',
                'postImage' => 'required|array',
                'postImage.*' => 'image|mimes:jpeg,png,jpg'
            ]);

            $request->thumbnail->store($thumbDir);

            for ($files = 0; $files < count($request->postImage); $files++) {
                $request->postImage[$files]->store($postImageDir);
            }

        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
}
