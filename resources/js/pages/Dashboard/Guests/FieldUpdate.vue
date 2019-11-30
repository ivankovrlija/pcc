<template>
    <div class="form-group col-lg-12">
        <label for="field_name" class="col-form-label">Field:</label>
        <textarea v-model="field_name" v-on:keyup="getUpdatedFieldName" type="text" name="field_name" class="form-control"></textarea>
    </div>
</template>

<script>



export default {
    name: 'FieldUpdate',
    components: {

    },
    props: {

    },
    data() {
        return {
            field_name: ''
        }
    },
    computed: {

    },
    mounted() {
        this.fetchFieldName();
    },
    methods: {
        getUpdatedFieldName(){
            this.$emit('special_field_updated', this.field_name)
        },
        fetchFieldName() {

            this.$http.get(`guests/addfields/${this.$route.params.id}`, {}).then(response => {

                this.field_name = response.data.field_name

            })
        }
    },
    watch: {
       
    }
}
</script>
