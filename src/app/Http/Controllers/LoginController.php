<?php

namespace App\Http\Controllers;

use App\Services\LoginService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginController
{
    protected LoginService $loginService;
    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function loginForm(): View
    {
        return view('login');
    }

    //TODO: ログイン/ログアウト機能を作る
    public function executeLogin(Request $request)
    {
        $this->loginService::login($request);
    }

    public function executeLogout(Request $request)
    {
        $request->session()->forget('username');
    }
}
