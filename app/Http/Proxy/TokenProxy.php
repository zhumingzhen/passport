<?php

/**
 * Created by PhpStorm.
 * User: zhumingzhen (z@it1.me)
 * Date: 2018/3/24
 * Time: 17:16
 */
namespace App\Http\Proxy;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Validation\UnauthorizedException;

class TokenProxy
{
    protected $http;

    /**
     * TokenProxy constructor.
     * @param $http
     */
    public function __construct(Client $http)
    {
        $this->http = $http;
    }

    public function proxy($grantType, array $data = [])
    {
//        try {
            // 请求地址
            $url = request()->root() . '/oauth/token';

            // 数据准备
            $data = array_merge($data, [
                'grant_type' => $grantType,
                'client_id' => config('passport.proxy.client_id'),
                'client_secret' => config('passport.proxy.client_secret'),
                'scope' => config('passport.proxy.scope')
            ]);



        // 发起请求
        $response = $this->http->post($url, [
                'form_params' => $data
            ]);
//        } catch (RequestException $exception) {
//            return redirect('login')->with('danger','账号或密码错误');
//            throw new UnauthorizedException('请求失败，服务器错误');
//        }

        if ($response->getStatusCode() != 401){
            $token = json_decode((string) $response->getBody(), true);

            return json_encode($token);
            /**
            return response()->json([
            'access_token' => $token['access_token'],
            'refresh_token' => $token['refresh_token'],
            'expires_in' => $token['expires_in'],
            ])->cookie('refresh_token', $token['refresh_token'], 86400, null, null, false, true)
            ->cookie('access_token', $token['access_token'], 86400, null, null, false, true);
             */
        }else{
//            return redirect('login')->with('danger','账号或密码错误111');
            throw new UnauthorizedException('账号或密码错误');
        }
    }
}