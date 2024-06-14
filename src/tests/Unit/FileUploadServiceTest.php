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
    }

    // ここのサイズはKilobytes
    public function testUserCanUploadUserIcon(): void
    {
        $userIcon = UploadedFile::fake()->image('testicon.png')->size(1000);

        $uploadedFile = $this->fileUploadService->userIconUploader(new RegisterRequest([
            'userIcon' => $userIcon,
        ]));

        $this->assertIsString($uploadedFile);
    }

    public function testUserCanUploadArticleImages(): void
    {
        $thumbImage = UploadedFile::fake()->image('testthumb.png')->size(2500);
        $articleImage = UploadedFile::fake()->image('testarticle.png')->size(5000);
        $articleImage2 = UploadedFile::fake()->image('testarticle2.jpg')->size(5000);


        $uploadedFileList = $this->fileUploadService->articleImageUploader(new ArticleRequest([
            'thumbnail' => $thumbImage,
            'postImage' => [$articleImage, $articleImage2],
        ]));

        $this->assertArrayHasKey('thumb', $uploadedFileList);
        $this->assertArrayHasKey('postImages', $uploadedFileList);
    }

    public function testUserUploadMultipleImages():void
    {
        $articleImages = [];

        $thumbImage = UploadedFile::fake()->image('testthumb.png')->size(2500);

        for ($image = 0; $image < 5; $image++){
            $articleImages[] = UploadedFile::fake()->image('testarticle'.$image.'.jpg')->size(5000);
            $articleImages[] = UploadedFile::fake()->image('testarticle'.$image.'.png')->size(5000);
        }

        $uploadedFileList = $this->fileUploadService->articleImageUploader(new ArticleRequest([
            'thumbnail' => $thumbImage,
            'postImage' => $articleImages,
        ]));

        $this->assertArrayHasKey('thumb', $uploadedFileList);
        $this->assertArrayHasKey('postImages', $uploadedFileList);
    }

    public function testUserUploadedFileSizeExceeded(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('ファイルサイズが大きすぎます');

        $thumbImage = UploadedFile::fake()->image('testthumb.png')->size(15000);
        $articleImage = UploadedFile::fake()->image('testarticle.jpg')->size(15000);

        $uploadedFileList = $this->fileUploadService->articleImageUploader(new ArticleRequest([
            'thumbnail' => $thumbImage,
            'postImage' => [$articleImage],
        ]));

        $this->assertArrayNotHasKey('thumb', $uploadedFileList);
        $this->assertArrayNotHasKey('postImages', $uploadedFileList);
    }

    public function testUserUploadedUnexpectedFileFormat(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('ファイル形式が不正です');

        $thumbImage = UploadedFile::fake()->image('testthumb.png')->size(2500);
        $articleImage = UploadedFile::fake()->image('testarticle.jpg')->size(5000);
        $articleImage2 = UploadedFile::fake()->image('testarticle2.pdf')->size(10000);

        $uploadedFileList = $this->fileUploadService->articleImageUploader(new ArticleRequest([
            'thumbnail' => $thumbImage,
            'postImage' => [$articleImage, $articleImage2],
        ]));

        $this->assertArrayNotHasKey('thumb', $uploadedFileList);
        $this->assertArrayNotHasKey('postImages', $uploadedFileList);
    }
}
