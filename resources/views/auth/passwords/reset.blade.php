@extends('layouts.app')

@section('style')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <style media="screen">
        .panel{
            margin: 40px auto;
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
                {{--<div class="col-md-8 col-md-offset-2">--}}
                    <div class="panel panel-default">
                        <div class="panel-heading">重置密码</div>

                        <div class="panel-body">
                            <form class="form-horizontal" method="POST" action="{{ route('passwordReset') }}">
                                {{ csrf_field() }}

                                {{--<input type="hidden" name="token" value="{{ $token }}">--}}

                                <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">账号</label>

                                    <div class="col-md-6">
                                        <input id="mobile" type="mobile" class="form-control" name="mobile" value="{{ $mobile or old('mobile') }}" required autofocus>

                                        @if ($errors->has('mobile'))
                                            <span class="help-block">
                                          <strong>{{ $errors->first('mobile') }}</strong>
                                      </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">密码</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                          <strong>{{ $errors->first('password') }}</strong>
                                      </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <label for="password-confirm" class="col-md-4 control-label">确认密码</label>
                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                        @if ($errors->has('password_confirmation'))
                                            <span class="help-block">
                                          <strong>{{ $errors->first('password_confirmation') }}</strong>
                                      </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">人机验证</label>

                                    <div class="col-md-6">
                                        {!! Geetest::render() !!}
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                                    <label for="code" class="col-md-4  col-xs-12 control-label">验证码</label>

                                    <div class="col-md-3 col-xs-6">
                                        <input id="code" type="text" class="form-control" name="code" value="" required>
                                        @if ($errors->has('code'))
                                            <span class="help-block">
                                          <strong>{{ $errors->first('code') }}</strong>
                                      </span>
                                        @endif
                                    </div>
                                    <div class="col-md-3 col-xs-6">
                                        <button class="btn" id="embed-submit">
                                            获取验证码
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-red">
                                            重置密码
                                        </button>

                                    </div>
                                    <a class="btn btn-link pull-right" href="{{ route('login') }}">
                                        立即登录
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                {{--</div>--}}
            </div>
        </div>
    </div>
@endsection

