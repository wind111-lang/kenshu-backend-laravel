<?php

namespace App\Services;

use App\Models\Thumbnail;
use Illuminate\Support\Facades\DB;

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
}
