@extends('layouts.home_layout')

@section("scripts")
<script type="text/javascript" src="/dist/profile.js"></script>
@endsection

@section("header")
<h3>Личный кабинет</h3>
@endsection

@section('home_content')
    <form method="post">
        @include("templates.user")
        <div class="row">
            <div class="col s12 m6">
                <button class="button">
                    <span class="button-title">Сохранить</span>
                    <img src="/img/button.png">
                </button>
            </div>
        </div>
    </form>
@endsection