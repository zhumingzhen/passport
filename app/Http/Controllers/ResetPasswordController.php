<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Redis;

class ResetPasswordController extends Controller
{
    public function reset()
    {
        $mobile = request('mobile');
        $password = request('password');
        $code = request('code');

        $password_confirmation = request('password_confirmation');
        if ($password != $password_confirmation){
            return redirect()->back()->withErrors(['password'=>'两次密码不一致']);
        }

        $user = User::where('mobile', $mobile)->first();
        if (!$user){
            return redirect()->back()->withErrors(['mobile'=>'手机号未注册']);
        }
        $smsCode = Redis::get('smsCode_'.$mobile);
        // 验证短信验证码
        if ($code == '' || $smsCode != $code){
            // 验证码不正确
//            return redirect()->back()->withErrors(['code'=>'验证码错误']);
        }

        $user->update([
            'password' => bcrypt($password),
        ]);
        return redirect('/login');
    }
}
