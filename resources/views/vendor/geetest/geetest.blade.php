<script src="http://cdn.bootcss.com/jquery/2.1.0/jquery.min.js"></script>
<script src="https://static.geetest.com/static/tools/gt.js"></script>
<div id="{{ $captchaid }}"></div>
<p id="wait-{{ $captchaid }}" class="show">正在加载验证码...</p>
@define use Illuminate\Support\Facades\Config
<script>
    var geetest = function(url) {
        var handlerEmbed = function(captchaObj) {
//            captchaObj.onClose(function () {ß
//                alert('请先完成验证！');
//            });
            {{--$("#{{ $captchaid }}").closest('form').submit(function(e) {--}}
            $("#{{ $captchaid }}").closest('form').submit(function(e) {
                var validate = captchaObj.getValidate();
                if (!validate) {
                    alert('{{ Config::get('geetest.client_fail_alert')}}');
                    e.preventDefault();
                }
            });
            $("#embed-submit").click(function (e) {
                var validate = captchaObj.getValidate();
                console.log(validate);
                if (!validate) {
                    alert('{{ Config::get('geetest.client_fail_alert')}}');
                    e.preventDefault();
                }else {
                    // var extension = $("#phone").intlTelInput("getSelectedCountryData");
                    var mobile = $("#mobile").val();
                    var reg = /^1\d{10}$/;
                    if(!reg.test(mobile)){
                        alert("@lang('请输入正确的手机格式!')");
                        return false;
                    }
                    var obj = $(this);
                    obj.attr("disabled",true);
                    $.ajax({
                        url:'/registerSms',
                        type:'post',
                        data:{
                            _token:"{{csrf_token()}}",
                            mobile:mobile,
                            geetest_challenge: validate.geetest_challenge,
                            geetest_validate: validate.geetest_validate,
                            geetest_seccode: validate.geetest_seccode
                        },
                        dataType:'json',
                        success:function(data){
                            if(data.code == 62000){
                                alert(data.msg);
                                var num = 60;
                                var time = setInterval(function(){
                                    num--;
                                    obj.text(num+" s");
                                    if(num ==0){
                                        clearInterval(time);
                                        obj.text("@lang('重新获取验证码')");
                                        obj.attr("disabled",false);
                                    }
                                },1000);
                            }else {
//                              $("#captcha").trigger("click");  // 执行不通过刷新验证码
                                alert(data.msg);
                                obj.attr("disabled",false);
                                captchaObj.reset(); // 调用该接口进行重置
                            }
                        }
                    })
                }
            });
            captchaObj.appendTo("#{{ $captchaid }}");
            captchaObj.onReady(function() {
                $("#wait-{{ $captchaid }}")[0].className = "hide";
            });
            if ('{{ $product }}' == 'popup') {
                captchaObj.bindOn($('#{{ $captchaid }}').closest('form').find(':submit'));
                captchaObj.appendTo("#{{ $captchaid }}");
            }
        };
        $.ajax({
            url: url + "?t=" + (new Date()).getTime(),
            type: "get",
            dataType: "json",
            success: function(data) {
                console.log(data);
                initGeetest({
                    gt: data.gt,
                    challenge: data.challenge,
                    product: "{{ $product?$product:Config::get('geetest.product', 'float') }}",
                    offline: !data.success,
                    new_captcha: data.new_captcha,
                    lang: '{{ Config::get('geetest.lang', 'zh-cn') }}',
                    http: '{{ Config::get('geetest.protocol', 'http') }}' + '://'
                }, handlerEmbed);
            }
        });
    };
    (function() {
        geetest('{{ $url?$url:Config::get('geetest.url', 'geetest') }}');
    })();
</script>
<style>
    .hide {
        display: none;
    }
</style>

