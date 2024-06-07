<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class LoginService
{
    //TODO: Login/LogoutのDB/認証処理を書く
    public static function login(Request $request): bool
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if(Auth::attempt($credentials)){
            Session::regenerateToken();
            Session::put('token', csrf_token());
            return true;
        }else{
            return false;
        }
    }

    public static function logout(): void
    {
        session()->flush();
    }
}
