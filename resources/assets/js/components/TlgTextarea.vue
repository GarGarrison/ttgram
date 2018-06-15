<template>
    <div>
        <textarea class="textarea" @input='input'  :class="dataTxtStyle" :name="name" :placeholder="placeholder" :value="value"></textarea>
        <div :class="dataWcStyle">{{ wordCount }}</div>
    </div>
</template>

<script>
    export default {
        data: function(){
            return {
                //
            }
        },
        props: ['name', 'placeholder', 'data-txt-style', 'data-wc-style', 'value'],
        
        methods: {
            input: function(event){
                this.$emit('input', event.target.value);
            }
        },
        computed: {
            wordCount: function() {
                var val = this.value.replace(/-/g, " ");
                if (val == "") return 0;
                else return val.split(" ").filter(function(item){ return item != ""}).length;
            }
        }
    }
</script>