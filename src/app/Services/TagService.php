<?php

namespace App\Services;

use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\DB;

class TagService
{
    public function getTags(array $tags): array
    {
        $tagList = DB::table('tags')->whereIn('tag', $tags)->get()->toArray();
        return json_decode(json_encode($tagList), true);
    }

    public static function postTagRegister(ArticleRequest $request): void
    {
        $articleId = DB::table('posts')->orderBy('updated_at', 'desc')->first()->id;

        $selectedTag = (new TagService)->getTags($request['tags']);
        $selectedTag = json_decode(json_encode($selectedTag), true);

        for ($tags = 0; $tags < count($selectedTag); $tags++) {
            DB::table('post_selected_tags')->insert([
                'post_id' => $articleId,
                'tag_id' => $selectedTag[$tags]['id']
            ]);
        }
    }
}
