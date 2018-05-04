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
</head>
<style type="text/css">

</style>
<body>
    <div id="app">
        <tlg-textarea v-model="text"></tlg-textarea>
    </div>
</body>
<script type="text/javascript">
    // var bus = new Vue();
    var app = new Vue({
            el: '#app',
            data: {
                text: "",
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