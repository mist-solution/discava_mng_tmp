<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () { return redirect('/login'); });
Route::get('/', function () { return view('app'); })->middleware('auth');
// それ以外は Vue.Router 参照 ⇒ /resources/js/router.js

//------------------------------------------------
// ログイン関連
// Auth::routes();
//   ルーティングをカスタマイズするため直接記載
//   ⇒ 元ファイル：/vendor/laravel/ui/src/AuthRouteMethods.php
//------------------------------------------------
// Login Route
//   /resources/views/auth/login.blade.php
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
// Logout Routes...
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
// Registration Routes...
//   /resources/views/auth/register.blade.php
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
// Password Reset Routes...
//   /resources/views/auth/passwords/email.blade.php
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//   /resources/views/auth/passwords/reset.blade.php
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
// Password Confirmation Routes...
//   /resources/views/auth/passwords/confirm.blade.php
Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm');
// Email Verification Routes...
//   /resources/views/auth/verify.blade.php
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
//   bladeなし ⇒ redirectTo '/'
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
// パスワードリセット完了
Route::get('password/complete', 'Auth\CompletePasswordController@showCompleteForm')->name('password.complete');

// それ以外
Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');
