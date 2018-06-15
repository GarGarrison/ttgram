import Vue from 'vue'
import MaskedInput from 'vue-masked-input'

import Modal from './components/Modal.vue'
import MenuButton from './components/MenuButton.vue'
import KladrItem from './components/kladr/KladrItem.vue'
import KladrBlock from './components/kladr/KladrBlock.vue'
import kladr_mixin from './components/kladr/KladrMixin.js'

var app = new Vue({
    el: '#ttgram',
    data: {
        user_type: document.getElementById('user_type').getAttribute('value') || "fiz",
        fio: document.getElementById('fio').getAttribute('value'),
        company: document.getElementById('company').getAttribute('value'),
        inn: document.getElementById('inn').getAttribute('value'),
        kpp: document.getElementById('kpp').getAttribute('value'),
        phone: document.getElementById('phone').getAttribute('value'),
        email: document.getElementById('email').getAttribute('value'),
        country: document.getElementById('country').getAttribute('value'),
        region: document.getElementById('region').getAttribute('value'),
        city: document.getElementById('city').getAttribute('value'),
        street: document.getElementById('street').getAttribute('value'),
        building: document.getElementById('building').getAttribute('value'),
        flat: document.getElementById('flat').getAttribute('value')
    },
    mixins: [kladr_mixin],
    components: {
        MaskedInput,
        Modal,
        MenuButton,
        KladrItem,
        KladrBlock
    }
});