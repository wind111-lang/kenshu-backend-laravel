<?php
namespace Tests\Unit;
use App\Http\Requests\ArticleRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Article;
use App\Models\PostImage;
use App\Models\Thumbnail;
use App\Models\UserInfo;
use App\Services\ArticleService;
use App\Services\ImageService;
use App\Services\LoginService;
use App\Services\RegisterService;
use App\Services\TagService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ArticleServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic unit test example.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->registerService = new RegisterService();
        $this->loginService = new LoginService();
        $this->articleService = new ArticleService();
        $this->imageService = new ImageService();
        $this->tagService = new TagService();

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
            'id' => 1,
            'user_id' => 1,
            'title' => 'testtitle',
            'body' => 'testcontent',
            'posted_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00'
        ]);
    }
    public function testArticleCanPost(): void
    {
        $this->loginService->login(new LoginRequest([
            'username' => 'testuser',
            'password' => 'password'
        ]));

        $this->articleService->postArticle(new ArticleRequest([
            'user_id' => 1,
            'title' => 'testtitle',
            'body' => 'testcontent',
            'posted_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
            'tags' => ['総合', 'アプリ']
        ]));

        $this->imageService::articleImageRegister([
            'thumb' => 'testThumb.png',
            'postImages' => ['testImage1.png', 'testImage2.png']
        ]);

        $this->tagService::postTagRegister(new ArticleRequest([
            'tags' => ['総合', 'アプリ']
        ]));


        $this->assertDatabaseHas('posts', [
            'title' => 'testtitle',
            'body' => 'testcontent',
            'posted_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00'
        ]);

    }

    public function testArticleCanGet(): void
    {
        $articles = $this->articleService->getArticles();
        $this->assertIsArray($articles);
    }

    public function testArticleCanGetById(): void
    {
        $article = $this->articleService->getArticleById(1);
        $this->assertIsArray($article);
    }

    public function testArticleUpdate(): void
    {
        $this->loginService->login(new LoginRequest([
            'username' => 'testuser',
            'password' => 'password'
        ]));

        $this->articleService->updateArticle(new ArticleRequest([
            'title' => 'updatetitle',
            'body' => 'updatecontent',
            'updated_at' => now(),
        ]), 1);

        $this->assertDatabaseHas('posts', [
            'title' => 'updatetitle',
            'body' => 'updatecontent',
        ]);
    }

    public function testArticleDelete(): void
    {
        Storage::fake('local');

        $thumbFile = UploadedFile::fake()->image('testthumb.png')->store('thumbnails/');
        $postImagesFile = [
            UploadedFile::fake()->image('testimage1.png')->store('postImages/'),
            UploadedFile::fake()->image('testimage2.png')->store('postImages/')
        ];

        Thumbnail::factory()->create([
            'id' => 1,
            'post_id' => 1,
            'thumb_url' => $thumbFile
        ]);

        for ($image = 1; $image <= count($postImagesFile); $image++) {
            PostImage::factory()->create([
                'id' => $image,
                'post_id' => 1,
                'img_url' => $postImagesFile[$image - 1]
            ]);
        }

        $this->articleService->deleteArticle(1);

        $this->assertDatabaseMissing('posts', [
            'id' => 1
        ]);

        Storage::fake('local');
    }
}
