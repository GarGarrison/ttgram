@extends('layouts.layout')

@section("scripts")
<script type="text/javascript">
    var app = new Vue({
        el: '#ttgram',
        data: {
            user_type: "fiz",
            x_region: "",
            x_city: "",
            x_street: ""
        }
    });
</script>
@endsection

@section('content')
<kladr-block>
    <kladr-item data-kladr-type="region" v-model="x_region" placeholder="x_region"></kladr-item>
    <kladr-item data-kladr-type="city" v-model="x_city" placeholder="x_city"></kladr-item>
    <kladr-item data-kladr-type="street" v-model="x_street" placeholder="x_street"></kladr-item>
</kladr-block>
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

