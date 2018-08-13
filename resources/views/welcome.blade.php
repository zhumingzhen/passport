<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
            <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
                @endauth
        </div>
    @endif

    <div class="content">
        <div class="title m-b-md">
            Laravel
        </div>

        <div class="links">
            <button class="submit">refresh_token测试</button>
            <button class="submit2">接口测试</button>
        </div>
    </div>
</div>
</body>
<script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
<script>
    $(".submit").click(function(event){
        event.preventDefault();
        $.ajax({
            type:'post',
            url:'/api/login',
            dataType:'json',
            data:{
                'email':'zz@it1.me',
                'password':'111111'
            },
            success:function(data){
                console.log(data);
            },
            error:function(err){
                console.log(err);
                console.log('statusCode:'+err.status+'\n'+'statusText:'+err.statusText+'\n'+'description:\n'+JSON.stringify(err.responseJSON));
            }
        });

        /*$.ajax({
         type:'post',
         url:'/oauth/token',
         dataType:'json',
         data:{
         'grant_type': 'refresh_token',
         'refresh_token': 'def50200c2b0acaaa30ab2bc13676a342ea50933468409187b1856f1fea5e3e9d361101f5f210f5b8f255cb5cb9cd31ddf741be72295303ed403a1c19bfe145344c6abe7743e40b620e8e3100acc285b427008d62e60aabcbcebfcf3018dfb09a7719d2ec3f0498c27732b016b88160d68f3566f6f87e449c5c68720c66df05004b3c1fcc7bf66aa904ea001ac5a3eba0f3a4efcf1843e66c95c664a0728a296d0960903564d06b42b382598a0ced12dbc264b00d88b2311310da1cf82c4886c622899bc4e740fee93430b89262622b698d0ea67cac6ad90ac9905490a5591053374a4fcf2f60f88413e8657e95387f3efad6940585c1c8da3960ebca79172d1824c0abaea0d90379d772dbf402fa92d8a1a196a6aefebda1afdf48434ff87de523362bb6199261293520977b7d4dfa09152cfc825f438da8dadd2c9be95aba338c810d24cd55aaf886e35c9bda5f0008175bfc2f6767de5759341de45a3a09224501a4c',
         'client_id': '2',
         'client_secret': 'eSleJtSWLQy8vvOlxRRjoFg3HoGzTUgI5QQlBEHm',
         'scope': ''
         },
         success:function(data){
         console.log(data);
         },
         error:function(err){
         console.log(err);
         console.log('statusCode:'+err.status+'\n'+'statusText:'+err.statusText+'\n'+'description:\n'+JSON.stringify(err.responseJSON));
         }
         });*/
    });
    $(".submit2").click(function(){
        $.ajax({
            type:'post',
            url:'/api/test',
            dataType:'json',
            headers: {
                Accept: "application/json; charset=utf-8",
                Authorization:  "Bearer "+'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjQ5NTFmOWVhYWUwMDdiYjhiYjkwODljOTg0ZjJlNWE0ZDI3ZDdlYWU3MjQxODI0YjI2Yjc2ZDVkNzQ2ODE3YTdlZWQ3ODcyMzZhZTQ0Y2M1In0.eyJhdWQiOiIzIiwianRpIjoiNDk1MWY5ZWFhZTAwN2JiOGJiOTA4OWM5ODRmMmU1YTRkMjdkN2VhZTcyNDE4MjRiMjZiNzZkNWQ3NDY4MTdhN2VlZDc4NzIzNmFlNDRjYzUiLCJpYXQiOjE1MzM3MTU5ODQsIm5iZiI6MTUzMzcxNTk4NCwiZXhwIjoxNTY1MjUxOTg0LCJzdWIiOiI1MDAwOTczIiwic2NvcGVzIjpbXX0.qDsvwbG-ImAgS049mj3FNNH3Cz_5SihWd33zjUf2JH_Ep2JO7fyQiMqXKAiuUnV_QNjcnorQfSaYukMVkCQaR0EDwPSkH_I5Hejjgm6PQhmyS-C6BkIKxvFV5SPeXMzFeEfJRnFpwfwBo6E_VBFUBP7nizp0UBRb5xi3Q3i9Eo0hdvN5CoKSGHQZy0-0HKyM-oWvAWs5kRNZ9acuQOO4gndI74A41txaoUY4uFhctGaM3CuDkZonPGgFlFLYA81kkP6JFWQvRcOdm2O4B2Q4YzaFUE2sSxIfkmovoCGDozBQR411uqcrZnNby7cGOXJg3RAZuY3Rvlbkr8pACIslfcuwnRUQyBxI70Ord_7a051oMVPH1yp8Xw9Q4XnHjy_kEaXqcd8DoAxaN8I94vSSlo38Ov9cAwjZZ73hxp18AclUuS9nlDSbB9UDIsVSfqzcrcBCuN9qQ_BVtArM8_JNBSUN_8KgKi18sQYnMbhuXOQWFmfnx6DGCJkxEbACAGxPSWKAT-oUQ_Hei7cvcCgvG08xY7Jz5kJSZ1X1mfLRgFWqmvdzAF9GDq2g83DlHxGpgbAgvAtipgLWNs8U4edFQ9-A7fqNviAN2CEzKdvYBAOJlBEeoSXRgrJZd3DB38kSQF7CoNIGoRoEGo5b3ckr7MYGqCragg-G5AwBBMhiwkI'
            },
            data:{

            },
            success:function(data){
                console.log(data);
            },
            error:function(err){
                console.log(err);
                console.log('statusCode:'+err.status+'\n'+'statusText:'+err.statusText+'\n'+'description:\n'+JSON.stringify(err.responseJSON));
            }
        });
    });
</script>
</html>
