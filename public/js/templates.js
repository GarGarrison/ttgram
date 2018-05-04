var app = new Vue({
    el: '#ttgram',
    data: {
        tmp_list: [],
        validate_errors: [],
        url_get: "http://localhost:8000/home/templates/get_templates",
        url_del: "http://localhost:8000/home/templates/del_template",
        showModal: false
        
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
        }
    }
});