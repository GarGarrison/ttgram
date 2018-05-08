<div class="row">
    <div class="col s12 m4 radio-span">
        <input id="r-fiz" class="with-gap" type="radio" v-model="user_type" ref="user_type" name="user_type" value="fiz" data-value="{{ Auth::user() ? Auth::user()->user_type: old('user_type') }}">
        <label for="r-fiz">Физическое лицо</label>
    </div>
    <div class="col s12 m4 radio-span">
        <input id="r-jur" class="with-gap" type="radio" v-model="user_type" ref="user_type" name="user_type" value="jur" data-value="{{ Auth::user() ? Auth::user()->user_type: old('user_type') }}">
        <label for="r-jur">Юридическое лицо</label>
    </div>
</div>
<kladr-block class="row">
    {{ csrf_field() }}
    <div class="col s12 m6">
        @if ($errors->has('fio'))
        <span class="error">{{ $errors->first('fio') }}</span>
        @endif
        <input class="input-text uppercase" type="text" name="fio" ref="fio" v-model="fio"     placeholder="ФИО" data-value="{{ Auth::user() ? Auth::user()->fio: old('fio') }}"></div>
    <div class="col s12 m6" v-show="user_type=='jur'">
        @if ($errors->has('company'))
        <span class="error">{{ $errors->first('company') }}</span>
        @endif
        <input class="input-text uppercase" type="text" name="company" ref="company" v-model="company"     placeholder="Компания" data-value="{{ Auth::user() ? Auth::user()->company: old('company') }}"></div>
    <div class="col s12 m6">
        @if ($errors->has('phone'))
        <span class="error">{{ $errors->first('phone') }}</span>
        @endif
        <input class="input-text"          type="text" name="phone" ref="phone" v-model="phone"   placeholder="Телефон" data-value="{{ Auth::user() ? Auth::user()->phone: old('phone') }}"></div>
    <div class="col s12 m6">
        @if ($errors->has('email'))
        <span class="error">{{ $errors->first('email') }}</span>
        @endif
        <input class="input-text"           type="email" name="email" ref="email" v-model="email"   placeholder="E-mail" data-value="{{ Auth::user() ? Auth::user()->email: old('email') }}"></div>
    <div class="col s12 m6">
        @if ($errors->has('region'))
        <span class="error">{{ $errors->first('region') }}</span>
        @endif
        <kladr-item data-kladr-type="region" name="region" ref="region" data-ref="region" v-model="region"  placeholder="Регион" data-value="{{ Auth::user() ? Auth::user()->region: old('region') }}"></div>
    <div class="col s12 m6">
        @if ($errors->has('city'))
        <span class="error">{{ $errors->first('city') }}</span>
        @endif
        <kladr-item data-kladr-type="city" name="city" ref="city" data-ref="city" v-model="city"    placeholder="Населенный пункт" data-value="{{ Auth::user() ? Auth::user()->city: old('city') }}"></div>
    <div class="col s12 m6">
        @if ($errors->has('street'))
        <span class="error">{{ $errors->first('street') }}</span>
        @endif
        <kladr-item data-kladr-type="street" name="street" ref="street" data-ref="street" v-model="street"    placeholder="Улица" data-value="{{ Auth::user() ? Auth::user()->street: old('street') }}"></div>
    <div class="col s12 m6">
        @if ($errors->has('building'))
        <span class="error">{{ $errors->first('building') }}</span>
        @endif
        <kladr-item class="left half" kladr-type="building" name="building" ref="building" data-ref="building" v-model="building"   placeholder="Дом" data-value="{{ Auth::user() ? Auth::user()->building: old('building') }}"></kladr-item>
        <input class="input-text half right" type="text" name="flat" ref="flat" v-model="flat" placeholder="Квартира" data-value="{{ Auth::user() ? Auth::user()->flat: old('flat') }}">
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