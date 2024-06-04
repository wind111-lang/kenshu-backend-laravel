<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\RegisterService;

class RegisterController
{
    protected RegisterService $registerService;
    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function registerForm(): View
    {
        return view('register');
    }

    //TODO: 登録機能を作る
    public function executeRegister(Request $request)
    {
        $this->registerService->register($request);
    }
}
