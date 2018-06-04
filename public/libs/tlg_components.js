Vue.component("tlg-textarea", {
    data: function(){
        return {
            //
        }
    },
    props: ['name', 'placeholder', 'data-txt-style', 'data-wc-style', 'value'],
    template: `<div>
                    <textarea @input='input'  :class="dataTxtStyle" :name="name" :placeholder="placeholder" :value="value"></textarea>
                    <div :class="dataWcStyle">{{ wordCount }}</div>
                </div>`,
    methods: {
        input: function(event){
            this.$emit('input', event.target.value);
        }
    },
    computed: {
        wordCount: function() {
            var val = _.replace(this.value, /-/g, " ");
            if (val == "") return 0;
            else return val.split(" ").filter(function(item){ return item != ""}).length;
        }
    }
});

Vue.component("menu-button", {
    data: function(){
        return {
            show: false
        }
    },
    props: ['data-button-class'],
    template: `
        <div style="position: relative; float:right; text-align: center;">
            <a class="btn-floating" :class='dataButtonClass' @click="show = !show ">
              <i class="material-icons">menu</i>
            </a>
            <transition name="menu-list">
                <ul v-show= "show" class="menu-button-list" @mouseleave="show=true">
                    <slot></slot>
                </ul>
            </transition>
        </div>
    `
});

Vue.component("modal", {
    data: function(){
        return {
            maskHeight: {},
            msgHeight: {}
        }
    },
    template: `
        <transition name="modal">
            <div class="modal-mask" @click="maskClick" v-bind:style="maskHeight">
              <div class="modal-wrapper">
                <div class="modal-container" v-bind:style="msgHeight">
                  <div class="modal-header row">
                    <i class="material-icons right pointer" @click="$emit('close')">close</i>
                    <slot name="header">
                      default header
                    </slot>
                  </div>

                  <div class="modal-body row">
                    <slot name="body">
                      default body
                    </slot>
                  </div>
                </div>
              </div>
            </div>
          </transition>
    `,
    mounted: function() {
        var h = document.body.clientHeight;
        var max_h = window.innerHeight * 0.9;
        this.$set(this.maskHeight, "height", h+"px");
        //this.$set(this.msgHeight, "max-height", max_h+"px");
    },
    methods: {
        maskClick: function(event){
            if (event.target.classList.contains('modal-wrapper')) this.$emit('close');
        }
    }
});

Vue.component("list-filter", {
    template: ` <div>
                    <table class="filter_table">
                            <slot name="inputs" :fields="fields">
                                <th colspan="2">
                                    <input type="text" :placeholder="placeholder" :class="dataInputStyle" v-model="search">
                                </th>
                            </slot>
                            <tr v-for="item in list" :key="item.id">
                                <slot :row="item"></slot>
                            </tr>
                    </table>
                    <h6 v-if="list.length == 0">{{ dataEmpty }}</h6>
                </div>`,
    props: ['original_list', 'filter_field', 'data-empty', 'placeholder', 'data-input-style'],
    data: function(argument) {
        return {
            search: "",
            fields: {}
        }
    },
    computed: {
        list: function(){
            // если фильтрующих полей несколько
            if (this.filter_field instanceof Array) {
                var fields = this.fields;
                var keys = Object.keys(fields);
                // инициация. фильтрующие поля пустые, fields еще тоже пустой - вернуть оригинальный список
                if (keys.length == 0) return this.original_list;
                return this.original_list.filter(function(item){
                    var result = true;
                    for(var i = 0; i < keys.length; i++) {
                        var column = keys[i];
                        var value = item[column];
                        var condition = true;
                        if (typeof(value) == "string" && fields[column] != "") condition = (value.toLowerCase().indexOf(fields[column].toLowerCase()) > -1);
                        if (typeof(value) == "number" && fields[column] != "") condition = (fields[column] == value)
                        result = result && condition;
                    }
                    return result;
                });
            }
            else {
                var search = this.search;
                var column = this.filter_field;
                return this.original_list.filter(function(item){
                    return item[column].toLowerCase().indexOf(search.toLowerCase()) > -1;
                });
            }
        }
    }
})

Vue.component("mask-phone", {
    data: function(){
        return {

        }
    },
    template: `
        <input :id="id" type="text" @change='input' :class="dataClass" :name="name" :placeholder="placeholder" />
    `,
    props: ['data-class', 'id', 'name', 'placeholder', 'value'],
    mounted () {
        new Cleave(this.$el, {
            prefix: '+7',
            phone: true,
            phoneRegionCode: 'RU'
        });
    },
    methods: {
        input: function(event){
            this.$emit('input', event.target.value);
        }
    }
});


var mount_mixin = {
    mounted: function(){
                vm = this;
                var refs = vm.$refs;
                for (var k in refs) {
                    var val = refs[k];
                    // if ref is component (kladr-item)
                    if (val instanceof Vue) {
                        val = val.$refs[k];
                    }
                    if (val) {
                        var v = val.getAttribute("data-value");
                        // if value is empty, use default value from vue.data array
                        if (v) {
                            // if ref smth like telegram_data.region
                            var test_split = k.split('.')
                            if (test_split.length > 1) {
                                var k1 = test_split[0];
                                var k2 = test_split[1];
                                vm.$data[k1][k2] = v;
                            }
                            else vm.$data[k] = v;
                        }
                    }
                }
            }
}