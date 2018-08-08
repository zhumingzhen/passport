<?php

namespace App\Http\Controllers\Common;

use App\Repositories\AlismsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SmsController extends Controller
{
    protected $alismsRepository;

    public function __construct(AlismsRepository $alismsRepository)
    {
        $this->alismsRepository = $alismsRepository;
    }

    public function registerSms(Request $request)
    {
        $result = $this->validate($request, [
            'geetest_challenge' => 'geetest',
        ], [
            'geetest' => config('geetest.server_fail_alert')
        ]);
        if (!$request) {
            echo json_encode(['code' => 65000, 'msg' => '验证码错误，请重新验证。']);
            die();
        }
        $this->sendSmsByMobile($request->mobile);
    }
    /**
     * 获取短信验证码
     * @param AlismsRepository $alismsRepository
     */
    public function sendSmsByMobile($mobile)
    {
        $data = $this->alismsRepository->send($mobile);

        echo json_encode($data);
        die();
    }
}
