<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
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
            'password' => Hash::make('password'),
        ]);

        Auth::shouldReceive('attempt')->andReturn(true, false);
        Session::shouldReceive('token')->andReturn('dummy_token');
        Session::shouldReceive('put')->andReturn(true);
    }

    public function testUserCanCallLoginWithCredentials(): void
    {
        $request = Request::create('/login', 'POST', [
            'username' => 'testuser',
            'password' => 'password',
        ]);

        Session::shouldReceive('regenerateToken')->once();

        $result = $this->loginService->login($request);

        $this->assertTrue($result);
    }

    public function testUserCanCallLogout(): void
    {
        Session::shouldReceive('flush')->once();
        $this->loginService->logout();
    }
}
