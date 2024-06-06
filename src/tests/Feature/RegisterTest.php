<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'email' => 'a@test.co.jp',
            'username' => 'testuser',
            'password' => 'testpassword',
            'userIcon' => [
                'name' => 'testicon.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => 'testicon.jpg',
                'error' => 0,
                'size' => 1024
            ],
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00'
        ]);
    }
    /**
     * A basic feature test example.
     */
    public function testRegisterViewAccessIsShow(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);

        $response->assertViewIs('register');
    }

    public function testSubmitRegisterIsSuccessfully(): void
    {
        $response = $this->post('/register', [
            'email' => 'a@test.co.jp',
            'username' => 'testuser',
            'password' => 'testpassword',
            'userIcon' => [
                'name' => 'testicon.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => 'testicon.jpg',
                'error' => 0,
                'size' => 1024
            ],
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
}
