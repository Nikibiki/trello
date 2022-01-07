require('./bootstrap');

import Vue from 'vue';
import Router from 'vue-router'
import Vuelidate from 'vuelidate'

Vue.use(Router)
Vue.use(Vuelidate)

import App from './components/App'
import Home from './components/Home'
import Desks from './components/desks/Desks'
import Desk from './components/desks/Desk'

const router = new Router({
    mode: 'history',
    routes: [
        {
            name: 'home',
            path: '/',
            component: Home
        },
        {
            name: 'desks',
            path: '/desks',
            component: Desks
        },
        {
            name: 'showDesk',
            path: '/desks/:deskId',
            component: Desk,
            props: true
        },
    ]
})

const app = new Vue({
    el: '#app',
    router,
    components: {
        App,
    }
})
