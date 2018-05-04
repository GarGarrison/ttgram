var app = new Vue({
    el: '#ttgram',
    data: {
        tmp_list: [],
        validate_errors: [],
        url_get: "http://localhost:8000/home/saved_receivers/get_receivers",
        url_del: "http://localhost:8000/home/saved_receivers/del_receivers",
        showModal: false,
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
    mounted: function(){
        var vm = this;
        axios.get(this.url_get)
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
    }
});