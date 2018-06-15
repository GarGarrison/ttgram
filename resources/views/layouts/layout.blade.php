<!DOCTYPE html>
<html lang="ru">
<head>
    <title>TTGram</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/libs/materialize/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <script type="text/javascript" src="/dist/common.js"></script>
    <!-- <link rel="stylesheet" type="text/css" href="/libs/kladr/kladr.css">
    <link rel="stylesheet" type="text/css" href="/libs/modal.css"> -->
    <!-- <script type="text/javascript" src="/libs/vue_dev.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@0.12.0/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.13.1/lodash.min.js"></script>
    <script type="text/javascript" src="/libs/cleave/cleave.min.js"></script>
    <script type="text/javascript" src="/libs/cleave/addons/cleave-phone.ru.js"></script>
    <script type="text/javascript" src="/libs/kladr/Kladr.js"></script>
    <script type="text/javascript" src="/libs/tlg_components.js"></script>
    <script type="text/javascript" src="/js/validation.js"></script> -->
</head>
<body>
    <div id="ttgram" class="container">
        <div class="top-strip">
            <a href="{{ route('info') }}"><img class="table-info" src="/img/info.png"></a>
            <a href="{{ route('profile') }}"><img class="user-info" src="/img/account.png"></a>
            @if (Auth::user())
                
                <div class="auth">
                    <a href="{{ route('logout') }}"><img src="/img/auth.png"><span class="top-span">Выйти</span></a>
                </div>
            @else
                <div class="auth">
                    <a href="{{ route('login') }}"><img src="/img/auth.png"><span class="top-span">Вход</span></a>
                </div>
            @endif
        </div>
        <div class="hat">
            <a href="{{ route('root') }}"><img class="logo" src="/img/logo.png"></a>
            <img class="afterlogo" src="/img/title2.png">
            @section("points")
            <div class="points">
                <div class="simple-point"></div>
                <div class="simple-point"></div>
                <div class="simple-point"></div>
                <div class="simple-point"></div>
                <div class="simple-point"></div>
                <div class="end-point"></div>
            </div>
            @show
        </div>
        <div class="content">
            @yield("content")
        </div>
    
        <div class="footer">
            <div class="content">
                @yield("footer")
            </div>
        </div>
    </div>
    @yield("scripts")
</body>
</html>