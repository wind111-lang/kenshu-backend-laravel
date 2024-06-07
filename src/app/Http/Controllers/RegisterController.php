<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\RegisterService;

class RegisterController
{
    public function registerForm(): View
    {
        return view('register');
    }

    //TODO: 登録機能を作る

    public function executeRegister(RegisterRequest $request): RedirectResponse
    {
        if (RegisterService::register($request)) {
            return redirect()->intended('/login');
        } else {
            return back()->withInput()->with('registerError', '登録に失敗しました');
        }
    }
}
