@extends('layouts.layout')

@section("scripts")
<script type="text/javascript" src="/dist/service.js"></script>
@endsection

@section("points")
<div class="points">
    <div class="point" @click="changeStep" :class="{'active': (step==1)}" data-step = "1" title="Данные отправителя"></div>
    <div class="point" @click="changeStep" :class="{'active': (step==2)}" data-step = "2" title="Вид услуги"></div>
    <div class="point" @click="changeStep" :class="{'active': (step==3)}" data-step = "3" title="Данные получателя"></div>
    <div class="point" @click="changeStep" :class="{'active': (step==4)}" data-step = "4" title="Текст телеграммы"></div>
    <div class="point" @click="changeStep" :class="{'active': (step==5)}" data-step = "5" title="Подтверждение"></div>
    <div class="end-point"></div>
</div>
@endsection


@section("content")
<modal v-if="showModal==true && telegramStep" @close="showModal=false">
    <h3 slot="header">Новый шаблон</h3>
    <form slot="body" action="{{ route('save_receiver') }}" ref="reciever_form" @submit.prevent="submit_receiver">
        {{ csrf_field() }}
        <div class="col s12">
            <span class="error" v-if="validate_errors['template_name']">@{{ validate_errors['template_name'] }}</span>
            <input type="text" v-model="template_name" name="template_name" placeholder="Название шаблона">
        </div>
        <div class="col s12 m6">
            <button class="button">
                <span class="button-title">Сохранить</span>
                <img src="/img/button.png">
            </button>
        </div>
    </form>
</modal>
<modal v-if="showModal==true && step==1" @close="showModal=false">
    <h3 slot="header">Регистрация</h3>
    <form slot="body" action="{{ route('register') }}" ref="register_form" @submit.prevent="submit_register">
        {{ csrf_field() }}
        <div class="col s12">
            <span class="error" v-if="validate_errors['email']">@{{ validate_errors['email'] }}</span>
            <input type="text" v-model="telegram_data.s_email" placeholder="E-mail">
        </div>
        <div class="col s12">
            <span class="error" v-if="validate_errors['password']">@{{ validate_errors['password'] }}</span>
            <input type="password" v-model="password" placeholder="Пароль">
        </div>
        <div class="col s12">
            <span class="error" v-if="validate_errors['password_confirmation']">@{{ validate_errors['password_confirmation'] }}</span>
            <input type="password" v-model="confirm_password" placeholder="Подтверждение">
        </div>
        <div class="col s12 m6">
            <button class="button">
                <span class="button-title">Сохранить</span>
                <img src="/img/button.png">
            </button>
        </div>
    </form>
