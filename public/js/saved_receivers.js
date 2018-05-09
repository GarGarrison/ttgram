var app = new Vue({
    el: '#ttgram',
    data: {
        tmp_list: [],
        validate_errors: [],
        url_get: "/get_receiver_data/",
        url_get_all: "/profile/saved_receivers/get_receivers",
        url_del: "/profile/saved_receivers/del_receiver",
        showModal: false,
        edit: false,
        current_id: "",
        template_name: "",
        surname: "",
        name: "",
        company: "",
        phone: "",
        email: "",
        region: "",
        city: "",
        street: "",
        building: "",
        flat: ""
    },
    created: function(){
        var vm = this;
        axios.get(this.url_get_all)
            .then(function (response) {
                vm.tmp_list = response.data;
            })
            .catch(function (response) {
                console.log(response)
            })
    },
    methods: {
        deleteItem: function(id){
            vm = this;
            if (!confirm("Удалить адресата?")) return;
            axios.delete(this.url_del, { "params": {"id": id} })
                .then(function (response) {
                    var item = vm.tmp_list.filter(function(item){
                        return item.id == id;
                    })
                    var index = vm.tmp_list.indexOf(item[0]);
                    vm.tmp_list.splice(index, 1);
                })
                .catch(function (response) {
                    console.log(response)
                })
        },
        editItem: function(id) {
            var vm = this;
            this.current_id = id;
            this.edit = true;
            this.showModal = true;
            axios.get(this.url_get + id)
                .then(function (response) {
                    vm.template_name = response.data.template_name;
                    vm.name = response.data.name;
                    vm.surname = response.data.surname;
                    vm.company = response.data.company;
                    vm.phone = response.data.phone;
                    vm.email = response.data.email;
                    vm.region = response.data.region;
                    vm.city = response.data.city;
                    vm.street = response.data.street;
                    vm.building = response.data.building;
                    vm.flat = response.data.flat;
                })
                .catch(function (response) {
                    console.log(response)
                })
        },
        validate: function(step) {
            this.validate_errors = {};
            var arr = ["name", "surname", "company", "region", "city", "street", "building"];
            for (var i = 0; i < arr.length; i++) {
                var field = arr[i];
                var field_data = this.$data[field]
                var reg_type = input_types[field];
                var rule = validator[reg_type];
                if (! rule['rgxp'].test(field_data)) this.$set(this.validate_errors, field, rule['text'])
            }
        },
        submit: function(event){
            this.validate();
            if (!Object.keys(this.validate_errors).length) return;
            else event.preventDefault();
        }
    },
    watch: {
        showModal: function(val){
            if (!val) {
                this.current_id = "";
                this.template_name = "";
                this.surname = "";
                this.name = "";
                this.company = "";
                this.phone = "";
                this.email = "";
                this.region = "";
                this.city = "";
                this.street = "";
                this.building = "";
                this.flat = "";
            }
        }
    }
});