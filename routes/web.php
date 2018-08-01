<?php

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

// 微信
Route::any('/wechat', 'WechatController@serve');

Route::any('/aa', 'WechatController@aa');
Route::any('/bb', 'WechatController@bb');

Route::group(['middleware' => ['web', 'wechat.oauth:snsapi_userinfo']], function () {
    Route::get('/user', function () {
        $user = session('wechat.oauth_user'); // 拿到授权用户资料
    });
});

Route::get('/', function () {
    return view('welcome');
});
