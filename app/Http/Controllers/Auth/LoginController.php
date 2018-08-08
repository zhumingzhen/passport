<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Proxy\TokenProxy;
use App\Repositories\AccessTokenRepository;
use App\Repositories\UserRepository;
use App\Repositories\WechatRepository;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    public function login(Request $request,
                          WechatRepository $wechatRepository,
                          AccessTokenRepository $accessTokenRepository,
                          UserRepository $userRepository)
    {
        $isUser = User::where('mobile', $request['mobile'])->first();
        // 没有用户信息插入用户表信息
        if (!$isUser){
            // 创建用户
            $returnUser = $userRepository->create($request->all());
            // 用户id
            $user_id = $returnUser->id;
        }else {
            $user_id = $isUser->id;
        }

        // 添加微信信息
        $wechatRepository->insertWechat($user_id);

        // 获取 token 并保存 token 到 redis
        $accessTokenRepository->getAccessToken($request->all());

        $code = session('redirect_code');
        $redirect = session('redirect_url');
        return redirect($redirect.'?code='.$code);
    }
}
