<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController
{
    //TODO: 記事の一覧表示機能を作る
    public function articlesIndex(): View
    {
        $articles = ArticleService::getArticles();
        return view('index', ['articles' => $articles]);
    }

    //TODO: 記事の投稿機能を作る
    public function executePostArticle(Request $request): void
    {
        ArticleService::postArticles($request);
    }
}
