<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Models\User;
use App\Models\Article;


Gate::define('index', function(User $user){
    return $user->username === $user;
});

//index
Route::group(['prefix'=>'/'], function (){
    Route::get('/', [ArticleController::class, 'index']);
    Route::get('/', [UserController::class, 'index']);
});

//login, logout
Route::get('/login', [LoginController::class, 'loginForm'])->name('login');
Route::post('/login', [LoginController::class, 'executeLogin'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'executeLogout']);

//register
Route::get('/register', [RegisterController::class, 'registerForm'])->name('register');
Route::post('/register', [RegisterController::class, 'executeRegister'])->name('register.submit');

//article
Route::post('/', [ArticleController::class, 'executePostArticle'])->name('article.submit');
Route::get('/articles/{id}', [ArticleController::class, 'articleDetail']);
Route::patch('/articles/{id}', [ArticleController::class, 'executeUpdateArticle']);
Route::delete('/articles/{id}', [ArticleController::class, 'executeDeleteArticle']);

