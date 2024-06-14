<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\UserInfo;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->userInfo = UserInfo::factory()->create([
            'username' => 'testuser',
            'password' => Hash::make('password'),
        ]);
    }

    public function testLoginViewAccessIsShow(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('login');

    }

    public function testSubmitLoginIsSuccessfully(): void
    {
        $response = $this->post('/login', [
            'username' => 'testuser',
            'password' => 'password'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/');

        $this->assertAuthenticatedAs($this->userInfo);
    }

    public function testUserCannotLoginWithIncorrectCredentials()
    {
        // 誤った認証情報を使用してリクエストを作成
        $response = $this->post('/login', [
            'username' => 'testuser',
            'password' => 'wrongpassword',
        ]);

        // レスポンスを確認
        $response->assertStatus(302);
        $response->assertSessionHas('loginError', 'ログインに失敗しました');

        // 認証が失敗したことを確認
        $this->assertGuest();
    }

}
