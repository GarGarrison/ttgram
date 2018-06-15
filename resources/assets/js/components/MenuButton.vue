<template>
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
</template>
<script>
    export default {
        data: function(){
            return {
                show: false
            }
        },
        props: ['data-button-class']
    }
</script>