<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Http\Request;
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
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg',
            'postImages'=> 'required|array',
            'tags' => 'required|array',
        ]);

        /*
        $thumbnailPath = $request->thumbnail->store('public/thumbnails');
        $postImagePaths = [];

        foreach ($request->postImages as $postImage) {
            $postImagePaths[] = $postImage->store('public/postImages');
        }

        $credentials = $request->only('user_id', 'title', 'body', 'thumbnail', 'postImages', 'tags');

        for($files = 0; $files < count($postImagePaths); $files++){
            $article = new Article;

            $article->user_id = Session::get('id');
            $article->title = $credentials['title'];
            $article->body = $credentials['body'];
        }
        */

    }
}
