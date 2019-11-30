<template>
    <div class="kt-grid kt-grid--ver kt-grid--root">
        <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v3 kt-login--signin" id="kt_login">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" :style="`background-image: url('${unsubbg}');`">
                <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
                    <div class="kt-login__container">
                        <div class="kt-login__logo">
                            <a href="#">
                                <img class="img-fluid" src="../../images/logo.png">
                            </a>
                        </div>
                        <div class="kt-login__signin">
                            <div class="kt-login__head">
                                <h3 class="kt-login__title">Unsubscribe to Guestquest</h3>
                            </div>
                            <form class="kt-form" autocomplete="off" @submit.prevent="unsubscribeLead">
                                <div v-if="leadError" class="kt-alert kt-alert--outline alert alert-danger alert-dismissible" role="alert">                                
                                    <span>{{ leadError.message }}</span>
                                </div>
                                <div v-if="userUpdated" class="kt-alert kt-alert--outline alert alert-success alert-dismissible" role="alert">                                
                                    <span>{{ userUpdated.message }}</span>
                                </div>
                                <div v-if="!userFound" class="input-group">
                                    <input id="email-form" v-model="form.email" class="form-control" type="email" name="email" placeholder="Email">
                                </div>
                                <div v-else-if="userFound" class="input-group">
                                    <p>Unsubscribing will make you miss our latest promotions and updates, do you wish to proceed?</p>
                                    <input type="hidden" name="user_id" v-model="form.user_id">
                                </div>
                                <div class="kt-login__actions">
                                    <button
                                        id="kt_login_signin_submit"
                                        class="btn btn-brand btn-elevate kt-login__btn-primary"
                                        :class="{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : loading }"
                                        :disabled="loading"
                                        type="submit"
                                    >
                                        Proceed
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { checkleads, unsub } from '../services/leads'
import unsubbg from '../../images/auth-bg.jpg'

export default {
    name: 'Login',
    data() {
        return {
            unsubbg: unsubbg,
            form: {
                email: '',
                user_id: ''
            },
        }
    },
    mounted() {
        this.populateEmail()
    },
    computed: {
        loading() {
            return this.$store.getters['leads/loading']
        },
        leadError() {
            return this.$store.getters['leads/leadError']
        },
        userFound() {
            return this.$store.getters['leads/userFound']
        },
        userUpdated() {
            return this.$store.getters['leads/updateSuccess']
        }
    },
    methods: {
        populateEmail() {
            var url_string = window.location.href
            var url = new URL(url_string)
            var userEmail = url.searchParams.get("email")
            this.form.email = userEmail
        },
        unsubscribeLead() {
            if(!this.userfound) {
                this.$store.dispatch('leads/checkleads')

            checkleads(this.form)
                .then(response => {
                    this.$store.commit('leads/USER_FOUND', response)
                    this.userfound = true
                    this.form.user_id = response.data[0].id
                })
                .catch(error => this.$store.commit('leads/USER_ERROR', error)) 
            }
            
            else {
                this.$store.dispatch('leads/unsub')

                unsub(this.form)
                .then(response => {
                    this.$store.commit('leads/USER_UPDATED', response)
                })
                .catch(error => this.$store.commit('leads/USER_ERROR', error)) 
            }
        }
    }
}
</script>