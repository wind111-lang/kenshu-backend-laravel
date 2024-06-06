<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
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
            'password' => 'testpassword'
        ]);

        $response->assertStatus(200);
    }
}
