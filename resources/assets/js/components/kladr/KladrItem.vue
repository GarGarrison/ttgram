<template>
    <div class='kladr-wrapper'>
        <input class='kladr-input' type='text' 
            @input='search' 
            @blur='clear_variants' 
            :id='id'
            :placeholder='placeholder' 
            :name='name'
            :value='value'>
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
    </div>
</template>
<script>
    import lodash from 'lodash'
    import axios from 'axios'
    export default {
        data: function() {
            return {
                url: "/kladr",
                variants: []
            }
        },
        // kladr-type: region, city, street, building
        props: ['id', 'data-kladr-type', 'placeholder', 'name', 'value'],
        methods: {
            getParent: function(dType) {
                switch(dType) {
                    case "city": return "region";
                    case "street": return "city";
                    case "building": return "street";
                    default: return "";
                }
            },
            search: lodash.debounce(
                    function(event){
                        var vm = this;
                        vm.$emit('input', event.target.value);
                        var parent_type = vm.getParent(vm.dataKladrType);
                        var parent_id = "";
                        if (parent_type) parent_id = vm.$parent.$data[parent_type].id;
                        var params = {"value": vm.value, "type": vm.dataKladrType,"parent_type": parent_type, "parent": parent_id}
                        axios.get(vm.url, { "params": params })
                            .then(function (response) {
                                var data = response.data;
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
    }
</script>
<style>
    .kladr-wrapper {
        position: relative;
    }
    .kladr-list {
        padding: 0px;
        margin: 0px;
        width: 100%;
        position: absolute;
        background: white;
        z-index: 100;
        opacity: .8;
        top: -3;
    }
    .kladr-list div {
        padding: 10px;
        border: 1px solid #e5e5e5;
        border-collapse: collapse;
        cursor: pointer;
    }
    .kladr-list div:hover {
        background: #e5e5e5;
    }

    .kladr-list-enter-active, .kladr-list-leave-active {
        transition: opacity .3s;
    }
    .kladr-list-enter, .kladr-list-leave-to {
        opacity: 0;
    }
</style>