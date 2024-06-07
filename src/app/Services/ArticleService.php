<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ArticleService
{
    //TODO: 記事のDB処理を書く
    public static function getArticles(): array
    {
        return [
            ['title' => '記事タイトル1', 'body' => '記事本文1'],
            ['title' => '記事タイトル2', 'body' => '記事本文2'],
            ['title' => '記事タイトル3', 'body' => '記事本文3'],
        ];
    }

    public static function postArticles(Request $request): void
    {
        $credentials = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $article = new Article;

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
