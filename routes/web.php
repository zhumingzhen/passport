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

Route::group(['middleware' => ['web', 'wechat.oauth:snsapi_userinfo']], function () {
    // 拿到用户信息
    Route::get('/user', 'WechatController@bb');
});

Route::get('/', function () {
    return view('welcome');
});
