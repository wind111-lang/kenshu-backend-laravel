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

    public static function userIconUploader(RegisterRequest $request): string
    {
        $file = $request->userIcon->store(self::USER_ICON_DIR);

        if (!$file){
            $file = file('./public/userIcon/default/default.png');
        }
        return pathinfo($file, PATHINFO_BASENAME);
    }

    /**
     * @throws \Exception
     */
    public static function articleImageUploader(ArticleRequest $request): void
    {

        $request->thumbnail->store(self::THUMB_DIR);

        for ($files = 0; $files < count($request->postImage); $files++) {
            $request->postImage[$files]->store(self::POST_IMAGE_DIR);
        }
    }
}
