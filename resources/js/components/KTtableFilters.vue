<template>
    <div class="filters-wrapper">
        <form @submit.prevent="handleSubmit">
            <div class="form-group row">
                <div class="col-4">
                    <select ref="filterField" class="form-control m-input" v-model="field">
                        <option value="" selected disabled>Select field to filter</option>
                        <option class="text-capitalize" v-for="(option, index) in filteredOptions" :key="`filter_${index}`" :value="option.value">{{ option.label }}</option>
                    </select>
                </div>
                <div class="col-4">
                    <input class="form-control" type="text" v-model="value">
                </div>
                <div class="col-4">
                    <button class="btn btn-primary"><i class="flaticon-plus"></i> Add Filter</button>
                </div>
            </div>
        </form>
        <div class="filter-badges">
            <div v-for="(filter, index) in filters" :key="`selected_filter_${index}`" class="btn-group mr-2 mb-2" role="group" aria-label="First group">
                <button type="button" class="m-btn btn btn-sm btn-primary"><strong>{{ filter.field }}:</strong> {{ filter.value }}</button>
                <button type="button" class="m-btn btn btn-sm btn-primary" @click="removeFilter(index)"><i class="flaticon-close"></i></button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'KTtableFilters',
    props: {
        options: Array,
        columns: Object
    },
    mounted: function() {
        $(this.$refs.filterField).selectpicker();
    },
    data: function() {
        return {
            filters: [],
            field: '',
            value: ''
        }
    },
    computed: {
        filteredOptions: function() {
            let options = [];
            for (let index in this.options) {
                options.push({
                    label: this.options[index].label,
                    value: this.options[index].value
                })
            }

            if (this.columns) {
                options = options.filter(option => this.columnsAsArray.includes(option.value))
            }

            return options.filter(option => !this.options.includes(option.value));
        },
        selectedFields: function() {
            if (!this.filters.length) return [];
            
            return this.filters.map(filter => filter.field);
        },
        columnsAsArray: function() {
            let columns = [];
            for (let key in this.columns) {
                columns.push(key);
            }

            return columns;
        }
    },
    methods: {
        handleSubmit: function() {
            const field = this.field;
            const value = this.value.trim();

            this.value = '';
            this.field = '';

            if (!value || !field) {
                swal.fire('Invalid entries!', 'Please select a field and enter their corresponding value for filtering', 'warning')
                // alert('Field or Value cannot be empty');
                return;
            }

            this.filters.push({
                field: field,
                value: value
            })

            this.$emit('triggerSearch', this.filters)

            this.$nextTick(() => {
                $(this.$refs.filterField).selectpicker('refresh');
            })
        },
        removeFilter: function(index) {
            this.filters.splice(index, 1);
            this.$emit('triggerSearch', this.filters);

            this.$nextTick(() => {
                $(this.$refs.filterField).selectpicker('refresh');
            })
        }
    }
}
</script>
