<?php
/**
 * Created by PhpStorm.
 * User: zhumingzhen
 * Email: z@it.me
 * Date: 2018/8/8
 * Time: 11:35
 */

namespace App\Repositories;

use App\Http\Proxy\TokenProxy;

class AccessTokenRepository
{
    protected  $tokenProxy;

    public function __construct(TokenProxy $tokenProxy)
    {
        $this->tokenProxy = $tokenProxy;
    }

    public function returnToken($tokenJson){
        $code = session('redirect_code');
        Redis::set($code, $tokenJson);
        Redis::expire($code, 30000);
    }

    public function getAccessToken(array $data)
    {
        // 代理模式
        $tokenJson = $this->tokenProxy->proxy('password', [
            'username' => $data['mobile'],   // request('mobile')
            'password' => $data['password'],  // request('password')
        ]);

        $this->returnToken($tokenJson);

        return $tokenJson;
    }
}