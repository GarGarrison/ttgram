@extends('layouts.home_layout')

@section("scripts")
<script type="text/javascript" src="/js/saved_receivers.js"></script>
@endsection

@section("header")
<h3>Сохраненные адресаты</h3>
@endsection

@section('home_content')
    <modal v-if="showModal==true" @close="showModal = false">
        <h3 slot="header">Новый адресат</h3>
        <form slot="body" action="{{ route('save_receiver') }}" method="post" @submit="submit">
            {{ csrf_field() }}
            <div class="row">
                <div class="col s12">
                    <input type="text" name="template_name" placeholder="Название шаблона">
                </div>
            </div>
            
            <kladr-block class="row">
                <div class="col s12 m6">
                    <span class="error" v-if="validate_errors['surname']">@{{ validate_errors['surname'] }}</span>
                    <input class="input-text uppercase" type="text" v-model="surname"     name="surname"     placeholder="Фамилия"></div>
                <div class="col s12 m6">
                    <span class="error" v-if="validate_errors['name']">@{{ validate_errors['name'] }}</span>
                    <input class="input-text uppercase" type="text" v-model="name"     name="name"     placeholder="Имя"></div>
                <div class="col s12 m6">
                    <span class="error" v-if="validate_errors['company']">@{{ validate_errors['company'] }}</span>
                    <input class="input-text uppercase" type="text" v-model="company" name="company" placeholder="Компания"></div>
                <div class="col s12 m6">
                    <span class="error" v-if="validate_errors['phone']">@{{ validate_errors['phone'] }}</span>
                    <input class="input-text"           type="text" v-model="phone"   name="phone"   placeholder="Телефон"></div>
                <div class="col s12 m6">
                    <span class="error" v-if="validate_errors['email']">@{{ validate_errors['email'] }}</span>
                    <input class="input-text"           type="email" v-model="email"   name="email"   placeholder="E-mail"></div>
                <div class="col s12 m6">
                    <span class="error" v-if="validate_errors['region']">@{{ validate_errors['region'] }}</span>
                    <!-- <input class="input-text uppercase" type="text" v-model="region"  name="region"  placeholder="Регион"></div> -->
                    <kladr-item data-kladr-type="region" v-model="region"  name="region"  placeholder="Регион"></kladr-item></div>
                <div class="col s12 m6">
                    <span class="error" v-if="validate_errors['city']">@{{ validate_errors['city'] }}</span>
                    <!-- <input class="input-text uppercase" type="text" v-model="city"    name="city"    placeholder="Населенный пункт"></div> -->
                    <kladr-item data-kladr-type="city" v-model="city"    name="city"    placeholder="Населенный пункт"></kladr-item></div>
                <div class="col s12 m6">
                    <span class="error" v-if="validate_errors['street']">@{{ validate_errors['street'] }}</span>
                    <!-- <input class="input-text uppercase" type="text" v-model="street"  name="street"  placeholder="Улица"></div> -->
                    <kladr-item data-kladr-type="street" v-model="street"    name="street"    placeholder="Улица"></kladr-item></div>
                <div class="col s12 m6">
                    <span class="error" v-if="validate_errors['building']">@{{ validate_errors['building'] }}</span>
                    <!-- <input class="input-text uppercase half" type="text" v-model="building" name="building" placeholder="Дом"> -->
                    <kladr-item class="left half" data-kladr-type="building" v-model="building"    name="building"    placeholder="Дом"></kladr-item>
                    <input class="input-text half right" type="text"  v-model="flat" name="flat" placeholder="Квартира">
                </div>
            </kladr-block>
            <div class="row">
                <div class="col s12 m6">
                    <button class="button">
                        <span class="button-title">Сохранить</span>
                        <img src="/img/button.png">
                    </button>
                </div>
            </div>
        </form>
    </modal>
    <div class="row">
        <a class="btn-floating btn-medium waves-effect waves-light right add" @click="showModal=true" title="Добавить нового адресата"><i class="material-icons">add</i></a>
        <div class="col s12">
            <receivers-list-filter data-list-name="tmp_list" placeholder="Поиск по названию" data-empty="Адресатов не найдено"></receivers-list-filter>
        </div>
    </div>
@endsection