<template>
    <div class="kt-grid kt-grid--ver kt-grid--root">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid  kt-error-v3" :style="`background-image: url('${NotFoundBG}');`">
            <div class="kt-error_container">
                <span class="kt-error_number">
                    <h1>404</h1>
                </span>
                <p class="kt-error_title kt-font-light">
                    How did you get here
                </p>
                <p class="kt-error_subtitle">
                    Sorry we can't seem to find the page you're looking for.
                </p>
                <p class="kt-error_description">
                    There may be amisspelling in the URL entered,<br>
                    or the page you are looking for may no longer exist.
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import NotFoundBG from '../../images/404-bg.jpg'

export default {
    name: 'PageNotFound',
    data() {
        return {
            NotFoundBG: NotFoundBG
        }
    }
}
</script>

