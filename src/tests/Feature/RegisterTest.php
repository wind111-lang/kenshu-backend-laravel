<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
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
            ]
        ]);

        $response->assertStatus(200);
    }
}
