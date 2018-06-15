<template>
    <div>
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
    </div>
</template>
<script>
    export default {
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
    }
</script>