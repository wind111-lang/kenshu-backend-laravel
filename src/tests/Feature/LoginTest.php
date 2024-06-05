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
    public function test_access_to_login(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_submit_login(): void
    {
        $response = $this->post('/login', [
            'username' => 'testuser',
            'password' => 'testpassword'
        ]);

        $response->assertStatus(200);
    }
}
