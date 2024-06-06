<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginService
{
    //TODO: Login/LogoutのDB/認証処理を書く
    public static function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $token = Session::token();

        if(Auth::attempt($credentials)){
            print('ログイン成功');
            $request->session()->regenerate();
            return redirect()->intended('index');

        }elseif (Session::token() !== $token){
            print ('トークンエラー');
            return back()->withErrors('error', 'トークンエラー');
        }

        print ('ログイン失敗');
        return back()->withErrors('error', 'ログイン失敗');
    }
}
