import Vue from 'vue'
import axios from 'axios'
import ListFilter from './components/ListFilter.vue'
import MenuButton from './components/MenuButton.vue'

var app = new Vue({
    el: '#ttgram',
    data: {
        history_list: [],
        url_get_all: "/profile/history/get_history",
    },
    created: function(){
        var vm = this;
        axios.get(this.url_get_all)
            .then(function (response) {
                vm.history_list = response.data;
            })
            .catch(function (response) {
                console.log(response)
            })
    },
    components: {
        ListFilter,
        MenuButton
    }
});