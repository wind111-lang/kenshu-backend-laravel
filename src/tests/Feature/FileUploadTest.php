<?php

namespace Tests\Feature;

use App\Models\UserInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileUploadTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = UserInfo::factory()->create([
            'email' => 'a@test.co.jp',
            'username' => $this->faker()->userName(),
            'password' => 'testpassword',
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00'
        ]);
    }
    /**
     * A basic feature test example.
     */
    public function testUserIconUploadTestIsSuccessfully(): void
    {
        Storage::fake('local');

        $uploadedFile = UploadedFile::fake()->image('test_image.jpg');
        $uploadedFile->store('public/userIcon/');

        Storage::disk('local')->assertExists('public/userIcon/' . $uploadedFile->hashName());
    }

    public function testUserIconUploadTestIsFail(): void
    {
        Storage::fake('local');

        $uploadedFile = UploadedFile::fake()->image('test_image.jpg');
        $uploadedFile->store('public/userIcon/');

        Storage::disk('local')->assertMissing('public/userIcon/' . 'missing.jpg');
    }

    public function testThumbnailUploadTestIsSuccessfully(): void
    {
        Storage::fake('local');

        $uploadedFile = UploadedFile::fake()->image('test_image.jpg');
        $uploadedFile->store('public/thumbnails/');

        Storage::disk('local')->assertExists('public/thumbnails/' . $uploadedFile->hashName());
    }

    public function testThumbnailUploadTestIsFail(): void
    {
        Storage::fake('local');

        $uploadedFile = UploadedFile::fake()->image('test_image.jpg');
        $uploadedFile->store('public/thumbnails/');

        Storage::disk('local')->assertMissing('public/thumbnails/' . 'missing.jpg');
    }

    public function testPostImagesUploadTestIsSuccessfully(): void
    {
        Storage::fake('local');

        $uploadedFile = UploadedFile::fake()->image('test_image.jpg');
        $uploadedFile->store('public/postImages/');

        Storage::disk('local')->assertExists('public/postImages/' . $uploadedFile->hashName());
    }

    public function testPostImagesUploadTestIsFail(): void
    {
        Storage::fake('local');

        $uploadedFile = UploadedFile::fake()->image('test_image.jpg');
        $uploadedFile->store('public/postImages/');

        Storage::disk('local')->assertMissing('public/postImages/' . 'missing.jpg');
    }
}
