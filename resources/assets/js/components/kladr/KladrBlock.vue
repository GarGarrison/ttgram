<template>
    <div><slot></slot></div>
</template>
<script>
    export default {
        data: function(){
            return {
                region: "",
                city: "",
                street: "",
                building: ""
            }
        },
        watch: {
            region: function(val) {
                if (val.id == "7700000000000" || val.id == "7800000000000") {
                    var kladr_block_id = this.$el.getAttribute("id");
                    this.city = this.region;
                    this.$root.federalCity(kladr_block_id);
                }
            },
            city: function(val) {
                if (this.region == "") {
                    var kladr_block_id = this.$el.getAttribute("id");
                    var parent = val;
                    if (val.parents.length > 0) parent = val.parents[0];
                    parent.compute_value = val.compute_value;
                    this.region = parent;
                    this.$root.updateRegionFromCity(parent, kladr_block_id);
                }
            }
        }
}
</script>