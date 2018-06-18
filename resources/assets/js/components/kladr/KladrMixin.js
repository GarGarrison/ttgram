export default {
    methods: {
        federalCity: function(kladr_block_id){
            this.city = this.region;
        },
        updateRegionFromCity: function(parent, kladr_block_id) {
            var name = parent.name;
            var short = parent.typeShort;
            this.region = parent.compute_value(name, short);
        }
    }
}