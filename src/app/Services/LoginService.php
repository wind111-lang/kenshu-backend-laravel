<?php

namespace App\Services;

use Illuminate\Http\Request;

class LoginService
{
    //TODO: Login/LogoutのDB/認証処理を書く
    public static function login(Request $request)
    {
        print_r($request->all());
    }
}
