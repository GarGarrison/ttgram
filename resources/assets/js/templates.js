import Vue from 'vue'
import axios from 'axios'
import ListFilter from './components/ListFilter.vue'
import TlgTextarea from './components/TlgTextarea.vue'
import MenuButton from './components/MenuButton.vue'
import Modal from './components/Modal.vue'

var app = new Vue({
    el: '#ttgram',
    data: {
        tmp_list: [],
        validate_errors: [],
        url_get: "/get_template_data/",
        url_get_all: "/profile/templates/get_templates",
        url_del: "/profile/templates/del_template",
        showModal: false,
        edit: false,
        current_id: "",
        template_name: "",
        template: ""
        
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
            var vm = this;
            if (!confirm("Удалить выбранный шаблон?")) return;
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
            var vm = this
            this.edit = true;
            this.showModal = true;
            this.current_id = id;
            axios.get(this.url_get + id)
                .then(function (response) {
                    vm.template_name = response.data.template_name;
                    vm.template = response.data.template;
                })
                .catch(function (response) {
                    console.log(response)
                })
        },
        submit: function(event){
            var vm = this;
            var check = Validator.validateRules(vm, vm.$data, true, ["template_name", "template"]);
            if (!check) event.preventDefault();
        }
    },
    watch: {
        showModal: function(val){
            if (!val) {
                this.current_id = "";
                this.template = "";
                this.template_name = "";
            }
        }
    },
    components: {
        ListFilter,
        TlgTextarea,
        MenuButton,
        Modal
    }
});