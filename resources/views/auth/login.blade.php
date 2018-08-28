@extends('layouts.app')

@section('style')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <style media="screen">
        {{--.content{--}}
            {{--background:url('{{ config('app.img_url').'bg.jpg' }}');--}}
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
    </style>
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">用户登录</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                                <label for="mobile" class="col-md-2 control-label">账号</label>

                                <div class="col-md-9">
                                    <input id="mobile" type="text" class="form-control" name="mobile" value="{{ old('mobile') }}" required autofocus placeholder="请输入您的手机号">

                                    @if ($errors->has('mobile'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('mobile') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-2 control-label">密码</label>

                                <div class="col-md-9">
                                    <input id="password" type="password" class="form-control" name="password" required placeholder="请输入密码">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-2 control-label">验证</label>
                                <div class="col-md-9">
                                    {!! Geetest::render() !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-9 col-md-offset-2">
                                    <button type="submit" class="btn btn-red">
                                        登录
                                    </button>

                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        忘记密码?
                                    </a>
                                    <a class="btn btn-link pull-right" href="{{ route('register') }}">
                                        立即注册
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

