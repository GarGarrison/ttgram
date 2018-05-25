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
                                         v-bind:data-index='index'
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
                    var parent_type = vm.getParent(vm.dataKladrType);
                    var parent_id = "";
                    if (parent_type) parent_id = vm.$parent.$data[parent_type].id;
                    var params = {"value": vm.value, "type": vm.dataKladrType,"parent_type": parent_type, "parent": parent_id}
                    axios.get(vm.url, { "params": params })
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
            var index = event.target.getAttribute('data-index');
            var item = this.variants[index];
            item.compute_value = this.compute_value;
            // var parent = item.parents[0];
            // if (parent){
            //     for (var i=0; i< item.parents.length; i++) {
            //         var p = item.parents[i];
            //         var full_parent_value = this.compute_value(parent.name, parent.typeShort);
            //         console.log(p.name, p.id);
            //     }
            // }
            var full_item_value = this.compute_value(item.name, item.typeShort);

            this.clear_variants();
            this.$emit('input', full_item_value);
            this.$parent.$data[this.dataKladrType] = item;
        },
        clear_variants: function(event) {
            this.variants.splice(0);
        },
        compute_value: function(name, short) {
            return name + " " + short + ".";
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
    watch: {
        region: function(val) {
            if (val.id == "7700000000000" || val.id == "7800000000000") {
                var kladr_block_id = this.$el.getAttribute("id");
                this.city = this.region;
                this.$root.federalCity(kladr_block_id);
            }
        },
        city: function(val) {
            if (this.region == "") {
                var kladr_block_id = this.$el.getAttribute("id");
                var parent = val.parents[0];
                parent.compute_value = val.compute_value;
                this.region = parent;
                this.$root.updateRegionFromCity(parent, kladr_block_id);
            }
        }
    },
    template: "<div><slot></slot></div>",
});

var kladr_mixin = {
    methods: {
        federalCity: function(kladr_block_id){
            this.city = this.region;
        },
        updateRegionFromCity: function(parent, kladr_block_id) {
            var name = parent.name;
            var short = parent.typeShort;
            this.region = parent.compute_value(name, short);
        }
    }
}