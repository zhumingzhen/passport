@extends('layouts.app')

@section('style')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <style media="screen">
        {{--.content{--}}
            {{--background:url('{{config('app.img_url').'bg.jpg'}}');--}}
        {{--}--}}
        .panel{
            width: 460px;
            margin: 40px auto;
            position: relative;
            left: 200px;
        }
        .btn-red{
            width: 100%;
            background: #c20c0c;
            color: #fff;
        }
        .btn-link{
            color: #666666;
        }
        @media (max-width:768px) {
            .panel{
                width: 90%;
                margin: 10px auto;
                left: 0;
            }
        }
        #embed-submit {
            width:125px;
            background: #c20c0c;
            color: #ffffff
        }
    </style>
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">用户注册</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('register') }}" onsubmit="return check()">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                                <label for="mobile" class="col-md-3 control-label">账号</label>

                                <div class="col-md-8">
                                    <input id="mobile" type="text" class="form-control" name="mobile" value="{{ old('mobile') }}" required autofocus placeholder="请输入手机号">

                                    @if ($errors->has('mobile'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('mobile') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-3 control-label">密码</label>

                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-3 control-label">确认密码</label>

                                <div class="col-md-8">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-md-3 control-label">人机验证</label>
                                <div class="col-md-8">
                                    {!! Geetest::render() !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                                <label for="code" class="col-md-3 col-xs-12 control-label">验证码</label>
                                <div class="col-md-4 col-xs-6">
                                    <input id="code" type="text" class="form-control" name="code" value="{{ old('code') }}" required>
                                    @if ($errors->has('code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-3 col-xs-6">
                                    <div class="btn" id="embed-submit">
                                        获取验证码
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-3">
                                    <button type="submit" class="btn btn-red">
                                        注册
                                    </button>
                                    <a class="btn btn-link pull-right" href="{{ route('login') }}">
                                        已有账号？立即登录
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
