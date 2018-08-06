<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Proxy\TokenProxy;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected $tokenProxy;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TokenProxy $tokenProxy)
    {
        $this->middleware('guest')->except('logout');
        $this->tokenProxy = $tokenProxy;
    }

    public function login()
    {
        return $this->tokenProxy->proxy('password', [
            'username' => '18310459359',   // request('mobile')
            'password' => '111111',  // request('password')
        ]);
    }
}
