<template>
    <div class="kt-header__topbar-item kt-header__topbar-item--user">
        <div data-toggle="dropdown" data-offset="0px,0px" class="kt-header__topbar-wrapper">
            <div class="kt-header__topbar-user">
                <span class="kt-header__topbar-welcome kt-hidden-mobile">Hi,</span>
                <span class="kt-header__topbar-username kt-hidden-mobile">{{ currentUser.first_name }}</span>
                <img alt="Pic" :src="avatar">
            </div>
        </div>
        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">
            <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" :style="`background-image: url('${genericBG}');`">
                <div class="kt-user-card__avatar">
                    <img :src="avatar" alt="Pic">
                </div>
                <div class="kt-user-card__name">
                    {{ currentUser.first_name }} {{ currentUser.last_name }}
                    <span v-if="currentUser.type" class="d-block small text-uppercase">{{ currentUser.type }}</span>
                    <span
                        v-if="currentUser.location || currentUser.organization"
                        class="d-block small"
                    >
                        {{ currentUser.location ? currentUser.location.name : currentUser.organization ? currentUser.organization.name : '' }}
                    </span>
                </div>
                <!--<div class="kt-user-card__badge">
                <span class="btn btn-success btn-sm btn-bold btn-font-md">0 messages</span>
                </div>-->
            </div>
            <div class="kt-notification">
                <router-link v-for="(menu, i) in actualMenus" :key="i" :to="menu.url" class="kt-notification__item">
                    <div class="kt-notification__item-icon">
                        <i :class="`${menu.icon} ${menu.color}`"></i>
                    </div>
                    <div class="kt-notification__item-details">
                        <div class="kt-notification__item-title kt-font-bold">{{ menu.title }}</div>
                        <div class="kt-notification__item-time">{{ menu.caption }}</div>
                    </div>
                </router-link>
                <div class="kt-notification__custom kt-space-between">
                    <a href="javascript:;" class="btn btn-label btn-label-brand btn-sm btn-bold" @click.prevent="handleLogout">Logout</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { logout } from '../services/auth'
import genericBG from '../../images/generic-bg1.jpg'
import defaultAvatar from '../../images/users/default.jpg'

export default {
    name: 'HeaderUserDropdown',
    data() {
        return {
            genericBG: genericBG,
            avatar: '',
            menus: [
                { title: 'My Profile', caption: 'Account settings and more', icon: 'fa fa-calendar', url: '/me' , color: 'kt-font-success'},
                //{ title: 'Integrations', caption: 'Connect your social accounts', icon: 'fa fa-plug', url: '/integrations' , color: 'kt-font-warning'},
                //{ title: 'Roles', caption: 'Manage user roles and permissions', icon: 'fa fa-lock', url: '/roles' , color: 'kt-font-danger'},
                //{ title: 'Members', caption: 'Manage members', icon: 'fas fa-user-friends', url: '/members' , color: 'kt-font-success'},
                //{ title: 'Organizations', caption: 'Add an organization for your users', icon: 'fa fa-users', url: '/organizations', color: 'kt-font-info' }
            ]
        }
    },
    computed: {
        currentUser() {
            return this.$store.getters['auth/currentUser']
        },
        actualMenus() {
                return this.menus 
               
        },
    },
    mounted() {
            this.fetchAvatar()
        },
    methods: {
        fetchAvatar(){
            this.$http.get(`me/1`)
                .then(response => {
                    

                    if (response.data.avatar == null) {
                        this.avatar = defaultAvatar
                    }else{
                        this.avatar      = 'http://' + window.location.hostname + response.data.avatar
                    }
                    
                })
                .catch(error => {
                    if (error.response.status === 404) {
                        this.$router.push({ path: 'user/not-found' })
                    }
                })
        },
        handleLogout() {
            logout()
                .then(response => {
                    this.$store.commit("auth/LOGOUT");
                    this.$router.push({ path: "/login" });
                })
                .catch(error => console.log(error));
        }
    }
}
</script>

