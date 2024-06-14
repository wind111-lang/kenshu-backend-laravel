<?php

namespace App\Services;

use App\Models\Article;
use App\Models\UserInfo;
use App\Models\PostImage;
use App\Models\Thumbnail;
use App\Models\PostSelectedTag;
use App\Http\Requests\ArticleRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ArticleService
{
    public static function getArticles(): array
    {
        $result = DB::table('posts')
            ->join('userinfo', 'posts.user_id', '=', 'userinfo.id')
            ->join('thumb_image', 'posts.id', '=', 'thumb_image.post_id')
            ->select('posts.id', 'posts.title', 'posts.body', 'posts.posted_at', 'posts.updated_at', 'userinfo.username', 'userinfo.user_image', 'thumb_image.thumb_url')
            ->orderBy('updated_at', 'desc')->get()->toArray();

        return json_decode(json_encode($result), true);
    }

    public static function postArticle(ArticleRequest $request, array $uploadedImages): void
    {
        try {
            DB::beginTransaction();

            $articleModel = new Article;
            $thumbModel = new Thumbnail;
            $postImageModel = new PostImage;

            $articleModel->user_id = Session::get('id');
            $articleModel->title = $request['title'];
            $articleModel->body = $request['body'];
            $articleModel->posted_at = now();
            $articleModel->updated_at = now();

            $articleModel->save();

            $articleId = DB::table('posts')->latest('id')->first()->id;

            $thumbModel->post_id = $articleId;
            $thumbModel->thumb_url = $uploadedImages['thumb'];
            $thumbModel->save();

            for ($files = 0; $files < count($uploadedImages['postImages']); $files++) {
                $postImageModel->post_id = $articleId;
                $postImageModel->img_url = $uploadedImages['postImages'][$files];
                $postImageModel->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
