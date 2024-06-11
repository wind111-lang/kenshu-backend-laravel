<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Services\RegisterService;
use App\Services\FileUploadService;
use App\Http\Requests\RegisterRequest;

class RegisterController
{
    public function registerForm(): View
    {
        return view('register');
    }

    //TODO: 登録機能を作る

    public function executeRegister(RegisterRequest $request): RedirectResponse
    {
        try{
            $userIconName = FileUploadService::userIconUploader($request);
            RegisterService::register($request, $userIconName);
        }catch (\Exception $e) {
            return back()->withInput()->with('registerError', $e->getMessage());
        }
        return redirect()->intended('/login');
    }
}
