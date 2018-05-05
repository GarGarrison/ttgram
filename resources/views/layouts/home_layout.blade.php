@extends('layouts.layout')

@section('content')
    <div class="row">
        <div class="col s12">
            @yield("header")
            <div class="right-align">
                <a href="{{ route('service') }}">Заказать услугу</a>
                <a href="{{ route('templates') }}">Шаблоны телеграмм</a>
                <a href="{{ route('saved_receivers') }}">Сохраненные адресаты</a>
            </div>
        </div>
    </div>
    @yield("home_content")
@endsection