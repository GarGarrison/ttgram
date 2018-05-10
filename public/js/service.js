var ttgram = new Vue({
            el: '#ttgram',
            data: {
                step:1,
                last_step:5,
                saved_receiver: "",
                saved_template: "",
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
                    notification: "email",
                    service_type: "telegram",
                    payment_type: "",
                    text: "",
                    copy_date: "",
                    copy_number: "",
                    copy_direction: "copy_in"
                },
                request_number: "",
                validate_errors: {}
            },
            mixins: [mount_mixin, kladr_mixin],
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
                validate_rules: function(arr) {
                    for (var i = 0; i < arr.length; i++) {
                        var field = arr[i];
                        var field_data = this.$data.telegram_data[field]
                        var reg_type = input_types[field];
                        var rule = validator[reg_type];
                        if (! rule['rgxp'].test(field_data)) this.$set(this.validate_errors, field, rule['text'])
                    }
                },
                validate_steps: function(step) {
                    this.validate_errors = {};
                    if (step == 1) this.validate_rules(["s_fio", "s_phone", "s_email", "notification"]);
                    if (step == 1 && this.telegram_data.notification == "address") this.validate_rules(["s_region", "s_city", "s_street", "s_building"]);
                    if (this.telegramStep) this.validate_rules(["r_name", "r_surname", "r_region", "r_city", "r_street", "r_building"]);
                    if (step == 4) this.validate_rules(["text", "payment_type"]);
                },
                submit: function(){
                    this.validate_steps(this.step);
                    if (!Object.keys(this.validate_errors).length) this.next();
                    // this.next();
                },
                submit_finally: function() {
                    vm = this;
                    vm.validate_steps(this.step);
                    if (!Object.keys(vm.validate_errors).length) {
                        axios.post("/save_telegram/", vm.telegram_data)
                            .then(function (response) {
                                vm.request_number = response.data;
                                vm.step = vm.last_step;
                                //vm.telegram_data.text = data.template;
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
            }
        })