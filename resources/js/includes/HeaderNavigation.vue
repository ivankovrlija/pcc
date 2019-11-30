<template>
    <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default ">
        <ul class="kt-menu__nav">
            <li
                v-for="navItem in availableRoutes"
                :key="navItem.name"
                class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel kt-menu__item"
                :class="{ 'kt-menu__item--active': subIsActive(navItem.url) }"
            >
                <router-link class="kt-menu__link" :to="navItem.url">
                    <span class="kt-menu__link-text">{{ navItem.label }}</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </router-link>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'HeaderNavigation',
    computed: {
        availableRoutes() {
            let routes = []

            if (this.$route.path.indexOf('online-presence') === 1) {
                routes = [
                { name: 'social-connect', label: 'Social Connect', url: '/online-presence/social' },
                { name: 'web-traffic', label: 'Web Traffic', url: '/online-presence/analytics' },
                { name: 'lead-capture-widget', label: 'Lead Capture Widget', url: '/online-presence/forms' },
                { name: 'review-management', label: 'Review Management', url: '#' },
                { name: 'live-chat', label: 'Live Chat', url: '#' }
                ]
            } else if (this.$route.path.indexOf('marketing') === 1) {
                routes = [
                { name: 'emails', label: 'Emails', url: '/marketing/emails' },
                { name: 'campaigns', label: 'Email Campaigns', url: '/marketing/campaigns' },
                { name: 'ad-campaigns', label: 'Ad Campaigns', url: '/marketing/ad-campaigns' }
                ]
            }

            return routes
        }
    },
    methods: {
        subIsActive(input) {
            const paths = Array.isArray(input) ? input : [input]
            return paths.some(path => {
                return this.$route.path.indexOf(path) === 0
            })
        }
    }
}
</script>

