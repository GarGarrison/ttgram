@extends('layouts.home_layout')

@section("scripts")
<script type="text/javascript" src="/js/templates.js"></script>
@endsection

@section("header")
<h3>Шаблоны телеграмм</h3>
@endsection

@section('home_content')
    <modal v-if="showModal==true" @close="showModal = false">
        <h3 slot="header">Новый шаблон</h3>
        <form slot="body" action="{{ route('save_template') }}" method="post">
            {{ csrf_field() }}
            <div class="col s12">
                <input type="text" name="name" placeholder="Название шаблона">
            </div>
            <div class="col s12">
                <tlg-textarea name="tmp" placeholder="Шаблон" data-txt-style="message" data-wc-style="word-count"></tlg-textarea>
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
        <a class="btn-floating btn-medium waves-effect waves-light right add" @click="showModal=true" title="Добавить новый шаблон"><i class="material-icons">add</i></a>
        <div class="col s12">
            <template-list-filter data-list-name="tmp_list" placeholder="Поиск по названию" data-empty="Шаблонов не найдено"></template-list-filter>
        </div>
    </div>
@endsection