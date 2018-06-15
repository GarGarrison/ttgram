import Vue from 'vue'
import axios from 'axios'
import vuejsDatepicker from 'vuejs-datepicker'
import MaskedInput from 'vue-masked-input'

import Modal from './components/Modal.vue'
import TlgTextarea from './components/TlgTextarea.vue'
import Validator from './validation.js'
import KladrItem from './components/kladr/KladrItem.vue'
import KladrBlock from './components/kladr/KladrBlock.vue'
import kladr_mixin from './components/kladr/KladrMixin.js'

var RU = {
    language: 'Russian',
    months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
    monthsAbbr: ['Янв', 'Февр', 'Март', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сент', 'Окт', 'Нояб', 'Дек'],
    days: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
    rtl: false,
    ymd: false,
    yearSuffix: ''
};

var tlg_abbrs = {
    ",": " зпт ",
    ".": " тчк ",
    "'": " квч ",
    '"': " квч ",
    "(": " скб ",
    ")": " скб ",
    "!": " восклицательный знак ",
    "?": " знак вопроса ",
    "%": " процент ",
    "-": " минус "
}

var ttgram = new Vue({
            el: '#ttgram',
            data: {
                step:1,
                last_step:5,
                lang: RU,                       // язык для пикера
                saved_receiver: "",             // id выбранного адресата
                saved_template: "",             // id выбранного шаблона телеграммы
                picker_copy_date: "",           // дата копии телеграммы из пикера (типа Date)
                picker_delivery_date: "",       // дата уведомления о доставке из пикера (типа Date)
                save_myself: false,             // свич использовать данные для регистрации
                password: "",                   // пароль для регистрации
                confirm_password: "",           // подтверждение пароля
                save_receiver: false,           // свич сохранить адресата
                template_name: "",              // название шаблона для адресата
                telegraf_abbr: false,           // включить телеграфные сокращения
                telegram_data: {
                    s_type: "fiz",
                    s_fio: document.getElementById('s_fio').getAttribute('value'),
                    r_name: "",
                    r_surname: "",
                    s_company: document.getElementById('s_company').getAttribute('value'),
                    r_company: "",
                    s_phone: document.getElementById('s_phone').getAttribute('value'),
                    r_phone: "",
                    s_email: document.getElementById('s_email').getAttribute('value'),
                    r_email: "",
                    s_region: document.getElementById('s_region').getAttribute('value'),
                    r_region: "",
                    s_city: document.getElementById('s_city').getAttribute('value'),
                    r_city: "",
                    s_street: document.getElementById('s_street').getAttribute('value'),
                    r_street: "",
                    s_building: document.getElementById('s_building').getAttribute('value'),
                    r_building: "",
                    s_flat: document.getElementById('s_flat').getAttribute('value'),
                    r_flat: "",
                    notification: "",
                    notification_quick: "",
                    service_type: "telegram",
                    payment_type: "",
                    text: "",
                    word_count: 0,
                    copy_date: "",
                    copy_number: "",
                    delivery_date: "",
                    restante: false,
                    blank: ""
                },
                request_number: "",
                showModal: false,
                validate_errors: {}
            },
            mixins: [kladr_mixin],
            watch: {
                picker_copy_date: function(v) {
                    this.telegram_data.copy_date = this.process_date(v)
                },
                picker_delivery_date: function(v) {
                    this.telegram_data.delivery_date = this.process_date(v)
                },
                "telegram_data.text": function(){
                    if (this.telegraf_abbr) this.telegraf_abbr_replace();
                }
            },
            methods: {
                next: function(){
                    this.step++;
                },
                changeStep: function(event){
                    var current_step = this.step;
                    var new_step = event.target.getAttribute('data-step');
                    if (new_step < current_step) this.step = new_step;
                },
                federalCity: function(kladr_block_id) {
                    if (kladr_block_id == "sender") this.telegram_data.s_city = this.telegram_data.s_region;
                    if (kladr_block_id == "receiver") this.telegram_data.r_city = this.telegram_data.r_region;
                },
                updateRegionFromCity: function(parent, kladr_block_id) {
                    var name = parent.name;
                    var short = parent.typeShort;
                    var v = parent.compute_value(name, short);
                    if (kladr_block_id == "sender") this.telegram_data.s_region = v;
                    if (kladr_block_id == "receiver") this.telegram_data.r_region = v;
                },
                processFile: function(event){
                    var vm = this;
                    var file = event.target.files[0];
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        vm.telegram_data.text = reader.result;
                    }
                    reader.readAsText(file);
                },
                chooseReceiver: function() {
                    var vm = this;
                    axios.get("/get_receiver_data/" + this.saved_receiver)
                        .then(function (response) {
                            var data = response.data;
                            vm.telegram_data.r_name = data.name;
                            vm.telegram_data.r_surname = data.surname;
                            vm.telegram_data.r_company = data.company;
                            vm.telegram_data.r_phone = data.phone || "";
                            vm.telegram_data.r_email = data.email;
                            vm.telegram_data.r_region = data.region;
                            vm.telegram_data.r_city = data.city;
                            vm.telegram_data.r_street = data.street;
                            vm.telegram_data.r_building = data.building;
                            vm.telegram_data.r_flat = data.flat;
                        })
                        .catch(function (response) {
                            console.log(response);
                        })

                },
                chooseTemplate: function() {
                    var vm = this;
                    axios.get("/get_template_data/" + this.saved_template)
                        .then(function (response) {
                            var data = response.data;
                            vm.telegram_data.text = data.template;
                        })
                        .catch(function (response) {
                            console.log(response);
                        })
                },
                telegraf_abbr_replace: function(){
                    var text = this.telegram_data.text;
                    var flag = this.telegraf_abbr;
                    for (k in tlg_abbrs) {
                        var r = "";
                        var pattern = tlg_abbrs[k];
                        if (k == "(") r = /\(/g;
                        else if (k == ")") r = /\)/g;
                        else if (k == ".") r = /\./g;
                        else if (k == "?") r = /\?/g;
                        else r = new RegExp(k, "g");
                        if (!flag) {
                            r = new RegExp(tlg_abbrs[k], "g");
                            pattern = k;
                        }
                        text = text.replace(r, pattern);
                    }
                    this.telegram_data.text = text.replace( /  /g, " ");
                },
                validate_steps: function(step) {
                    var vm = this;
                    var data = vm.$data.telegram_data;
                    if (step == 1) {
                        Validator.validateRules(vm, data, true, ["s_fio", "notification"]);
                        if (this.telegram_data.s_type == "jur") Validator.validateRules(vm, data, false, ["s_company"]);
                        if (this.telegram_data.notification == "address") Validator.validateRules(vm, data, false, ["s_fio", "notification", "s_region", "s_city", "s_street", "s_building"]);
                        if (this.telegram_data.notification == "phone") Validator.validateRules(vm, data, false, ["s_phone"]);
                        if (this.telegram_data.notification == "email") Validator.validateRules(vm, data, false, ["s_email"]);
                    }
                    if (this.telegramStep) Validator.validateRules(vm, data, true, ["r_name", "r_surname", "r_region", "r_city", "r_street", "r_building"]);
                    if (this.copyStep) Validator.validateRules(vm, data, true, ["copy_date","copy_number","payment_type"]);
                    if (step == 4) Validator.validateRules(vm, data, true, ["text", "payment_type"]);
                },
                submit: function(){
                    this.validate_steps(this.step);
                    var validate_check = Object.keys(this.validate_errors).length;
                    if (validate_check) return;
                    if (this.telegramStep && this.save_receiver) {
                        this.showModal=true;
                        return;
                    }
                    if (this.step == 1 && this.save_myself) {
                        this.showModal=true;
                        return;
                    }
                    this.next();
                },
                submit_finally: function() {
                    var vm = this;
                    vm.validate_steps(vm.step);
                    if (!Object.keys(vm.validate_errors).length) {
                        axios.post("/save_telegram", vm.telegram_data)
                            .then(function (response) {
                                vm.request_number = response.data;
                                vm.step = vm.last_step;
                            })
                            .catch(function (response) {
                                console.log(response);
                            })
                    }
                },
                submit_receiver: function(){
                    var vm = this;
                    var url = vm.$refs["reciever_form"].getAttribute("action");
                    var data = {
                        template_name: vm.template_name,
                        name: vm.telegram_data.r_name,
                        surname: vm.telegram_data.r_surname,
                        company: vm.telegram_data.r_company,
                        phone: vm.telegram_data.r_phone,
                        email: vm.telegram_data.r_email,
                        region: vm.telegram_data.r_region,
                        city: vm.telegram_data.r_city,
                        street: vm.telegram_data.r_street,
                        building: vm.telegram_data.r_building,
                        flat: vm.telegram_data.r_flat
                    };
                    axios.post(url, data)
                            .then(function (response) {
                                vm.showModal = false;
                                vm.next();
                            })
                            .catch(function (response) {
                                console.log(response);
                            })

                },
                submit_register: function(){
                    var vm = this;
                    var url = vm.$refs["register_form"].getAttribute("action");
                    var data = {
                        user_type: vm.telegram_data.s_type,
                        fio: vm.telegram_data.s_fio,
                        company: vm.telegram_data.s_company,
                        phone: vm.telegram_data.s_phone,
                        email: vm.telegram_data.s_email,
                        region: vm.telegram_data.s_region,
                        city: vm.telegram_data.s_city,
                        street: vm.telegram_data.s_street,
                        building: vm.telegram_data.s_building,
                        flat: vm.telegram_data.s_flat,
                        password: vm.password,
                        password_confirmation: vm.confirm_password
                    };
                    axios.post(url, data)
                            .then(function (response) {
                                vm.showModal = false;
                                vm.next();
                            })
                            .catch(function (response) {
                                var errs = response.data.errors
                                if (errs) {
                                    var keys = Object.keys(errs);
                                    for (var i = 0; i < keys.length; i++) {
                                        var field = keys[i];
                                        vm.$set(vm.validate_errors, field, errs[field][0])
                                    }
                                }
                                console.log(response);
                            })

                },
                process_date: function(d){
                    return d.toISOString().slice(0,10)
                }
            },
            computed: {
                telegramStep: function(){
                    return (this.step==3 && (this.telegram_data.service_type=='telegram' || this.telegram_data.service_type=='international'));
                },
                copyStep: function(){
                    return (this.step==3 && (this.telegram_data.service_type=='copy_in' || this.telegram_data.service_type=='copy_out'));
                }
            },
            components: {
                vuejsDatepicker,
                MaskedInput,
                Modal,
                TlgTextarea,
                KladrItem,
                KladrBlock
            }
        })