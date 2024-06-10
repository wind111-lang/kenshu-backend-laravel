<?php

namespace Tests\Unit;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Services\ArticleService;
use Tests\TestCase;

class ArticleServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->articleService = new ArticleService();

        $this->article = Article::factory()->create([
            'title' => 'testtitle',
            'body' => 'testcontent',
            'posted_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00'
        ]);
    }

    public function testArticleCanPost(): void
    {
        $credentials = [
            'title' => 'testtitle',
            'body' => 'testcontent',
            'posted_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00'
        ];

        $this->assertDatabaseHas(Article::class, $credentials);

    }
}
