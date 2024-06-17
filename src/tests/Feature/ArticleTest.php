<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\PostImage;
use App\Models\Thumbnail;
use App\Models\UserInfo;
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
            'updated_at' => '2021-01-01 00:00:00'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    public function testArticleDetailViewAccessIsShow(): void
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


        $response = $this->get(route('article.detail', ['id' => 1]));


        $response->assertStatus(200)->assertSee($article->title)->assertSee($article->body);

    }

}
