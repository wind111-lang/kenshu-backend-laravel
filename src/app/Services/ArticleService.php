<?php

namespace App\Services;

use App\Models\Article;
use App\Models\LogArticle;
use App\Models\UserInfo;
use App\Models\PostImage;
use App\Models\Thumbnail;
use App\Models\PostSelectedTag;
use App\Http\Requests\ArticleRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ArticleService
{
    public static function getArticles(): array
    {
        $result = DB::table('posts')
            ->join('userinfo', 'posts.user_id', '=', 'userinfo.id')
            ->join('thumb_image', 'posts.id', '=', 'thumb_image.post_id')
            ->join('post_images', 'posts.id', '=', 'post_images.post_id')
            ->join('post_selected_tags', 'posts.id', '=', 'post_selected_tags.post_id')
            ->join('tags', 'post_selected_tags.tag_id', '=', 'tags.id')
            ->select(
                'posts.id as post_id',
                'posts.title',
                'posts.body',
                'posts.posted_at',
                'posts.updated_at',
                'userinfo.username',
                'userinfo.user_image',
                'thumb_image.thumb_url',
                'post_images.img_url',
                'tags.tag'
            )
            ->orderBy('posts.updated_at', 'desc')
            ->get();

        $groupedResults = $result->groupBy('post_id')->map(function ($group) {
            $post = $group->first();
            $tags = $group->pluck('tag')->unique()->values()->all();

            return [
                'id' => $post->post_id,
                'title' => $post->title,
                'body' => $post->body,
                'posted_at' => $post->posted_at,
                'updated_at' => $post->updated_at,
                'username' => $post->username,
                'user_image' => $post->user_image,
                'thumb_url' => $post->thumb_url,
                'tag' => $tags
            ];
        })->values()->toArray();

        return json_decode(json_encode($groupedResults), true);
    }


    public static function getArticleById(int $postId): array
    {
        $result = DB::table('posts')
            ->join('userinfo', 'posts.user_id', '=', 'userinfo.id')
            ->join('thumb_image', 'posts.id', '=', 'thumb_image.post_id')
            ->join('post_images', 'posts.id', '=', 'post_images.post_id')
            ->join('post_selected_tags', 'posts.id', '=', 'post_selected_tags.post_id')
            ->join('tags', 'post_selected_tags.tag_id', '=', 'tags.id')
            ->select(
                'posts.id as post_id',
                'posts.title',
                'posts.body',
                'posts.posted_at',
                'posts.updated_at',
                'userinfo.username',
                'userinfo.user_image',
                'thumb_image.thumb_url',
                'post_images.img_url',
                'tags.tag'
            )
            ->where('posts.id', $postId)
            ->get();

        $groupedResults = $result->groupBy('post_id')->map(function ($group) {
            $post = $group->first();

            $postImages = $group->pluck('img_url')->unique()->values()->all();
            $tags = $group->pluck('tag')->unique()->values()->all();

            return [
                'id' => $post->post_id,
                'title' => $post->title,
                'body' => $post->body,
                'posted_at' => $post->posted_at,
                'updated_at' => $post->updated_at,
                'username' => $post->username,
                'user_image' => $post->user_image,
                'thumb_url' => $post->thumb_url,
                'img_url' => $postImages,
                'tag' => $tags
            ];
        })->values()->toArray();

        return json_decode(json_encode($groupedResults), true);
    }

    public static function postArticle(ArticleRequest $request, array $uploadedImages): void
    {
        $articleModel = new Article;
        $thumbModel = new Thumbnail;

        $articleModel->user_id = Session::get('id');
        $articleModel->title = $request['title'];
        $articleModel->body = $request['body'];
        $articleModel->posted_at = now();
        $articleModel->updated_at = now();

        $articleModel->save();

        $articleId = DB::table('posts')->latest('id')->first()->id;

        $thumbModel->post_id = $articleId;
        $thumbModel->thumb_url = $uploadedImages['thumb'];
        $thumbModel->save();

        for ($files = 0; $files < count($uploadedImages['postImages']); $files++) {
            DB::table('post_images')->insert([
                'post_id' => $articleId,
                'img_url' => $uploadedImages['postImages'][$files]
            ]);
        }

        $selectedTag = DB::table('tags')->whereIn('tag', $request['tags'])->get()->toArray();
        $selectedTag = json_decode(json_encode($selectedTag), true);

        for ($tags = 0; $tags < count($selectedTag); $tags++) {
            DB::table('post_selected_tags')->insert([
                'post_id' => $articleId,
                'tag_id' => $selectedTag[$tags]['id']
            ]);
        }
    }

    public static function updateArticle(ArticleRequest $request, int $postId): void
    {
        $articleModel = new Article;
        $articleModel = $articleModel->where('id', $postId);

        $articleModel->update([
            'title' => $request['title'],
            'body' => $request['body'],
            'updated_at' => now()
        ]);
    }

    public static function deleteArticle(int $postId): void
    {
        $articleModel = new Article;
        $logArticleModel = new LogArticle;
        $thumbModel = new Thumbnail;
        $postImageModel = new PostImage;
        $postSelectedTagModel = new PostSelectedTag;

        $articleInfo = $articleModel->where('id', $postId);
        $article = $articleInfo->get()->toArray()[0];

        $logArticleModel->create([
            'user_id' => $article['user_id'],
            'title' => $article['title'],
            'body' => $article['body'],
            'posted_at' => $article['posted_at'],
            'deleted_at' => now()
        ]);

        $thumbInfo = $thumbModel->where('post_id', $postId);
        $thumb = $thumbInfo->get()->toArray()[0];
        Storage::disk('public')->delete('thumbnails/' . $thumb['thumb_url']);
        $thumbInfo->delete();

        $postImagesInfo = $postImageModel->where('post_id', $postId);
        $postImages = $postImagesInfo->get()->toArray();

        for($image = 0; $image < count($postImages); $image++) {
            Storage::disk('public')->delete('postImages/' . $postImages[$image]['img_url']);
        }
        $postImagesInfo->delete();

        $postSelectedTagModel->where('post_id', $postId)->delete();

        $articleInfo->delete();
    }
}
