@extends('layouts.home_layout')

@section("scripts")
<script type="text/javascript" src="/js/templates.js"></script>
@endsection

@section("header")
<h3>Шаблоны телеграмм</h3>
@endsection

@section("addition_to_menu")
<li><a class="btn-floating blue" @click="showModal=true" title="Добавить новый шаблон"><i class="material-icons">add</i></a></li>
@endsection

@section('home_content')
    <modal v-if="showModal==true" @close="showModal = false">
        <h3 slot="header" v-if="!edit">Новый шаблон</h3>
        <h3 slot="header" v-if="edit">Редактирование шаблона</h3>
        <form slot="body" action="{{ route('save_template') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" v-if="edit" name="current_id" v-model="current_id">
            <div class="col s12">
                <input type="text" v-model="name" name="name" placeholder="Название шаблона">
            </div>
            <div class="col s12">
                <tlg-textarea v-model="template" name="template" placeholder="Шаблон" data-txt-style="message" data-wc-style="word-count"></tlg-textarea>
            </div>
            <div class="col s12 m6">
                <button class="button">
                    <span class="button-title">Сохранить</span>
                    <img src="/img/button.png">
                </button>
            </div>
        </form>
    </modal>
    <div class="row">
        <div class="col s12">
            <template-list-filter data-list-name="tmp_list" placeholder="Поиск по названию" data-empty="Шаблонов не найдено"></template-list-filter>
        </div>
    </div>
@endsection