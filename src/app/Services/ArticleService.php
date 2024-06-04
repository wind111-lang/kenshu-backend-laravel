<?php

namespace App\Services;

use Illuminate\Http\Request;

class ArticleService
{
    //TODO: 記事のDB処理を書く
    public static function getArticles()
    {
        return [];
    }

    public static function postArticles(Request $request)
    {
        print_r($request->all());
    }
}
