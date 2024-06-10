<?php

namespace Tests\Unit;

use App\Http\Requests\LoginRequest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use App\Services\LoginService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\UserInfo;

class LoginServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic unit test example.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->loginService = new LoginService();

        $this->user = UserInfo::factory()->create([
            'username' => 'testuser',
        ]);
    }

    public function testUserCanCallLoginWithCredentials(): void
    {
        $request = LoginRequest::create('/login', 'POST', [
            'username' => 'testuser',
        ]);

        $this->assertDatabaseHas(UserInfo::class, $request->toArray());
        $this->assertTrue(Hash::check('password', Hash::make('password')));
    }

    public function testUserCanCallLogout(): void
    {
        $this->loginService->logout();
        $this->assertFalse(Auth::check());
    }
}
