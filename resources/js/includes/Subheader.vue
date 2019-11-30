<template>
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">{{ title }}</h3>
            <span v-if="separator" class="kt-subheader__separator kt-subheader__separator--v"></span>
            <slot name="content"></slot>
        </div>
    
        <div class="kt-subheader__toolbar">
            <slot name="toolbar"></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Subheader',
    props: {
        title: {
            type: String,
            default: ''
        },
        separator: {
            type: Boolean,
            default: false
        }
    }
}
</script>

