<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

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
    public function register(Request $request)
    {
        $code = session('redirect_code');
        $redirect = session('redirect_url');

        $this->validator($request->all())->validate();


        $smsCode = Redis::get('smsCode_'.$request['mobile']);
        // 验证手机号
        if (\App\User::where('mobile',$request['mobile'])->first()){
            return redirect()->back()->withErrors(['mobile'=>'手机号已存在']);
        }
        // 验证短信验证码
        if ($request['code'] == '' || $smsCode != $request['code']){
            // 验证码不正确
//            return redirect()->back()->withErrors(['code'=>'验证码错误']);
        }

        event(new Registered($user = $this->create($request->all())));

        $tokenJson = $this->tokenProxy->proxy('password', [
            'username' => $request['mobile'],   // request('mobile')
            'password' => $request['password'],  // request('password')
        ]);

        $this->returnToken($tokenJson);

        return redirect($redirect.'?code='.$code);

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    public function returnToken($tokenJson){
        $code = session('redirect_code');
        Redis::set($code, $tokenJson);
        Redis::expire($code, 30000);
    }
}
