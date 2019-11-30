<template>
    <div class="kt-grid kt-grid--ver kt-grid--root">
        <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v3 kt-login--signin" id="kt_login">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" :style="`background-image: url('${loginbg}');`">
                <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
                    <div class="kt-login__container">
                        <div class="kt-login__logo">

                        </div>
                        <div class="kt-login__signin">
                            <div class="kt-login__head">
                                <h3 class="kt-login__title">Sign In To Admin</h3>
                            </div>
                            <form class="kt-form" autocomplete="off" @submit.prevent="authenticate">
                                <div v-if="authError" class="kt-alert kt-alert--outline alert alert-danger alert-dismissible" role="alert">                                
                                    <span>{{ authError.message }}</span>
                                </div>
                                <div class="input-group">
                                    <input v-model="form.email" class="form-control" type="email" name="email" placeholder="Email">
                                </div>
                                <div class="input-group">
                                    <input v-model="form.password" class="form-control" type="password" placeholder="Password" name="password">
                                </div>
                                <div class="kt-login__actions">
                                    <button
                                        id="kt_login_signin_submit"
                                        class="btn btn-brand btn-elevate kt-login__btn-primary"
                                        :class="{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : loading }"
                                        :disabled="loading"
                                        type="submit"
                                    >
                                        Sign In
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
import { login } from '../services/auth'
import loginbg from '../../images/auth-bg.jpg'

export default {
    name: 'Login',
    data() {
        return {
            loginbg: loginbg,
            form: {
                email: '',
                password: ''
            }
        }
    },
    computed: {
        loading() {
            return this.$store.getters['auth/loading']
        },
        authError() {
            return this.$store.getters['auth/authError']
        }
    },
    methods: {
        authenticate() {
            this.$store.dispatch('auth/login')

            login(this.form)
                .then(response => {
                    this.$store.commit('auth/LOGIN_SUCCESS', response)
                    this.$router.push({ path: '/' })
                })
                .catch(error => this.$store.commit('auth/LOGIN_FAILED', error))
        }
    }
}
</script>

