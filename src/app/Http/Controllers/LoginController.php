<?php

namespace App\Http\Controllers;

use App\Services\LoginService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginController
{

    public function loginForm(): View
    {
        return view('login');
    }

    //TODO: ログイン/ログアウト機能を作る
    public function executeLogin(Request $request): RedirectResponse
    {
        if(LoginService::login($request)){
            return redirect()->intended('/')->with('loginSuccess', 'ログインしました');
        }else{
            return back()->withInput()->with('loginError', 'ログインに失敗しました');
        }
    }

    public function executeLogout(Request $request):void
    {
        $request->session()->forget('username');
    }
}
