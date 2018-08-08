<?php
/**
 * Created by PhpStorm.
 * User: zhumingzhen
 * Email: z@it.me
 * Date: 2018/6/8
 * Time: 19:33
 */

namespace App\Repositories;

use Flc\Dysms\Client;
use Flc\Dysms\Request\SendSms;
use Illuminate\Support\Facades\Redis;

class AlismsRepository
{

    /**
     * 发送验证码
     * @param $mobile
     * @return array
     */
    public function send($mobile)
    {
        $smsCode = rand(100000, 999999);

        // 执行发送验证码
        $res = $this->alisms($mobile, $smsCode);

        if ($res->Message == 'OK'){
            // 将验证码保存到redis
            $this->saveRedis($mobile, $smsCode);
            $data = ['code' => 62000, 'msg' => '验证码请求成功'];
        }else{
            $data = ['code' => 65000, 'msg' => '您的请求太过频繁，请稍后重试。'];
            if ($mobile == 18310459359){
                $data = ['code' => 65000, 'msg' => $res->Message];
            }
        }
        return $data;
    }

    /**
     * 验证码保存到redis
     * @param $mobile
     * @param $smsCode
     */
    public function saveRedis($mobile, $smsCode)
    {
        Redis::set('smsCode_'.$mobile,$smsCode);
        Redis::expire('smsCode_'.$mobile, 600);
//        SmsCode::create([
//            'mobile' => $mobile,
//            'smscode' => $smsCode
//        ]);
    }

    /**
     * 阿里云发送验证码
     * @param $mobile
     * @param $smsCode
     * @return mixed
     */
    public function alisms($mobile,$smsCode)
    {
        $config = [
            'accessKeyId'    => config('sms.ali.accessKeyId'),
            'accessKeySecret' =>  config('sms.ali.accessKeySecret'),
        ];

        $client  = new Client($config);
        $sendSms = new SendSms;
        $sendSms->setPhoneNumbers($mobile);
        $sendSms->setSignName(config('sms.ali.signName'));
        $sendSms->setTemplateCode(config('sms.ali.registerCode'));
        $sendSms->setTemplateParam(['code' => $smsCode, 'product' => 'sharex']);
        $sendSms->setOutId('demo');
        $res = $client->execute($sendSms);
        return $res;
    }
}