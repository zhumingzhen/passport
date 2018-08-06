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

//Route::get('/q', 'WechatController@q');
Route::get('/c', 'WechatController@cookiess');

Route::get('/usert', 'WechatController@userinfo');

Route::group(['middleware' => ['web', 'wechat.oauth:snsapi_userinfo']], function () {
    // 拿到用户信息
    Route::get('/user', 'WechatController@userinfo');
});

Route::get('/', function () {
    return view('welcome');
});


Route::get('/asdf', function (\Illuminate\Http\Request $request){
    $http = new \GuzzleHttp\Client();

    $response = $http->post('http://passport.it1.me/oauth/token', [
        'form_params' => [
            'grant_type' => 'password',
            'client_id' => '2',
            'client_secret' => 'J6cX9kQVBZATZVbvwYeo9rVzW56A51Savuhu1ily',
            'username' => '18310459359',
            'password' => '111111',
            'scope' => '*',
        ],
    ]);


    return json_decode((string)$response->getBody(), true);
});

Route::get('/useraaa', function(Request $request) {
    $guzzle = new GuzzleHttp\Client;

    $response = $guzzle->post('http://passport.test/oauth/token', [
        'form_params' => [
            'grant_type' => 'client_credentials',
            'client_id' => '4',
            'client_secret' => 'hSk53nLPCqX2jVq15k2PVWmR76SJYuUkFZ9OSy1O',
            'scope' => '*',
        ],
    ]);

    echo json_decode((string) $response->getBody(), true);
});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
