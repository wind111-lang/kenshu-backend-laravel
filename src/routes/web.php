<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Models\UserInfo;
use App\Models\PostImage;

//index
Route::get('/', [ArticleController::class, 'articlesIndex'])->name('index');
Route::post('/', [ArticleController::class, 'executePostArticle'])->name('article.submit');

//login, logout
Route::get('/login', [LoginController::class, 'loginForm'])->name('login');
Route::post('/login', [LoginController::class, 'executeLogin'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'executeLogout'])->name('logout');

//register
Route::get('/register', [RegisterController::class, 'registerForm'])->name('register');
Route::post('/register', [RegisterController::class, 'executeRegister'])->name('register.submit');


//article
Route::get('/article/{id}', [ArticleController::class, 'articleDetail'])->name('article.detail');
Route::get('/article/{id}/edit', [ArticleController::class, 'updateArticle'])->name('article.update');
Route::patch('/article/{id}/edit', [ArticleController::class, 'executeUpdateArticle'])->name('article.update.submit');
Route::delete('/article/{id}/delete', [ArticleController::class, 'executeDeleteArticle'])->name('article.delete');

