<?php

namespace Tests\Unit;

use App\Http\Requests\ArticleRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Article;
use App\Services\ArticleService;
use App\Services\LoginService;
use App\Services\RegisterService;
use App\Services\FileUploadService;
use App\Models\UserInfo;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class FileUploadServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic unit test example.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->fileUploadService = new FileUploadService;
        $this->registerService = new RegisterService();
        $this->articleService = new ArticleService();
        $this->loginService = new LoginService();

        $this->userInfo = UserInfo::factory()->create([
            'id' => 1,
            'email' => 'a@test.co.jp',
            'username' => 'testuser',
            'password' => 'testpassword',
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

    public function testUserCanUploadArticleImages(): void
    {
        $thumbImage = UploadedFile::fake()->image('testthumb.png');

        $articleImage = UploadedFile::fake()->image('testarticle.png');


        $uploadedFileList = $this->fileUploadService->articleImageUploader(new ArticleRequest([
            'thumbnail' => $thumbImage,
            'postImage' => [$articleImage],
        ]));

        $this->assertFileExists($thumbImage->getPathname());
        $this->assertFileExists($articleImage->getPathname());

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

        $uploadedFileList['postImages'] = [$articleImage->getClientOriginalName()];

        $this->articleService->postArticle(new ArticleRequest([
            'user_id' => 2,
            'title' => 'testtitle',
            'body' => 'testcontent',
            'posted_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00'
        ]), $uploadedFileList);

        $this->assertDatabaseHas('thumb_image', [
            'thumb_url' => $uploadedFileList['thumb'],
        ]);

        $this->assertDatabaseHas('post_images', [
            'img_url' => $uploadedFileList['postImages'][0],
        ]);

    }
}
