<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WechatController extends Controller
{
  protected $app;

  public function __construct()
  {
      $this->app = app('wechat.official_account');
  }

  /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
      dd(12121);
        $this->app->server->push(function($message){
            return "欢迎关注 itdream6@163.com！";
        });
        return $this->app->server->serve();
    }
}
