<div class="row">
    <div class="col s12 m4 radio-span">
        <input id="user_type" type="hidden" value="{{ Auth::user() ? Auth::user()->user_type: old('user_type') }}">
        <input id="r-fiz" class="with-gap" type="radio" v-model="user_type" name="user_type" value="fiz">
        <label for="r-fiz">Физическое лицо</label>
    </div>
    <div class="col s12 m4 radio-span">
        <input id="r-jur" class="with-gap" type="radio" v-model="user_type" name="user_type" value="jur">
        <label for="r-jur">Юридическое лицо</label>
    </div>
</div>
<kladr-block class="row">
    {{ csrf_field() }}
    <div class="col s12 m6">
        @if ($errors->has('fio'))
        <span class="error">{{ $errors->first('fio') }}</span>
        @endif
        <input class="input-text uppercase" type="text" id="fio" name="fio" v-model="fio" placeholder="ФИО" value="{{ Auth::user() ? Auth::user()->fio: old('fio') }}"></div>
    <div class="col s12 m6" v-show="user_type=='jur'">
        @if ($errors->has('company'))
        <span class="error">{{ $errors->first('company') }}</span>
        @endif
        <input class="input-text uppercase" type="text" id="company" name="company" v-model="company" placeholder="Компания" value="{{ Auth::user() ? Auth::user()->company: old('company') }}"></div>
    <div class="col s12 m6" v-show="user_type=='jur'">
        @if ($errors->has('inn'))
        <span class="error">{{ $errors->first('inn') }}</span>
        @endif
        <input class="input-text uppercase" type="text" id="inn" name="inn" v-model="inn"     placeholder="ИНН" value="{{ Auth::user() ? Auth::user()->inn: old('inn') }}"></div>
    <div class="col s12 m6" v-show="user_type=='jur'">
        @if ($errors->has('kpp'))
        <span class="error">{{ $errors->first('kpp') }}</span>
        @endif
        <input class="input-text uppercase" type="text" id="kpp" name="kpp" v-model="kpp"     placeholder="КПП" value="{{ Auth::user() ? Auth::user()->kpp: old('kpp') }}"></div>
    <div class="col s12 m6">
        @if ($errors->has('phone'))
        <span class="error">{{ $errors->first('phone') }}</span>
        @endif
        <masked-input id="phone" name="phone" v-model="phone" mask="\+\7 (111) 111-11-11" placeholder="Телефон" value="{{ Auth::user() ? Auth::user()->phone: old('phone') }}"></masked-input></div>
    <div class="col s12 m6">
        @if ($errors->has('email'))
        <span class="error">{{ $errors->first('email') }}</span>
        @endif
        <input class="input-text"           type="email" name="email" id="email" v-model="email"   placeholder="E-mail" value="{{ Auth::user() ? Auth::user()->email: old('email') }}"></div>
    <div class="col s12 m6">
        @if ($errors->has('country'))
        <span class="error">{{ $errors->first('country') }}</span>
        @endif
        <input class="input-text uppercase" type="text" name="country" id="country" v-model="country"     placeholder="Страна" value="{{ Auth::user() ? Auth::user()->country: old('country') }}"></div>
    <div class="col s12 m6">
        @if ($errors->has('region'))
        <span class="error">{{ $errors->first('region') }}</span>
        @endif
        <kladr-item data-kladr-type="region" name="region" id="region" v-model="region"  placeholder="Регион" value="{{ Auth::user() ? Auth::user()->region: old('region') }}"></div>
    <div class="col s12 m6">
        @if ($errors->has('city'))
        <span class="error">{{ $errors->first('city') }}</span>
        @endif
        <kladr-item data-kladr-type="city" name="city" id="city" v-model="city"    placeholder="Населенный пункт" value="{{ Auth::user() ? Auth::user()->city: old('city') }}"></div>
    <div class="col s12 m6">
        @if ($errors->has('street'))
        <span class="error">{{ $errors->first('street') }}</span>
        @endif
        <kladr-item data-kladr-type="street" name="street" id="street" v-model="street"    placeholder="Улица" value="{{ Auth::user() ? Auth::user()->street: old('street') }}"></div>
    <div class="col s12 m6">
        @if ($errors->has('building'))
        <span class="error">{{ $errors->first('building') }}</span>
        @endif
        <kladr-item class="left half" kladr-type="building" name="building" id="building" v-model="building"   placeholder="Дом" value="{{ Auth::user() ? Auth::user()->building: old('building') }}"></kladr-item>
        <input class="input-text half right" type="text" name="flat" id="flat" v-model="flat" placeholder="Квартира" value="{{ Auth::user() ? Auth::user()->flat: old('flat') }}">
    </div>
</kladr-block>
<div class="row">
    <div class="col s12 m6">
        @if ($errors->has('password'))
        <span class="error">{{ $errors->first('password') }}</span>
        @endif
        <input class="input-text" type="password" name="password"     placeholder="Пароль"></div>
    <div class="col s12 m6">
        @if ($errors->has('confirm_password'))
        <span class="error">{{ $errors->first('confirm_password') }}</span>
        @endif
        <input class="input-text" type="password" name="password_confirmation"     placeholder="Подтверждение пароля"></div>
</div>