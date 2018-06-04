<!DOCTYPE html>
<html>
<head>
    <title>Testings</title>
    <meta charset="utf-8">
    <script type="text/javascript" src="/libs/vue_dev.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@0.12.0/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.13.1/lodash.min.js"></script>
    <script type="text/javascript" src="/libs/kladr/Kladr.js"></script>
    <script type="text/javascript" src="/libs/tlg_components.js"></script>
    <script type="text/javascript" src="/libs/cleave/cleave.min.js"></script>
    <script type="text/javascript" src="/libs/cleave/addons/cleave-phone.ru.js"></script>
</head>
<style type="text/css">

</style>
<body>
    <div id="app">
        <mask-phone id="phone" name="phone" v-model="phone" placeholder="phone"></mask-phone>
    </div>
</body>
<script type="text/javascript">
    var app = new Vue({
            el: '#app',
            data: {
                phone: document.getElementById('phone').getAttribute('value'),
                step: 0
            },
            methods: {
                next: function(){
                    this.step++;
                }
            },
            computed: {
                currentStep: function(){
                    return this.step
                }
            }
        });
</script>
</html>