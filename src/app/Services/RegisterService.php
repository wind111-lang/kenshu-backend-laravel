<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\UserInfo;
use App\Http\Requests\RegisterRequest;


class RegisterService
{
    /**
     * ユーザー登録処理
     * @param RegisterRequest $request
     */

    public static function register(RegisterRequest $request, string $userIconName): bool
    {

        $userinfo = new UserInfo;

        $userinfo->email = $request['email'];
        $userinfo->username = $request['username'];
        $userinfo->password = Hash::make($request['password']);
        $userinfo->user_image = $userIconName;
        $userinfo->created_at = now();
        $userinfo->updated_at = now();

        return $userinfo->save();
    }
}
