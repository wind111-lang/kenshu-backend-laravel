<?php

namespace App\Services;

use App\Http\Requests\ArticleRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\PostImage;
use App\Models\Thumbnail;
use Illuminate\Support\Facades\DB;

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

        return pathinfo($file, PATHINFO_BASENAME);
    }

    /**
     * @throws \Exception
     */
    public static function articleImageUploader(ArticleRequest $request): array
    {
        $uploadedImages = [];

        $thumbFile = $request->thumbnail->store(self::THUMB_DIR);
        $thumbFilename = pathinfo($thumbFile, PATHINFO_BASENAME);

        $uploadedImages['thumb'] = $thumbFilename;

        for ($files = 0; $files < count($request->postImage); $files++) {
            $postImageFile = $request->postImage[$files]->store(self::POST_IMAGE_DIR);
            $postImageFilename = pathinfo($postImageFile, PATHINFO_BASENAME);

            $uploadedImages['postImages'][] = $postImageFilename;
        }

        return $uploadedImages;
    }
}
