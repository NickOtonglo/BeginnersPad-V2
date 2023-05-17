import { createRouter, createWebHistory } from 'vue-router'
import App from '../components/App.vue'
import Login from '../components/Auth/Login.vue'
import Register from '../components/Auth/Register.vue'

const routes = [
    {
        path: '/',
        name: 'app.index',
        component: App
    },
    {
        path: '/sign-up',
        name: 'auth.register',
        component: Register
    },
    {
        path: '/sign-in',
        name: 'auth.login',
        component: Login
    },
]

export default createRouter({
    history: createWebHistory(),
    routes,
})