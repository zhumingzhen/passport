<?php

namespace App\Http\Controllers\Auth;

use App\CenterAward;
use App\CenterSexcDetail;
use App\Repositories\AccessTokenRepository;
use App\Repositories\WechatRepository;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Http\Proxy\TokenProxy;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TokenProxy $tokenProxy)
    {
        $this->middleware('guest');
        $this->tokenProxy = $tokenProxy;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'mobile' => 'required|min:11|max:11',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'mobile' => $data['mobile'],
            'username' =>  substr_replace($data['mobile'],'****',3,4),
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * 重写父类方法
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register(Request $request, WechatRepository $wechatRepository, AccessTokenRepository $accessTokenRepository)
    {
        $this->validator($request->all())->validate();

        $smsCode = Redis::get('smsCode_'.$request['mobile']);
        // 验证手机号
        if (User::where('mobile',$request['mobile'])->first()){
            return redirect()->back()->withErrors(['mobile'=>'手机号已存在']);
        }
        // 验证短信验证码
        if ($request['code'] == '' || $smsCode != $request['code']){
            // 验证码不正确
//            return redirect()->back()->withErrors(['code'=>'验证码错误']);
        }

        event(new Registered($user = $this->create($request->all())));

        // 获取 token 并保存 token 到 redis
        $token = $accessTokenRepository->getAccessToken($request->all());

        // 添加微信信息
        $wechatRepository->insertWechat($user->id);

        // 邀请用户 给 邀请人送币
        $invite_user_id = session('invite_user_id');
        if ($invite_user_id){
            $sexc = rand(5,10);
            CenterAward::where('user_id',$invite_user_id)->increment('sexc',$sexc);
            CenterSexcDetail::create([
                'user_id' => $invite_user_id,
                'sexc' => $sexc,
                'continuous' => 3,
                'gain' => 1
            ]);
        }

        // 跳回 redirect
        // 获取跳转参数
        $code = session('redirect_code');
        $redirect = session('redirect_url');
        return redirect($redirect.'?code='.$code);

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }




}
