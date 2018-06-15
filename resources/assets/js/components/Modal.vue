<template>
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
</template>
<script>
    export default {
        data: function(){
            return {
                maskHeight: {},
                msgHeight: {}
            }
        },
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
}
</script>
<style>
    .modal-mask {
          position: absolute;
          z-index: 9998;
          top: 0;
          left: 0;
          width: 100%;
          background-color: rgba(0, 0, 0, .5);
          display: table;
          transition: opacity .3s ease;
        }

        .modal-wrapper {
          height: 100%;
          display: table-cell;
          vertical-align: middle;
        }

        .modal-container {
          width: 80%;
          max-width: 800px;
          margin: 0px auto;
          padding: 20px 30px;
          background-color: #fff;
          border-radius: 2px;
          box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
          transition: all .3s ease;
        }

        .modal-header h3 {
          margin-top: 0;
          color: #308ce7;
        }

        .modal-body {
          margin: 20px 0;
        }

        .modal-default-button {
          float: right;
        }
        .pointer {
          cursor: pointer;
        }

        /*
         * The following styles are auto-applied to elements with
         * transition="modal" when their visibility is toggled
         * by Vue.js.
         *
         * You can easily play with the modal transition by editing
         * these styles.
         */

        .modal-enter {
          opacity: 0;
        }

        .modal-leave-active {
          opacity: 0;
        }

        .modal-enter .modal-container,
        .modal-leave-active .modal-container {
          -webkit-transform: scale(1.1);
          transform: scale(1.1);
        }
</style>