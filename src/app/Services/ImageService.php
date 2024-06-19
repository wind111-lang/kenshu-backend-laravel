<?php

namespace App\Services;

use App\Models\Thumbnail;
use App\Models\PostImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public static function articleImageRegister(array $uploadedImages): void
    {
        $thumbModel = new Thumbnail;

        $articleId = DB::table('posts')->latest('id')->first()->id;

        $thumbModel->post_id = $articleId;
        $thumbModel->thumb_url = $uploadedImages['thumb'];
        $thumbModel->save();

        for ($files = 0; $files < count($uploadedImages['postImages']); $files++) {
            DB::table('post_images')->insert([
                'post_id' => $articleId,
                'img_url' => $uploadedImages['postImages'][$files]
            ]);
        }
    }

    public static function articleImageDelete(int $postId): void
    {

        $thumbInfo = Thumbnail::where('post_id', $postId);
        $thumb = $thumbInfo->get()->toArray()[0];

        Storage::disk('public')->delete('thumbnails/' . $thumb['thumb_url']);
        $thumbInfo->delete();

        $postImagesInfo =  PostImage::where('post_id', $postId);
        $postImages = $postImagesInfo->get()->toArray();

        for($image = 0; $image < count($postImages); $image++) {
            Storage::disk('public')->delete('postImages/' . $postImages[$image]['img_url']);
        }

        $postImagesInfo->delete();
    }
}
