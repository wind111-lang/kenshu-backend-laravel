<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Http\Requests\LoginRequest;
class LoginService
{
    //TODO: Login/LogoutのDB/認証処理を書く
    public static function login(LoginRequest $request): bool
    {
        if(Auth::attempt($request->only('username', 'password'))){
            Session::regenerateToken();
            Session::put('token', csrf_token());
            Session::put('id', Auth::id());
            return true;
        }else{
            return false;
        }
    }

    public static function logout(): void
    {
        session()->flush();
        Auth::logout();
    }
}
