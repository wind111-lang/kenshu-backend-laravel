<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use App\Services\FileUploadService;
use App\Services\ImageService;
use App\Services\TagService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\ArticleRequest;
use App\Services\LoginService;

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

    public function articleDetail(int $id): View
    {
        try {
            $articleDetail = ArticleService::getArticleById($id);
        } catch (\Exception $e) {
            return view('index')->with('error', $e->getMessage());
        }

        return view('article', ['articleDetail' => $articleDetail[0]]);
    }

    public function executePostArticle(ArticleRequest $request): RedirectResponse
    {
        try {
            $uploadedImages = FileUploadService::articleImageUploader($request);
            ArticleService::postArticle($request);
            TagService::postTagRegister($request);
            ImageService::articleImageRegister($uploadedImages);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->route('index');
    }

    public function updateArticle(int $postId): View
    {
        $articleDetail = ArticleService::getArticleById($postId);
        return view('update', ['articleDetail' => $articleDetail[0]]);
    }

    public function executeUpdateArticle(ArticleRequest $request, int $postId): RedirectResponse
    {
        ArticleService::updateArticle($request, $postId);
        return redirect()->route('article.detail', ["id" => $postId]);
    }

    public function executeDeleteArticle(int $postId): RedirectResponse
    {
        ArticleService::deleteArticle($postId);
        return redirect()->route('index');
    }
}
