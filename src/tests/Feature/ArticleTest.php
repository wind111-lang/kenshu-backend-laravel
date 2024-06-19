<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\PostImage;
use App\Models\PostSelectedTag;
use App\Models\Tag;
use App\Models\Thumbnail;
use App\Models\UserInfo;
use Database\Factories\PostSelectedTagFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase, WithFaker;

    public function testIndexViewAccessIsShow(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertViewIs('index');
    }

    public function testPostArticleIsSuccessfully(): void
    {
        $response = $this->from('/')->post('/', [
            'title' => 'testtitle',
            'content' => 'testcontent',
            'user_id' => 1,
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    public function testArticleDetailViewAccessIsShow(): void
    {
        $tagList = [
          '総合',
          'テクノロジー',
          'モバイル'
        ];

        UserInfo::factory()->create([
            'id' => 1,
            'email' => 'a@a.jp',
            'username' => 'testuser',
            'password' => 'password',
            'user_image' => 'testicon.png',
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00'
        ]);

        $article = Article::factory()->create([
            'id' => 1,
            'title' => 'testtitle',
            'body' => 'testcontent',
            'posted_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ]);

        Thumbnail::factory()->create([
            'thumb_url' => 'testthumb.png',
            'post_id' => 1
        ]);

        PostImage::factory()->create([
            'img_url' => 'testimage1.png',
            'post_id' => 1
        ]);

        for ($tag = 1; $tag <= 3; $tag++) {
            Tag::factory()->create([
                'id' => $tag,
                'tag' => $tagList[$tag - 1]
            ]);
        }

        for ($tag = 1; $tag <= 3; $tag++) {
            PostSelectedTag::factory()->create([
                'post_id' => 1,
                'tag_id' => $tag
            ]);
        }

        $response = $this->get(route('article.detail', ['id' => 1]));

        $response->assertStatus(200)->assertSee($article->title)->assertSee($article->body);

    }

    public function testArticleUpdateIsSuccessfully(): void
    {
        UserInfo::factory()->create([
            'id' => 1,
            'email' => 'a@a.jp',
            'username' => 'testuser',
            'password' => 'password',
            'user_image' => 'testicon.png',
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00'
        ]);

        Article::factory()->create([
            'id' => 1,
            'title' => 'testtitle',
            'body' => 'testcontent',
            'posted_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ]);

        $response = $this->from(route('article.update', ['id' => 1]))
            ->patch(route('article.update.submit', ['id' => 1]), [
                'title' => 'updatedtitle',
                'body' => 'updatedcontent',
            ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('article.detail', ['id' => 1]));
    }

    public function testArticleDeleteIsSuccessfully(): void
    {
        $tagList = [
            '総合',
            'テクノロジー',
            'モバイル'
        ];

        UserInfo::factory()->create([
            'id' => 1,
            'email' => 'a@a.jp',
            'username' => 'testuser',
            'password' => 'password',
            'user_image' => 'testicon.png',
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00'
        ]);

        Article::factory()->create([
            'id' => 1,
            'title' => 'testtitle',
            'body' => 'testcontent',
            'posted_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ]);

        Thumbnail::factory()->create([
            'thumb_url' => 'testthumb.png',
            'post_id' => 1
        ]);

        PostImage::factory()->create([
            'img_url' => 'testimage1.png',
            'post_id' => 1
        ]);

        for ($tag = 1; $tag <= 3; $tag++) {
            Tag::factory()->create([
                'id' => $tag,
                'tag' => $tagList[$tag - 1]
            ]);
        }

        for ($tag = 1; $tag <= 3; $tag++) {
            PostSelectedTag::factory()->create([
                'post_id' => 1,
                'tag_id' => $tag
            ]);
        }

        $response = $this->from(route('article.detail', ['id' => 1]))
            ->delete(route('article.delete', ['id' => 1]));

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

}
