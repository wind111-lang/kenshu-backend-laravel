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
     * @param Request $request
     *
     */
    //TODO: 登録のDB処理を書く
    public static function register(RegisterRequest $request, string $userIconName): bool
    {
        $request->userIcon->store('public/userIcon');

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
