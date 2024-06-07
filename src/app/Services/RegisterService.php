<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class RegisterService
{
    /**
     * ユーザー登録処理
     * @param Request $request
     *
     */
    //TODO: 登録のDB処理を書く
    public static function register(Request $request): bool
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'username' => 'required',
            'password' => 'required',
            'userIcon' => 'required',
        ]);

        $userinfo = new User;

        $userinfo->email = $credentials['email'];
        $userinfo->username = $credentials['username'];
        $userinfo->password = Hash::make($credentials['password']);
        $userinfo->user_image = $credentials['userIcon'];
        $userinfo->created_at = now();
        $userinfo->updated_at = now();

        return $userinfo->save();
    }
}
