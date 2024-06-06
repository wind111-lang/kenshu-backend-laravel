<?php

namespace App\Http\Controllers;

use App\Services\LoginService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginController
{

    public function loginForm(): View
    {
        return view('login');
    }

    //TODO: ログイン/ログアウト機能を作る
    public function executeLogin(Request $request):void
    {
        LoginService::login($request);
    }

    public function executeLogout(Request $request):void
    {
        $request->session()->forget('username');
    }
}
