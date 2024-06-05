<?php

namespace App\Services;

use Illuminate\Http\Request;

class RegisterService
{
    //TODO: 登録のDB処理を書く
    public static function register(Request $request)
    {
        print_r($request->all());
    }
}
