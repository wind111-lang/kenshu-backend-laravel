<?php

namespace App\Services;

use App\Http\Requests\ArticleRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FileUploadService
{
    /**
     * @throws \Exception
     */

    const USER_ICON_DIR = 'public/userIcon';
    const THUMB_DIR = 'public/thumbnails';
    const POST_IMAGE_DIR = 'public/postImages';

    /**
     * @throws \Exception
     */
    public static function userIconUploader(RegisterRequest $request): string
    {
        try {
            $file = $request->userIcon->store(self::USER_ICON_DIR);
            return pathinfo($file, PATHINFO_BASENAME);
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }

        return $request->userIcon->hashName();
    }

    /**
     * @throws \Exception
     */
    public static function articleImageUploader(ArticleRequest $request): void
    {
        try {
            $request->thumbnail->store(self::THUMB_DIR);

            for ($files = 0; $files < count($request->postImage); $files++) {
                $request->postImage[$files]->store(self::POST_IMAGE_DIR);
            }

        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
}
