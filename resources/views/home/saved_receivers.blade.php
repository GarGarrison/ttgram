@extends('layouts.home_layout')

@section("scripts")
<script type="text/javascript" src="/js/saved_receivers.js"></script>
@endsection

@section("header")
<h3>Сохраненные адресаты</h3>
@endsection

@section("addition_to_menu")
<li><a class="btn-floating blue" @click="showModal=true" title="Добавить нового адресата"><i class="material-icons">add</i></a></li>
@endsection

@section('home_content')
    <modal v-if="showModal==true" @close="showModal = false">
        <h3 slot="header" v-if="!edit">Новый адресат</h3>
        <h3 slot="header" v-if="edit">Редактирование адресата</h3>
        <form slot="body" action="{{ route('save_receiver') }}" method="post" @submit="submit">
            {{ csrf_field() }}
            <input type="hidden" v-if="edit" name="current_id" v-model="current_id">
            <div class="row">
                <div class="col s12">
                    <span class="error" v-if="validate_errors['template_name']">@{{ validate_errors['template_name'] }}</span>
                    <input type="text" v-model="template_name" name="template_name" placeholder="Название шаблона">
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
        <div class="col s12">
            <list-filter :original_list='tmp_list' :filter_field="'template_name'" data-empty="Адресатов не найдено" placeholder="Фильтр по названию шаблона">
                <template slot-scope="{ row }">
                    <div class="col s6 m4">
                        <div class = "truncate list-element">
                            <span class="left">@{{ row.template_name }}</span>
                            <i class="material-icons" @click="deleteItem(row.id)" title="удалить">close</i>
                        </div>
                    </div>
                    <div class="col s6 m8">
                        <div class = "truncate list-element">
                            @{{ row.surname + " " + row.city }}
                            <i class="material-icons" @click="editItem(row.id)" title="редактировать">mode_edit</i>
                        </div>
                    </div>
                </template>
            </list-filter>
        </div>
    </div>
@endsection