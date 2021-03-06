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

Route::get('/aaa', function () {
    $today_sexc = \Illuminate\Support\Facades\Redis::get('invite_2')?:0;

    $tom = \Carbon\Carbon::tomorrow()->timestamp;
    $now = \Carbon\Carbon::now()->timestamp;
    $expire = $tom - $now;
    $expire = 20;

    if ($today_sexc < 20){
        $sexc = 5;
        $today_sexc += $sexc;
        \Illuminate\Support\Facades\Redis::setex('invite_2', $expire, $today_sexc);
    }


    dd($today_sexc);
});

// 短信
Route::post('/registerSms', 'Common\SmsController@registerSms')->name('registerSms');

// 重置密码
Route::post('/passwordReset', 'ResetPasswordController@reset')->name('passwordReset');

// 微信
Route::any('/wechat', 'WechatController@serve');

//Route::get('/q', 'WechatController@q');
Route::get('/c', 'WechatController@cookiess');

Route::get('/usert', 'WechatController@userinfo');

Route::group(['middleware' => ['web', 'wechat.oauth:snsapi_userinfo']], function () {
    // 拿到用户信息
    Route::get('/user', 'WechatController@userinfo');
});

Route::get('/accessToken', 'WechatController@accessToken');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/logins', 'Auth\LoginController@login');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// jssdkShare
Route::get('/jssdkShare', 'WechatController@jssdkShare');
Route::get('/share', 'WechatController@share');

Route::get('/cctoken', 'WechatController@cctoken');



