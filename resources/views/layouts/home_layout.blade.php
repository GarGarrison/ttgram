@extends('layouts.layout')

@section('content')
    <div class="row">
        <div class="col s12">
            @yield("header")
            <div class="right-align">
                <menu-button data-button-class="menu-button">
                    @yield("addition_to_menu")
                    <li><a href="{{ route('service') }}" class="btn-floating blue" title="Заказать услугу"><i class="material-icons">work</i></a></li>
                    <li><a href="{{ route('history') }}" class="btn-floating blue" title="История услуг"><i class="material-icons">history</i></a></li>
                    <li><a href="{{ route('saved_receivers') }}" class="btn-floating blue" title="Сохраненные адресаты"><i class="material-icons">people</i></a></li>
                    <li><a href="{{ route('templates') }}" class="btn-floating blue" title="Шаблоны телеграмм"><i class="material-icons">chat</i></a></li>
                </menu-button>
            </div>
        </div>
    </div>
    @yield("home_content")
@endsection