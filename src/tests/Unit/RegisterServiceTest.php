<?php


namespace Tests\Unit;

use App\Models\UserInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */

    use RefreshDatabase, WithFaker;

    protected function setUp():void
    {
        parent::setUp();
        $this->userInfo = UserInfo::factory()->create([
            'email' => 'test@test.jp',
            'username' => 'testuser',
            'user_image' => 'default.jpg',
            'created_at' => "2024-06-07 06:24:24",
            'updated_at' => "2024-06-07 06:24:24",
        ]);
    }

    public function testUserCanCallRegisterWithCredentials(): void
    {
        $credentials = [
            'email' => 'test@test.jp',
            'username' => 'testuser',
            'user_image' => 'default.jpg',
            'created_at' => "2024-06-07 06:24:24",
            'updated_at' => "2024-06-07 06:24:24",
        ];

        $this->assertDatabaseHas(UserInfo::class, $credentials);
        $this->assertTrue(Hash::check('password', Hash::make('password')));
    }

}
