export default {
    namespaced: true,
    state: {
        loading: false,
        leadError: null,
        leadUser: null,
        userFound: false,
        userUpdated: false
    },

    mutations: {
        CHECK_LEAD(state) {
            state.loading = true
            state.leadError = null
            state.userFound = false
            state.userUpdated = null
        },
        UNSUB(state) {
            state.loading = true
            state.leadError = null
            state.userFound = false
            state.userUpdated = null
        },
        USER_FOUND(state, payload) {
            state.loading = false
            state.userFound = true
            state.leadUser = Object.assign({}, payload)
        },
        USER_ERROR(state, payload) {
            state.userFound = false
            state.loading = false  
            state.leadError = payload
        },
        USER_UPDATED(state, payload) {
            state.userFound = false
            state.loading = false
            state.userUpdated = payload
            state.leadError = null
        }
    },

    actions: {
        checkleads(context) {
            context.commit('CHECK_LEAD')
        },
        unsub(context) {
            context.commit('UNSUB')
        }
    },

    getters: {
        loading(state) {
            return state.loading
        },
        leadError(state) {
            return state.leadError
        },
        userFound(state) {
            return state.userFound
        },
        updateSuccess(state) {
            return state.userUpdated
        }
    }
}