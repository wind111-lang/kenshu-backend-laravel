<?php

namespace Tests\Unit;

use App\Http\Requests\ArticleRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Article;
use App\Models\UserInfo;
use App\Services\ArticleService;
use App\Services\LoginService;
use App\Services\RegisterService;
use Tests\TestCase;

class ArticleServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->registerService = new RegisterService();
        $this->loginService = new LoginService();
        $this->articleService = new ArticleService();

        $this->userInfo = UserInfo::factory()->create([
            'id' => 1,
            'email' => 'a@a.jp',
            'username' => 'testuser',
            'password' => 'password',
            'user_image' => 'testicon.png',
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00'
        ]);

        $this->article = Article::factory()->create([
            'user_id' => 1,
            'title' => 'testtitle',
            'body' => 'testcontent',
            'posted_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00'
        ]);
    }

    public function testArticleCanPost(): void
    {
        $this->registerService->register(new RegisterRequest([
            'email' => 'b@b',
            'username' => 'testuser2',
            'password' => 'password',
            'user_image' => 'testicon.png',
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00'
        ]), 'default.png');

        $this->loginService->login(new LoginRequest([
            'username' => 'testuser2',
            'password' => 'password'
        ]));

        $this->articleService->postArticle(new ArticleRequest([
            'user_id' => 2,
            'title' => 'testtitle',
            'body' => 'testcontent',
            'posted_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00'
        ]));

        $this->assertTrue(Article::where('title', 'testtitle')->exists());

    }
}
