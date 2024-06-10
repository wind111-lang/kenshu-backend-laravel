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
    //TODO: 記事のDB処理を書く
    public static function getArticles(): array
    {
        $result = DB::table('posts')
            ->join('userinfo', 'posts.user_id', '=', 'userinfo.id')
            ->select('posts.id', 'posts.title', 'posts.body', 'posts.posted_at', 'posts.updated_at','userinfo.username')
            ->get()->toArray();

        return json_decode(json_encode($result), true);
    }

    public static function postArticle(ArticleRequest $request): void
    {
        $articleModel = new Article;

        try {
            $articleModel->user_id = Session::get('id');
            $articleModel->title = $request['title'];
            $articleModel->body = $request['body'];
            $articleModel->posted_at = now();
            $articleModel->updated_at = now();

            $articleModel->save();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