</modal>
<div class="row step-container">
    <transition name="steps" mode="out-in">
    <form v-if="step==1" @submit.prevent="submit" key="1">
        <div class="col s12 content-head">
            <div class="col s12 m4">
                <h3>Отправитель</h3>
            </div>
            @if( Auth::guest() )
            <div class="col s12 m4 radio-span">
                <input id="r-fiz" class="with-gap" type="radio" v-model="telegram_data.s_type" value="fiz">
                <label for="r-fiz">Физическое лицо</label>
            </div>
            <div class="col s12 m4 radio-span">
                <input id="r-jur" class="with-gap" type="radio" v-model="telegram_data.s_type" value="jur">
                <label for="r-jur">Юридическое лицо</label>
            </div>
            @endif
        </div>
        <div class="col s12 content-body">
            <div class="row">
                <div class="col s12 m6">
                    <span class="error" v-if="validate_errors['notification']">@{{ validate_errors['notification'] }}</span>
                    <select class="browser-default c-select" name="notification" v-model="telegram_data.notification">
                        <option value="">Способ уведомления о статусе доставки телеграммы</option>
                        <option value="phone">По телефону</option>
                        <option value="address">По адресу</option>
                        <option value="email">По email</option>
                        <option value="no">Без уведомления</option>
                    </select>
                </div>
                <kladr-block id="sender">
                    <div class="col s12 m6">
                        <span class="error" v-show="validate_errors['s_company']">@{{ validate_errors['s_company'] }}</span>
                        <input class="input-text uppercase" type="text" v-model="telegram_data.s_company" id="s_company" placeholder="Компания" v-show="telegram_data.s_type=='jur'" value="{{ Auth::user() ? Auth::user()->company : '' }}"></div>
                    <div class="col s12 m6">
                        <span class="error" v-show="validate_errors['s_fio']">@{{ validate_errors['s_fio'] }}</span>
                        <input class="input-text uppercase" type="text" v-model="telegram_data.s_fio" id="s_fio" placeholder="ФИО"  value="{{ Auth::user() ? Auth::user()->fio : '' }}"></div>
                    <div class="col s12 m6">
                        <span class="error" v-show="validate_errors['s_phone']">@{{ validate_errors['s_phone'] }}</span>
                        <masked-input id="s_phone" v-model="telegram_data.s_phone" mask="\+\7 (111) 111-11-11" placeholder="Телефон" value="{{ Auth::user() ? Auth::user()->phone : '' }}"></masked-input>
                    </div>
                    <div class="col s12 m6">
                        <span class="error" v-show="validate_errors['s_email']">@{{ validate_errors['s_email'] }}</span>
                        <input class="input-text"           type="email" v-model="telegram_data.s_email" id="s_email" placeholder="E-mail" value="{{ Auth::user() ? Auth::user()->email : '' }}"></div>
                    <div class="col s12 m6">
                        <span class="error" v-show="validate_errors['s_region'] && telegram_data.notification=='address'">@{{ validate_errors['s_region'] }}</span>
                        <kladr-item data-kladr-type="region" v-model="telegram_data.s_region" id="s_region" placeholder="Регион" v-show="telegram_data.notification=='address'" value="{{ Auth::user() ? Auth::user()->region : '' }}"></kladr-item></div>
                    <div class="col s12 m6">
                        <span class="error" v-show="validate_errors['s_city'] && telegram_data.notification=='address'">@{{ validate_errors['s_city'] }}</span>
                        <kladr-item data-kladr-type="city" v-model="telegram_data.s_city"  id="s_city" placeholder="Населенный пункт" v-show="telegram_data.notification=='address'" value="{{ Auth::user() ? Auth::user()->city : '' }}"></kladr-item></div>
                    <div class="col s12 m6">
                        <span class="error" v-show="validate_errors['s_street'] && telegram_data.notification=='address'">@{{ validate_errors['s_street'] }}</span>
                        <kladr-item data-kladr-type="street" v-model="telegram_data.s_street" id="s_street" placeholder="Улица" v-show="telegram_data.notification=='address'" value="{{ Auth::user() ? Auth::user()->street : '' }}"></kladr-item></div>
                    <div class="col s12 m6" v-show="telegram_data.notification=='address'">
                        <span class="error" v-show="validate_errors['s_building'] && telegram_data.notification=='address'">@{{ validate_errors['s_building'] }}</span>
                        <kladr-item class="left half" data-kladr-type="building" v-model="telegram_data.s_building"  id="s_building" placeholder="Дом" value="{{ Auth::user() ? Auth::user()->building : '' }}"></kladr-item>
                        
                        <input class="input-text half right" type="text" v-model="telegram_data.s_flat" id="s_flat" placeholder="Квартира" value="{{ Auth::user() ? Auth::user()->flat : '' }}">
                    </div>
                </kladr-block>
            </div>
            <div class="row">
                <div class="col s12 m6">
                    @if(Auth::guest())
                    <div class="switch right">
                        <label>
                          <input type="checkbox" id="registration" v-model="save_myself">
                          Зарегистрироваться используя эти данные
                          <span class="lever"></span>
                        </label>
                    </div>
                    @endif
                </div>
                <div class="col s12 m6">
                    <button class="button">
                        <span class="button-title">Далее</span>
                        <img src="/img/button.png">
                    </button>
                </div>
            </div>
        </div>
    </form>
    <form v-if="step==2" @submit.prevent="submit" key="2">
        <div class="col s12 content-head">
            <h3>Вид услуги</h3>
        </div>
        <div class="col s12 content-body">
            <div class="col s12 radio-span">
                <input id="r1" class="with-gap" type="radio" name="service_type" v-model="telegram_data.service_type" value="telegram">
                <label for="r1">Телеграмма</label>
            </div>
            <div class="col s12 radio-span">
                <input id="r2" class="with-gap" type="radio" name="service_type" v-model="telegram_data.service_type" value="international">
                <label for="r2">Международная телеграмма</label>
            </div>
            <div class="col s12 radio-span">
                <input id="r3" class="with-gap" type="radio" name="service_type" v-model="telegram_data.service_type" value="copy_in">
                <label for="r3">Копия входящей телеграммы</label>
            </div>
            <div class="col s12 radio-span">
                <input id="r4" class="with-gap" type="radio" name="service_type" v-model="telegram_data.service_type" value="copy_out">
                <label for="r4">Копия исходящей телеграммы</label>
            </div>
            <div class="col s12 m6">
                <button class="button">
                    <span class="button-title">Далее</span>
                    <img src="/img/button.png">
                </button>
            </div>
        </div>
    </form>
    <form v-if="telegramStep" @submit.prevent="submit" key="3">
        <div class="col s12 content-head">
            <h3>Данные получателя телеграммы</h3>
        </div>
        <div class="col s12 content-body">
            <div class="row">
                <div class="col s12 m6">
                    @if(!empty($receivers) && !$receivers->isEmpty())
                    <select class="browser-default c-select" name="saved_receiver" v-model="saved_receiver" @change="chooseReceiver">
                        <option value="">Выбрать адресата из списка</option>
                        @foreach( $receivers as $r)
                        <option value="{{ $r->id }}">{{ $r->template_name }}</option>
                        @endforeach
                    </select>
                    @endif
                </div>
            </div>
            <kladr-block class="row" id="receiver">
                <div class="col s12 m6">
                    <span class="error" v-if="validate_errors['r_surname']">@{{ validate_errors['r_surname'] }}</span>
                    <input class="input-text uppercase" type="text" v-model="telegram_data.r_surname" placeholder="Фамилия"></div>
                <div class="col s12 m6">
                    <span class="error" v-if="validate_errors['r_name']">@{{ validate_errors['r_name'] }}</span>
                    <input class="input-text uppercase" type="text" v-model="telegram_data.r_name" placeholder="Имя"></div>
                <div class="col s12 m6">
                    <span class="error" v-if="validate_errors['r_company']">@{{ validate_errors['r_company'] }}</span>
                    <input class="input-text uppercase" type="text" v-model="telegram_data.r_company" placeholder="Компания"></div>
                <div class="col s12 m6">
                    <span class="error" v-if="validate_errors['r_phone']">@{{ validate_errors['r_phone'] }}</span>
                    <masked-input id="r_phone" v-model="telegram_data.r_phone" mask="\+\7 (111) 111-11-11" placeholder="Телефон"></masked-input></div>
                <div class="col s12 m6">
                    <span class="error" v-if="validate_errors['r_email']">@{{ validate_errors['r_email'] }}</span>
                    <input class="input-text"           type="email" v-model="telegram_data.r_email" placeholder="E-mail"></div>
                <div class="col s12 m6">
                    <span class="error" v-if="validate_errors['r_region']">@{{ validate_errors['r_region'] }}</span>
                    <kladr-item data-kladr-type="region" v-model="telegram_data.r_region" placeholder="Регион"></kladr-item></div>
                <div class="col s12 m6">
                    <span class="error" v-if="validate_errors['r_city']">@{{ validate_errors['r_city'] }}</span>
                    <kladr-item data-kladr-type="city" v-model="telegram_data.r_city" placeholder="Населенный пункт"></kladr-item></div>
                <div class="col s12 m6">
                    <span class="error" v-if="validate_errors['r_street']">@{{ validate_errors['r_street'] }}</span>
                    <kladr-item data-kladr-type="street" v-model="telegram_data.r_street" placeholder="Улица"></kladr-item></div>
                <div class="col s12 m6">
                    <span class="error" v-if="validate_errors['r_building']">@{{ validate_errors['r_building'] }}</span>
                    <kladr-item class="left half" data-kladr-type="building" v-model="telegram_data.r_building" placeholder="Дом"></kladr-item>
                    <input class="input-text half right" type="text"  v-model="telegram_data.r_flat" placeholder="Квартира">
                </div>
            </kladr-block>
            <div class="row">
                <div class="col s12 m6">
                    <div class="switch right">
                        <label>
                          <input type="checkbox" id="save_receiver" v-model="save_receiver">
                          Сохранить данные адресата
                          <span class="lever"></span>
                        </label>
                    </div>
                </div>
                <div class="col s12 m6">
                    <button class="button">
                        <span class="button-title">Далее</span>
                        <img src="/img/button.png">
                    </button>
                </div>
            </div>
        </div>
    </form>
    <form class="step" v-if="copyStep" @submit.prevent="submit_finally" key="4">
        <div class="col s12 content-head">
            <h3>Параметры копии телеграммы</h3>
        </div>
        <div class="col s12 content-body">
            <div class="row">
                <div class="col s12">
                    <div class="col s12 m6">
                        <span class="error" v-if="validate_errors['copy_date']">@{{ validate_errors['copy_date'] }}</span>
                        <vuejs-datepicker v-model="picker_copy_date" placeholder="Дата" format="yyyy-MM-dd" :language="lang"></vuejs-datepicker>
                    </div>
                </div>
                <div class="col s12">
                    <div class="col s12 m6">
                        <span class="error" v-if="validate_errors['copy_number']">@{{ validate_errors['copy_number'] }}</span>
                        <input class="input-text" type="text" v-model="telegram_data.copy_number" placeholder="Кассовый номер"></div>
                </div>
                <div class="col s12">
                    <div class="col s12 m6">
                        <select class="browser-default c-select" v-model="telegram_data.service_type">
                            <option value="copy_in">Входящая</option>
                            <option value="copy_out">Исходящая</option>
                        </select>
                    </div>
                </div>
                <div class="col s12">
                    <div class="col s12 m6">
                        <span class="error" v-if="validate_errors['payment_type']">@{{ validate_errors['payment_type'] }}</span>
                        <select class="browser-default c-select" v-model="telegram_data.payment_type">
                            <option value="">Способ оплаты</option>
                            <option value="beznal">Безналичный</option>
                            <option value="nal">Наличный</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6">
                    <button class="button">
                        <span class="button-title">Далее</span>
                        <img src="/img/button.png">
                    </button>
                </div>
            </div>
        </div>
    </form>
    <form class="step" v-if="step==4" @submit.prevent="submit_finally" key="5">
        <div class="col s12 content-head">
            <h3>Текст телеграммы</h3>
        </div>
        <div class="col s12 content-body">
            <div class="row">
                @if(!empty($templates) && !$templates->isEmpty())
                <div class="col s6">
                    <select class="browser-default c-select" v-model="saved_template" @change="chooseTemplate">
                        <option value="">Выбрать шаблон телеграммы</option>
                        @foreach( $templates as $t)
                        <option value="{{ $t->id }}">{{ $t->template_name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>
            
            <div class="row">
                <div class="col s12">
                    <a class="insert-from-file">
                        Вставить из файла (*.txt)
                        <input type="file" @change="processFile($event)">
                    </a>
                    <div class="hint">Чтобы вставить текст из буфера, нажмите Ctrl + V</div>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <span class="error" v-if="validate_errors['text']">@{{ validate_errors['text'] }}</span>
                    <tlg-textarea v-model="telegram_data.text" placeholder="Текст телеграммы" data-txt-style="message" data-wc-style="word-count"></tlg-textarea>
                </div>
                <div class="switch right">
                    <label>
                      Включить телеграфные сокращения
                      <input type="checkbox" v-model="telegraf_abbr" @change="telegraf_abbr_replace">
                      <span class="lever"></span>
                    </label>
                </div> 
            </div>
            <div class="row">
                <div class="col s12 m6">
                    <span class="error" v-if="validate_errors['payment_type']">@{{ validate_errors['payment_type'] }}</span>
                    <select class="browser-default c-select" v-model="telegram_data.payment_type">
                        <option value="">Способ оплаты</option>
                        <option value="beznal">Безналичный</option>
                        <option value="nal">Наличный</option>
                    </select>
                </div>
                <div class="col s12 m6">
                    <select class="browser-default c-select" v-model="telegram_data.blank">
                        <option value="">Бланк</option>
                        <option value="люкс">Художественный </option>
                        <option value="люкс/в">Художественный формата А4</option>
                        <option value="люкс/и">Детский</option>
                        <option value="люкс/м">Музыкальный</option>
                        <option value="люкс/м/и">Детский музыкальный</option>
                        <option value="делюкс">Траурный</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6">
                    <span class="error" v-if="validate_errors['notification_quick']">@{{ validate_errors['notification_quick'] }}</span>
                    <select class="browser-default c-select" v-model="telegram_data.notification_quick">
                        <option value="">Уведомление о доставке</option>
                        <option value="0">Обыкновенное</option>
                        <option value="1">Срочное</option>
                    </select>
                </div>
                <div class="col s12 m6">
                    <div class="col s2">
                        <div class="valign-text">Вручить</div>
                    </div>
                    <div class="col s10">
                        <vuejs-datepicker v-model="picker_delivery_date" placeholder="Дата" format="yyyy-MM-dd" :language="lang"></vuejs-datepicker>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6">
                    <div class="switch right">
                        <label>
                          До востребования
                          <input type="checkbox" v-model="telegram_data.restante">
                          <span class="lever"></span>
                        </label>
                    </div> 
                </div>
                <div class="col s12 m6">
                    <button class="button">
                        <span class="button-title">Получить код заказанной услуги</span>
                        <img src="/img/button.png">
                    </button>
                </div>
            </div>                      
        </div>
    </form>
    <form class="step" v-if="step==5" @submit.prevent key="6">
        <div class="col s12 m6">
            <h2>Услуга подтверждена</h2>
            <p class="bigp">Для оплаты услуги вы можете обратиться в <a class="showinfo" href="{{ route('info') }}" target="_blank">любое отделение связи Московского филиала ПАО «Ростелеком»</a>.</p>
        </div>
        <div class="col s12 m6">
            <div class="code-wrapper">
                <span class="code-title">Код вашей услуги:</span>
                <div class="code">@{{ request_number }}</div>
            </div>
        </div>
    </form>
    </transition>
</div>
@endsection

@section("footer")
<div class="step-description" v-show="step==1">
    <h4>Шаг 1. Регистрация лица, желающего получить услугу.</h4>
    <p>Регистрация является необязательной для получения услуги. Она необходима для упрощения получения услуг повторно.</p>
    <p>Для регистрации необходимо заполнить поля, представленные в окне регистрации.</p>
</div>
<div class="step-description" v-show="step==2">
    <h4>Шаг 2. Выбор услуги.</h4>
    <p>Необходимо указать вид услуги, которую Вы желаете получить.</p>
</div>
<div class="step-description" v-show="step==3">
    <h4>Шаг 3. Ввод данных адресата (получателя) телеграммы.</h4>
    <p>Для завершения данного шага, необходимо последовательно заполнить поля, представленные в окне.</p>
</div>
<div class="step-description" v-show="step==4">
    <h4>Шаг 4. Ввод текста телеграммы.</h4>
    <p>Вам необходимо ввести текст телеграммы (или вставить текст, ранее скопированный в буфер) в соответствующее поле. После ввода текста необходимо получить код заказанной услуги.</p>
</div>
<div class="step-description" v-show="step==5">
    <h4>Шаг 5. Подтверждение и оплата услуги.</h4>
    <p>Для оплаты услуги вы можете обратиться в любое отделение связи Московского филиала ПАО «Ростелеком».</p>
</div>
@endsection