import { createRouter, createWebHistory } from 'vue-router'
import Home from '../components/Home.vue'
import Login from '../components/Auth/Login.vue'
import Register from '../components/Auth/Register.vue'

function auth(to, from, next) {
    if (JSON.parse(localStorage.getItem('authenticated'))) {
        next()
    }
    else next('/sign-in')
}

function checkLoginGuest(to, from, next) {
    if (JSON.parse(localStorage.getItem('authenticated'))) {
        next('/')
    }
    else next()
}

const routes = [
    {
        path: '/',
        name: 'app.home',
        component: Home
    },
    {
        path: '/sign-up',
        name: 'auth.register',
        component: Register
    },
    {
        path: '/sign-in',
        name: 'auth.login',
        beforeEnter: checkLoginGuest,
        component: Login
    },
]

export default createRouter({
    history: createWebHistory(),
    routes,
})