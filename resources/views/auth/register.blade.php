@extends('layouts.layout')

@section("scripts")
<script type="text/javascript">
    var app = new Vue({
        el: '#ttgram',
        data: {
            user_type: "fiz",
            fio : "",
            company : "",
            phone : "",
            email : "",
            region : "",
            city : "",
            street : "",
            building : "",
            flat : ""
        },
        mixins: [mount_mixin]
    });
</script>
@endsection

@section('content')
<form action="{{ route('register') }}" method="post">
    <div class="row">
        <div class="col s12">
            <h3>Регистрация</h3>
        </div>
    </div>
    @include("templates.user")
    <div class="row">
        <div class="col s12 m6">
            <button class="button">
                <span class="button-title">Регистрация</span>
                <img src="/img/button.png">
            </button>
        </div>
    </div>
</form>
@endsection

