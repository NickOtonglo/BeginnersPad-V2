import { createRouter, createWebHistory } from 'vue-router'
import PageNotFound from '../components/Misc/PageNotFound.vue'
import Home from '../components/Home.vue'
import Login from '../components/Auth/Login.vue'
import Register from '../components/Auth/Register.vue'
import UserAccount from '../components/Users/Account.vue'
import ArticlesIndex from '../components/Articles/Index.vue'
import ArticleView from '../components/Articles/View.vue'
import ArticleCreate from '../components/Articles/Create.vue'
import ArticleEdit from '../components/Articles/Edit.vue'
import TagsIndex from '../components/Tags/Index.vue'
// import TagEdit from '../components/Tags/Edit.vue'
import TagArticles from '../components/Tags/Articles.vue'
import ZonesIndex from '../components/Zones/Index.vue'
import ZoneView from '../components/Zones/View.vue'
import SubZoneView from '../components/SubZones/View.vue'
import PropertiesIndex from '../components/Properties/Index.vue'
import PropertiesMine from '../components/Properties/MyProperties.vue'
import PropertyManage from '../components/Properties/Manage.vue'
import PropertyView from '../components/Properties/View.vue'
import PropertyUnitManage from '../components/PropertyUnits/Manage.vue'
import PropertyUnitView from '../components/PropertyUnits/View.vue'
import PropertyReviewsIndex from '../components/PropertyReviews/Index.vue'
import PropertyReviewsMine from '../components/PropertyReviews/MyReviews.vue'
import PropertyReviewsView from '../components/PropertyReviews/View.vue'
import UserFavouritesIndex from '../components/Favourites/Index.vue'
import HelpIndex from '../components/Help/Index.vue'
import HelpFAQ from '../components/FAQ/Index.vue'
import TicketView from '../components/HelpTickets/View.vue'

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
        path: '/404',
        name: 'app.404',
        component: PageNotFound
    },
    {
        path: '/:catchAll(.*)',
        redirect: '/404'
    },
    //
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
        path: '/tags/:name/articles',
        name: 'tag.articles',
        component: TagArticles,
    },
    {
        path: '/zones',
        name: 'zones.index',
        component: ZonesIndex,
    },
    {
        path: '/zones/:id',
        name: 'zone.view',
        component: ZoneView,
    },
    {
        path: '/zones/:zone_id/sub-zones/:sub_id',
        name: 'sub-zone.view',
        component: SubZoneView,
    },
    {
        path: '/listings',
        name: 'properties.index',
        component: PropertiesIndex,
    },
    {
        path: '/listings/my-listings',
        name: 'properties.mine',
        component: PropertiesMine,
    },
    {
        path: '/listings/my-listings/:slug',
        name: 'property.manage',
        component: PropertyManage,
    },
    {
        path: '/listings/:slug',
        name: 'property.view',
        component: PropertyView,
    },
    {
        path: '/listings/my-listings/:slug/:unit_slug',
        name: 'unit.manage',
        component: PropertyUnitManage,
    },
    {
        path: '/listings/:slug/:unit_slug',
        name: 'unit.view',
        component: PropertyUnitView,
    },
    {
        path: '/listings/:slug/reviews',
        name: 'reviews.index',
        component: PropertyReviewsIndex
    },
    {
        path: '/reviews',
        name: 'reviews.mine',
        component: PropertyReviewsMine
    },
    {
        path: '/reviews/:slug',
        name: 'review.view',
        component: PropertyReviewsView
    },
    {
        path: '/favourites',
        name: 'favourites.index',
        component: UserFavouritesIndex
    },
    {
        path: '/help',
        name: 'help.index',
        component: HelpIndex
    },
    {
        path: '/help/faq',
        name: 'help.faq',
        component: HelpFAQ
    },
    {
        path: '/help/tickets/:id',
        name: 'ticket.view',
        component: TicketView
    },
]

export default createRouter({
    history: createWebHistory(),
    routes,
})