import { createRouter, createWebHistory } from 'vue-router'
import Home from '../components/Home.vue'
import Login from '../components/Auth/Login.vue'
import Register from '../components/Auth/Register.vue'
import UserAccount from '../components/Users/Account.vue'
import ArticlesIndex from '../components/Articles/Index.vue'
import ArticleView from '../components/Articles/View.vue'
import ArticleCreate from '../components/Articles/Create.vue'
import ArticleEdit from '../components/Articles/Edit.vue'
import TagsIndex from '../components/Tags/Index.vue'
import TagEdit from '../components/Tags/Edit.vue'

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
    {
        path: '/manage-account',
        name: 'users.account',
        beforeEnter: auth,
        component: UserAccount
    },
    {
        path: '/articles',
        name: 'articles.index',
        component: ArticlesIndex
    },
    {
        path: '/articles/new',
        name: 'article.create',
        component: ArticleCreate
    },
    {
        path: '/articles/:slug',
        name: 'article.view',
        component: ArticleView
    },
    {
        path: '/articles/:slug/edit',
        name: 'article.edit',
        component: ArticleEdit
    },
    {
        path: '/tags',
        name: 'tags.index',
        component: TagsIndex,
    },
    {
        path: '/tags/:name',
        name: 'tag.edit',
        component: TagEdit,
    },
    // {
    //     path: '/tags/:name/articles',
    //     name: 'tag.articles',
    //     component: TagArticles,
    // },
]

export default createRouter({
    history: createWebHistory(),
    routes,
})