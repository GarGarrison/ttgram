@extends('layouts.layout')

@section('content')
<form action="{{ route('login') }}" method="post">
    <div class="row">
        <div class="col s12">
            <h3>Авторизация</h3>
            <a class="right" href="{{ route('register') }}">Регистрация</a>
        </div>
    </div>
    <div class="row">
        {{ csrf_field() }}
        <div class="col s12 m6">
            @if ($errors->has('email'))
            <span class="error">{{ $errors->first('email') }}</span>
            @endif
            <input class="input-text" type="email" name="email"   placeholder="E-mail" value="{{ old('email') }}">
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6">
            @if ($errors->has('password'))
            <span class="error">{{ $errors->first('password') }}</span>
            @endif
            <input class="input-text" type="password" name="password"   placeholder="Пароль">
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6">
            <button class="button">
                <span class="button-title">Вход</span>
                <img src="/img/button.png">
            </button>
        </div>
    </div>
</form>
@endsection
