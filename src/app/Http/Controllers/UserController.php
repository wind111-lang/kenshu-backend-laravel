<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index()
    {
        //TODO: セッション確認機能を作る
        if (Gate::allows('index', Auth::user())) {
            return view('index');
        }else{
            return redirect('login');
        }
    }
}
