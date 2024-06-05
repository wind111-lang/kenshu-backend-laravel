<?php

namespace App\Services;

use Illuminate\Http\Request;

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
        print_r($request->all());
    }
}
