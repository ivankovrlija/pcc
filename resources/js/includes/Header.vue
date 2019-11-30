<template>
    <div id="kt_header" class="kt-header kt-grid__item kt-header--fixed">
        <button id="kt_header_menu_mobile_close_btn" class="kt-header-menu-wrapper-close">
            <i class="la la-close"></i>
        </button>
        <div id="kt_header_menu_wrapper" class="kt-header-menu-wrapper" style="opacity: 1;">
            <HeaderNavigation />
        </div>
        <div class="kt-header__topbar">
            <HeaderNotificationsDropdown />
            <HeaderUserDropdown />
        </div>
    </div>
</template>

<script>
import HeaderNavigation from './HeaderNavigation'
import HeaderNotificationsDropdown from './HeaderNotificationsDropdown'
import HeaderUserDropdown from './HeaderUserDropdown'

export default {
    name: 'Header',
    components: {
        HeaderNavigation,
        HeaderNotificationsDropdown,
        HeaderUserDropdown,
    }    
}
</script>

