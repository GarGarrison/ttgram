@extends('layouts.home_layout')

@section("scripts")
<script type="text/javascript" src="/dist/templates.js"></script>
@endsection

@section("header")
<h3>Шаблоны телеграмм</h3>
@endsection

@section("addition_to_menu")
<a class="btn-floating menu-button" @click="showModal=true" title="Добавить новый шаблон"><i class="material-icons">add</i></a>
@endsection

@section('home_content')
    <modal v-if="showModal==true" @close="showModal = false">
        <h3 slot="header" v-if="!edit">Новый шаблон</h3>
        <h3 slot="header" v-if="edit">Редактирование шаблона</h3>
        <form slot="body" action="{{ route('save_template') }}" method="post" @submit="submit">
            {{ csrf_field() }}
            <input type="hidden" v-if="edit" name="current_id" v-model="current_id">
            <div class="col s12">
                <span class="error" v-if="validate_errors['template_name']">@{{ validate_errors['template_name'] }}</span>
                <input type="text" v-model="template_name" name="template_name" placeholder="Название шаблона">
            </div>
            <div class="col s12">
                <span class="error" v-if="validate_errors['template']">@{{ validate_errors['template'] }}</span>
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
            <list-filter :original_list='tmp_list' :filter_field="'template_name'" data-empty="Шаблонов не найдено" placeholder="Фильтр по названию шаблона">
                <template slot-scope="{ row }">
                    <td style="width: 30%">
                        <span class="left">@{{ row.template_name }}</span>
                        <i class="material-icons" @click="deleteItem(row.id)" title="удалить">close</i>
                    </td>
                    <td style="width: 70%">
                        @{{ row.template }}
                        <i class="material-icons" @click="editItem(row.id)" title="редактировать">mode_edit</i>
                    </td>
                </template>
            </list-filter>
        </div>
    </div>
@endsection