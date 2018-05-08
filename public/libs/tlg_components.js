Vue.component("tlg-textarea", {
    data: function(){
        return {
            text: ""
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
            var t = this.text.trim();
            if (t == "") return 0;
            else return t.split(" ").length;
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

var list_mixin = {
    data: function(){
        return {
            search: ""
        }
    },
    props: ['placeholder','data-list-name', 'data-list-style', 'data-item-style', 'data-input-style', 'data-empty'],
    methods: {
        deleteThis: function(event) {
            var id = event.target.getAttribute('data-id');
            this.$parent.deleteItem(id);
        },
        editThis: function(event) {
            var id = event.target.getAttribute('data-id');
            this.$parent.editItem(id);
        }        
    },
    computed: {
        list: function(){
            var param_name = this.dataListName;
            var list = this.$parent.$data[param_name];
            var search = this.search;
            return list.filter(function(item){
                return item.name.toLowerCase().indexOf(search.toLowerCase()) > -1
            });
        }
    }
}

Vue.component("template-list-filter", {
    template: `<div :class="dataListStyle">
                    <div class="row">
                        <div class="col s12">
                            <input type="text" :placeholder="placeholder" :class="dataInputStyle" v-model="search">
                        </div>
                    </div>
                    <div class="row" v-for="item in list" :key="item.id" :class="dataItemStyle">
                        <div class="col s6 m4">
                            <div class = "truncate list-element">
                                {{ item.name }}
                                <i class="material-icons" @click="deleteThis" v-bind:data-id="item.id" title="удалить">close</i>
                            </div>
                        </div>
                        <div class="col s6 m8">
                            <div class = "truncate list-element">
                                {{ item.template }}
                                <i class="material-icons" @click="editThis" v-bind:data-id="item.id" title="редактировать">mode_edit</i>
                            </div>
                        </div>
                    </div>
                    <div class="col s12" v-if="list.length == 0">{{ dataEmpty }}</div>
                </div>
    `,
    mixins: [list_mixin]
})

Vue.component("receivers-list-filter", {
    template: `<div :class="dataListStyle">
                    <div class="row">
                        <div class="col s12">
                            <input type="text" :placeholder="placeholder" :class="dataInputStyle" v-model="search">
                        </div>
                    </div>
                    <div class="row" v-for="item in list" :key="item.id" :class="dataItemStyle">
                        <div class="col s6 m4">
                            <div class = "truncate list-element">
                                <span class="left">{{ item.template_name }}</span>
                                <i class="material-icons" @click="deleteThis" v-bind:data-id="item.id" title="удалить">close</i>
                            </div>
                        </div>
                        <div class="col s6 m8">
                            <div class = "truncate list-element">
                                {{ item.surname + " " + item.city }}
                                <i class="material-icons" @click="editThis" v-bind:data-id="item.id" title="редактировать">mode_edit</i>
                            </div>
                        </div>
                    </div>
                    <div class="col s12" v-if="list.length == 0">{{ dataEmpty }}</div>
                </div>
    `,
    mixins: [list_mixin]
})

Vue.component("modal", {
    data: function(){
        return {
            //
        }
    },
    template: `
        <transition name="modal">
            <div class="modal-mask" @click="maskClick">
              <div class="modal-wrapper">
                <div class="modal-container">
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
    methods: {
        maskClick: function(event){
            if (event.target.classList.contains('modal-wrapper')) this.$emit('close');
        }
    }
});