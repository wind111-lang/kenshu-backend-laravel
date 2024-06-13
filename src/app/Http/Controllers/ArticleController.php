<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\ArticleRequest;

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

        return view('index', ['articles' => $articles]);
    }

    //TODO: 記事の投稿機能を作る
    public function executePostArticle(ArticleRequest $request): RedirectResponse
    {
        try{
            $uploadedImages = FileUploadService::articleImageUploader($request);
            ArticleService::postArticle($request, $uploadedImages);
        }catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->route('index');
    }
}
