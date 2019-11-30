import { getLocalUser } from '../../services/auth'
import axios from 'axios';

const currentUser = getLocalUser()

if (!currentUser) {
    axios.defaults.headers.common['Authorization'] = null
} else {
    axios.defaults.headers.common['Authorization'] = `Bearer ${currentUser.token}`
}

export default {
    namespaced: true,
    state: {
        currentUser: currentUser,
        isLoggedin: !!currentUser,
        loading: false,
        authError: null
    },

    mutations: {
        LOGIN(state) {
            state.loading = true
            state.authError = null
        },
        LOGIN_SUCCESS(state, payload) {
            state.authError = null
            state.isLoggedin = true
            state.loading = false
            state.currentUser = Object.assign({}, payload.user, { token: payload.access_token })

            localStorage.setItem('user', JSON.stringify(state.currentUser))

            axios.defaults.headers.common['Authorization'] = `Bearer ${payload.access_token}`
        },
        UPDATE_USER(state, payload) {
            state.currentUser = { ...state.currentUser, ...payload.data }

            localStorage.setItem('user', JSON.stringify(state.currentUser))
        },
        LOGIN_FAILED(state, payload) {
            state.loading = false
            state.authError = payload
        },
        LOGOUT(state) {
            state.isLoggedin = false
            state.currentUser = null

            localStorage.removeItem('user')

            axios.defaults.headers.common['Authorization'] = null
        }
    },

    actions: {
        login(context) {
            context.commit('LOGIN')
        },
    },

    getters: {
        currentUser(state) {
            return state.currentUser
        },
        isLoggedin(state) {
            return state.isLoggedin
        },
        loading(state) {
            return state.loading
        },
        authError(state) {
            return state.authError
        }
    }
}