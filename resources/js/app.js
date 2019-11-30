require('./bootstrap')

import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'
import { routes } from './routes'
import StoreData from './store/index'
import { initialize } from './helpers/general'
import MainApp from './Main'

Vue.use(VueRouter)
Vue.use(Vuex)

Vue.prototype.$http = window.axios

const store  = new Vuex.Store(StoreData)
const router = new VueRouter({
    mode: 'history',
    routes
})

initialize(store, router)

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        MainApp
    }
});
