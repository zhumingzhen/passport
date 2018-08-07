<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Proxy\TokenProxy;
use App\User;
use App\Wechat;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Redis;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected $tokenProxy;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TokenProxy $tokenProxy)
    {
        $this->middleware('guest')->except('logout');
        $this->tokenProxy = $tokenProxy;
    }

    public function login()
    {
        $code = session('redirect_code');
        $redirect = session('redirect_url');

        $mobile = request('mobile');
        $password = request('password');

        

        $isUser = User::where('mobile', $mobile)->first();
        // 没有用户信息插入用户表信息
        if (!$isUser){
            // 创建用户
            $returnUser = User::create([
                'username' => $mobile,
                'mobile' => $mobile,
                'password' => bcrypt($password),
            ]);

            // 用户id
            $user_id = $returnUser->id;
        }else {
            $user_id = $isUser->id;
        }

        $this->insertWechat($user_id);

        $tokenJson = $this->tokenProxy->proxy('password', [
            'username' => $mobile,   // request('mobile')
            'password' => $password,  // request('password')
        ]);

        $this->returnToken($tokenJson);

        return redirect($redirect.'?code='.$code);
    }

    public function returnToken($tokenJson){
        $code = session('redirect_code');
        Redis::set($code, $tokenJson);
        Redis::expire($code, 30000);
    }

    public function insertWechat($user_id)
    {
        $user = session('wechat.oauth_user'); // 拿到授权用户资料
        $original = $user['default']['original'];
        // 添加微信信息
        return Wechat::create([
            'user_id' => $user_id,
            'openid' => $original['openid'],
            'nickname' => $original['nickname'],
            'sex' => $original['sex'],
            'language' => $original['language'],
            'city' => $original['city'],
            'province' => $original['province'],
            'country' => $original['country'],
            'avatar' => $original['headimgurl'],
        ]);
    }
}
