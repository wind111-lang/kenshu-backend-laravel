<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController
{
    //TODO: 記事の一覧表示機能を作る
    public function index()
    {
        ArticleService::getArticles();
    }

    //TODO: 記事の投稿機能を作る
    public function executePostArticle(Request $request)
    {
        ArticleService::postArticles($request);
    }
}
