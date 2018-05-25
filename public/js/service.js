// window.onload = function() {
//         var fileInput = document.getElementById('fileInput');
//         var fileDisplayArea = document.getElementById('fileDisplayArea');

//         fileInput.addEventListener('change', function(e) {
//             var file = fileInput.files[0];
//             var textType = /text.*/;

//             if (file.type.match(textType)) {
//                 var reader = new FileReader();

//                 reader.onload = function(e) {
//                     fileDisplayArea.innerText = reader.result;
//                 }

//                 reader.readAsText(file);    
//             } else {
//                 fileDisplayArea.innerText = "File not supported!"
//             }
//         });
// }

var RU = {
    language: 'Russian',
    months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
    monthsAbbr: ['Янв', 'Февр', 'Март', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сент', 'Окт', 'Нояб', 'Дек'],
    days: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
    rtl: false,
    ymd: false,
    yearSuffix: ''
};

var ttgram = new Vue({
            el: '#ttgram',
            data: {
                step:1,
                last_step:5,
                lang: RU,
                saved_receiver: "",
                saved_template: "",
                picker_copy_date: "",
                telegram_data: {
                    s_type: "fiz",
                    s_fio: "",
                    r_name: "",
                    r_surname: "",
                    s_company: "",
                    r_company: "",
                    s_phone: "",
                    r_phone: "",
                    s_email: "",
                    r_email: "",
                    s_region: "",
                    r_region: "",
                    s_city: "",
                    r_city: "",
                    s_street: "",
                    r_street: "",
                    s_building: "",
                    r_building: "",
                    s_flat: "",
                    r_flat: "",
                    notification: "",
                    service_type: "telegram",
                    payment_type: "",
                    text: "",
                    copy_date: "",
                    copy_number: ""
                },
                request_number: "",
                validate_errors: {}
            },
            mixins: [mount_mixin, kladr_mixin],
            watch: {
                picker_copy_date: function(v) {
                    this.telegram_data.copy_date = v.toISOString().slice(0,10)
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
                    vm = this;
                    var file = event.target.files[0];
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        vm.telegram_data.text = reader.result;
                    }
                    reader.readAsText(file);
                },
                chooseReceiver: function() {
                    vm = this;
                    axios.get("/get_receiver_data/" + this.saved_receiver)
                        .then(function (response) {
                            data = response.data;
                            vm.telegram_data.r_name = data.name;
                            vm.telegram_data.r_surname = data.surname;
                            vm.telegram_data.r_company = data.company;
                            vm.telegram_data.r_phone = data.phone;
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
                    vm = this;
                    axios.get("/get_template_data/" + this.saved_template)
                        .then(function (response) {
                            data = response.data;
                            vm.telegram_data.text = data.template;
                        })
                        .catch(function (response) {
                            console.log(response);
                        })
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
                    if (!Object.keys(this.validate_errors).length) this.next();
                },
                submit_finally: function() {
                    vm = this;
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
                vuejsDatepicker
            }
        })