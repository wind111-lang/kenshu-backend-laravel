<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController
{
    protected ArticleService $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    //TODO: 記事の一覧表示機能を作る
    public function index()
    {
        articleService::getArticles();
    }

    //TODO: 記事の投稿機能を作る
    public function executePostArticle(Request $request)
    {
        articleService::postArticles($request);
    }
}
