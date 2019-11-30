<template>
    <button
        class="btn btn-primary"
        :class="{ 'm-loader m-loader--right': loading }"
        :disabled="loading"
        type="submit"
    >
        {{ loading ? 'Saving' : 'Save' }}
    </button>
</template>

<script>
export default {
    name: 'GuestFolioLogsSubmitBtn',
    props: {
        loading: Boolean
    }
}
</script>
