<template>
    <div class="kt-widget24">
        <div class="kt-widget24__details">
            <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">{{ title }}</h4>
                <span class="kt-widget24__desc">{{ caption }}</span>
            </div>
            <span class="kt-widget24__stats" :class="color">{{ result }}</span>
        </div>
    </div>
</template>

<script>
export default {
    name: 'KTWidget24',
    props: {
        title: String,
        caption: String,
        result: [String, Number],
        color: String
    }
}
</script>

