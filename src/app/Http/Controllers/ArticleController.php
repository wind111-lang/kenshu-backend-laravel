<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController
{
    /**
     * 記事一覧表示
     * @return View
     */
    //TODO: 記事の一覧表示機能を作る
    public function articlesIndex(): View
    {
        $articles = ArticleService::getArticles();

        return view('index', compact('articles'));
    }

    //TODO: 記事の投稿機能を作る
    public function executePostArticle(Request $request): RedirectResponse
    {
        try{
            FileUploadService::fileUploader($request);
            ArticleService::postArticles($request);
        }catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->route('/');
    }
}
