@extends('layouts.home_layout')

@section("scripts")
<script type="text/javascript" src="/js/history.js"></script>
@endsection

@section("header")
<h3>История услуг</h3>
@endsection

@section('home_content')
    <div class="row">
        <div class="col s12">
            <list-filter :original_list='history_list' :filter_field="[]" data-empty="Услуг не найдено">
                <template slot="inputs" slot-scope="inputList">
                    <div class="col s4">
                        <input type="text" placeholder="Фильтр по дате" v-model="inputList.fields.created_at">
                    </div>
                    <div class="col s4">
                        <input type="text" placeholder="Фильтр услуге" v-model="inputList.fields.service_type">
                    </div>
                    <div class="col s4">
                        <input type="text" placeholder="Фильтр по статусу" v-model="inputList.fields.status">
                    </div>
                </template>
                <template slot-scope="{ row }">
                    <div class="col s4">
                        <div class = "truncate list-element">
                            @{{ row.created_at }}
                        </div>
                    </div>
                    <div class="col s4">
                        <div class = "truncate list-element">
                            @{{ row.service_type }}
                        </div>
                    </div>
                    <div class="col s4">
                        <div class = "truncate list-element">
                            @{{ row.status }}
                        </div>
                    </div>
                </template>
            </list-filter>
        </div>
    </div>
@endsection