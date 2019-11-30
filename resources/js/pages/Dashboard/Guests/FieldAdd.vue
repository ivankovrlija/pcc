<template>
    <div class="form-group col-lg-12">
        <label for="field_name" class="col-form-label">Field:</label>
        <textarea v-model="field_name" v-on:keyup="getFieldName" type="text" name="field_name" class="form-control"></textarea>
    </div>
</template>

<script>



export default {
    name: 'FieldAdd',
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
        
    },
    methods: {
        getFieldName(){
            this.name = this.field_name
            this.$emit('special_field', this.name)
        }
    },
    watch: {

    }
}
</script>
