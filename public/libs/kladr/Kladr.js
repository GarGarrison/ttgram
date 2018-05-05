Vue.component("kladr-item", {
    data: function() {
        return {
            url: "/kladr",
            variants: []
        }
    },
    props: ['data-kladr-type', 'placeholder', 'name', 'value', 'data-value', 'data-ref'], // kladr-type: region, city, street, building
    template: `
                    <div class='kladr-wrapper'>
                            <input class='kladr-input' type='text' 
                                @input='search' 
                                @blur='clear_variants' 
                                v-bind:placeholder='placeholder' 
                                v-bind:name='name'
                                v-bind:ref='dataRef'
                                v-bind:data-value='dataValue'
                                v-bind:value='value'>
                            <transition name='kladr-list'>
                                <div class='kladr-list' v-show='variants.length > 0'>
                                    <div v-for='(v, index) in variants' 
                                         v-bind:key='index + v.id' 
                                         v-bind:data-id='v.id' 
                                         v-bind:name='v.name' 
                                         v-bind:data-short='v.typeShort' 
                                         @mousedown='choose'>
                                         {{ compute_value(v.name,v.typeShort) }}
                                    </div>
                                </div>
                            </transition>
                    </div>`,
    methods: {
        getParent: function(dType) {
            switch(dType) {
                case "city": return "region";
                case "street": return "city";
                case "building": return "street";
                default: return "";
            }
        },
        search: _.debounce(
                function(event){
                    var vm = this;
                    vm.$emit('input', event.target.value);
                    var parent_type = this.getParent(this.dataKladrType);
                    var params = {"value": this.value, "type": this.dataKladrType,"parent_type": parent_type, "parent": this.$parent.$data[parent_type]}
                    axios.get(this.url, { "params": params })
                        .then(function (response) {
                            data = response.data;
                            vm.clear_variants();
                            for (var i=0; i<data.length; i++) vm.variants.push(data[i]);
                        })
                        .catch(function (response) {
                            console.log(response)
                        })
                }
        ),
        choose: function(event) {
            var name = event.target.getAttribute('name');
            var id = event.target.getAttribute('data-id');
            var short = event.target.getAttribute('data-short');
            var full_value = this.compute_value(name, short);
            this.clear_variants();
            this.$emit('input', full_value);
            this.$parent.$data[this.dataKladrType] = id;
        },
        clear_variants: function(event) {
            this.variants.splice(0);
        },
        compute_value: function(name, short) {
            return name + " " + short + "."
        }
    }
});

Vue.component("kladr-block", {
    data: function(){
        return {
            region: "",
            city: "",
            street: "",
            building: ""
        }
    },
    template: "<div><slot></slot></div>",
});