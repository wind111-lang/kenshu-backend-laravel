<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\LoginService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginServiceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */

    public function testUserCanLoginWithCorrectCredentials(): void
    {
        $user = User::factory()->create([
            'username' => 'aaa',
            'password' => 'aaa',
        ]);

        $credentials = [
            'username' => 'aaa',
            'password' => 'aaa',
        ];
    }

    public function testUserCannotLoginWithIncorrectCredentials(): void
    {
        $user = User::factory()->create([
            'username' => 'aaa',
            'password' => 'aaa',
        ]);

        $credentials = [
            'username' => 'aaa',
            'password' => 'bbb',
        ];
    }
}
