<?php

namespace App\Services;

use App\Models\PostImage;
use App\Models\Thumbnail;
use App\Models\PostSelectedTag;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ArticleService
{
    //TODO: 記事のDB処理を書く
    public static function getArticles(): array
    {
        $articleModel = new PostImage;

        return $articleModel::all()->toArray();
    }

    public static function postArticles(Request $request): void
    {
        $credentials = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $article = new PostImage;
        $thumbnail = new Thumbnail;

        DB::beginTransaction();

        try {

            $article->title = $credentials['title'];
            $article->body = $credentials['body'];
            $article->user_id = Session::get('id');
            $article->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

    }
}
