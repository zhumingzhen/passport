<?php
/**
 * Created by PhpStorm.
 * User: zhumingzhen
 * Email: z@it.me
 * Date: 2018/8/8
 * Time: 11:35
 */

namespace App\Repositories;

class UserRepository
{
    public function insertWechat($user_id)
    {
        $userWechat = session('wechat.oauth_user'); // 拿到授权用户资料

        dd($userWechat);
        $original = $userWechat['default']['original'];
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