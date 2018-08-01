<?php

namespace App\Http\Controllers;

use EasyWeChat;
use Illuminate\Http\Request;

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

    public function userinfo()
    {
        $user = session('wechat.oauth_user'); // 拿到授权用户资料

        return $user;   // ['original']['openid']
    }
}
