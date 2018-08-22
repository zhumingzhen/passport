<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\LoginController;
use App\User;
use App\Wechat;
use EasyWeChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;

class WechatController extends Controller
{
  protected $app;

  public function __construct()
  {
//      $this->app = app('wechat.official_account');
      $this->app = EasyWeChat::officialAccount(); // 公众号
  }

  /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        $this->app->server->push(function($message){
            return "欢迎关注 itdream6@163.com！";
        });
        return $this->app->server->serve();
    }

    public function userinfo(LoginController $loginController,User $userModel)
    {
        // 返回码
        $code = md5(uniqid());
        // 回调地址
        $redirect = $_GET['redirect'];
        session(['redirect_code' => $code]);
        session(['redirect_url' => $redirect]);

        $user = session('wechat.oauth_user'); // 拿到授权用户资料

//        $original = $user['default']['original'];
//        $openid = $original['openid'];
        $openid = '12121';

        $isWechat = Wechat::where('openid', $openid)->first();  // firstOrFail

//        $userModel->username('openid');

        /**
         * 业务系统判断没有登录
         * 跳转到认证系统 携带 来源地址 存redis
         * 跳到获取用户信息页面
         * 如果 openid 不存在跳到认证系统登录页面
         *  登录填写手机号获取验证码
         *  从 session 获取到 openid 绑定 opened 保存到数据库
         *  获取到 token 存 redis 跳回来源页
         * 如果 openid 存在 跳回来源页
         *  根据 openid 获取到 token 存 redis
         *  跳回来源页
         *
         */
        if ( !$isWechat ) {
            // 如果没有当前 openid 信息，则跳转到手机号登录页面
            return view('auth.login');

        }else {
            // 如果已存在当前 openid 信息，则跳转到来源页面  url()->previous()
            if (url()->current() == $_GET['redirect']){
                // 重定向失败 可跳转到 404 页面
                return '重定向到了自身，结束死循环。上一页地址：'.$_GET['redirect'].' ；当前页地址'.url()->current();
            }

            $user = User::find($isWechat->user_id);
            $token = $user->createToken($isWechat->openid)->accessToken;

            Redis::set($code, $token);
            Redis::expire($code, 3000);
            return redirect($redirect.'?code='.$code);
        }
    }


    public function jssdk()
    {
//        $this->app->jssdk->setUrl('http://aaa.com');
        $aa = $this->app->jssdk->buildConfig(array('onMenuShareQQ', 'onMenuShareWeibo'), true);
        return $aa;
    }

    public function share()
    {

        $app = $this->app;
        return view('share',compact('app'));
    }


}
