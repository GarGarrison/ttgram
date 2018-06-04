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
                    <tr>
                        <th class="list-element">
                            <input type="text" placeholder="Фильтр по номеру" v-model="inputList.fields.id">
                        </th>
                        <th class="list-element">
                            <input type="text" placeholder="Фильтр по дате" v-model="inputList.fields.created_at">
                        </th>
                        <th class="list-element">
                            <input type="text" placeholder="Фильтр услуге" v-model="inputList.fields.service_type">
                        </th>
                        <th class="list-element">
                            <input type="text" placeholder="Фильтр по статусу" v-model="inputList.fields.status">
                        </th>
                    </tr>
                </template>
                <template slot-scope="{ row }">
                    <td>@{{ row.id }}</td>
                    <td>@{{ row.created_at }}</td>
                    <td>@{{ row.service_type }}</td>
                    <td>@{{ row.status }}</td>
                </template>
            </list-filter>
        </div>
    </div>
@endsection