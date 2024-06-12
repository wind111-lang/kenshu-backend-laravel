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

    const USER_ICON_DIR = '/userIcon';
    const THUMB_DIR = '/thumbnails';
    const POST_IMAGE_DIR = '/postImages';

    public static function userIconUploader(RegisterRequest $request): string
    {
        $file = $request->userIcon->store(self::USER_ICON_DIR);

        return pathinfo($file, PATHINFO_BASENAME);
    }

    /**
     * @throws \Exception
     */
    public static function articleImageUploader(ArticleRequest $request): void
    {

        try {
            DB::beginTransaction();

            $thumbModel = new Thumbnail;
            $postImageModel = new PostImage;

            $articleId = DB::table('posts')->latest('id')->first()->id;

            $thumbFile = $request->thumbnail->store(self::THUMB_DIR);
            $thumbFilename = pathinfo($thumbFile, PATHINFO_BASENAME);

            $thumbModel->post_id = $articleId;
            $thumbModel->thumb_url = $thumbFilename;
            $thumbModel->save();

            for ($files = 0; $files < count($request->postImage); $files++) {
                $postImageFile = $request->postImage[$files]->store(self::POST_IMAGE_DIR);
                $postImageFilename = pathinfo($postImageFile, PATHINFO_BASENAME);

                $postImageModel->post_id = $articleId;
                $postImageModel->img_url = $postImageFilename;
                $postImageModel->save();
            }
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }
    }
}
