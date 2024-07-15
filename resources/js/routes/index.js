import { createRouter, createWebHistory } from 'vue-router'
import PageNotFound from '../components/Misc/PageNotFound.vue'
import Home from '../components/Home.vue'
import Login from '../components/Auth/Login.vue'
import Register from '../components/Auth/Register.vue'
import UserAccount from '../components/Users/Account.vue'
import UserNotifications from '../components/Users/Notifications.vue'
import ArticlesIndex from '../components/Articles/Index.vue'
import ArticlesMine from '../components/Articles/MyArticles.vue'
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
import PropertiesLogs from '../components/Properties/LogsAll.vue'
import PropertyManage from '../components/Properties/Manage.vue'
import PropertyView from '../components/Properties/View.vue'
import PropertyLogs from '../components/Properties/Logs.vue'
import PropertyUnitManage from '../components/PropertyUnits/Manage.vue'
import PropertyUnitView from '../components/PropertyUnits/View.vue'
import PropertyReviewsIndex from '../components/PropertyReviews/Index.vue'
import PropertyReviewsMine from '../components/PropertyReviews/MyReviews.vue'
import PropertyReviewsView from '../components/PropertyReviews/View.vue'
import PropertyReviewsLogs from '../components/PropertyReviews/Logs.vue'
import UserFavouritesIndex from '../components/Favourites/Index.vue'
import HelpIndex from '../components/Help/Index.vue'
import HelpFAQ from '../components/FAQ/Index.vue'
import TicketsList from '../components/HelpTickets/List.vue'
import TicketView from '../components/HelpTickets/View.vue'
import UsersIndex from '../components/Users/Index.vue'
import UsersLogs from '../components/Users/Logs.vue'
import UserManage from '../components/Users/Manage.vue'
import ChatsIndex from '../components/Chats/Index.vue'
import ChatView from '../components/Chats/View.vue'
import WaitingListIndex from '../components/WaitingList/Index.vue'
import { component } from 'v-viewer'

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
function checkAdminView(to, from, next) {
    if (!
        (JSON.parse(localStorage.getItem('role')) == 3 || 
        JSON.parse(localStorage.getItem('role')) == 2 || 
        JSON.parse(localStorage.getItem('role')) == 1)
    ) {
        next('/404')
    }
    else next()
}
function checkListerView(to, from, next) {
    if (!
        (JSON.parse(localStorage.getItem('role')) == 4)
    ) {
        next('/404')
    }
    else next()
}
function checkBeginnerView(to, from, next) {
    if (!
        (JSON.parse(localStorage.getItem('role')) == 5)
    ) {
        next('/404')
    }
    else next()
}
function checkAdminListerView(to, from, next) {
    if (!
        (JSON.parse(localStorage.getItem('role')) == 3 || 
        JSON.parse(localStorage.getItem('role')) == 2 || 
        JSON.parse(localStorage.getItem('role')) == 1 || 
        JSON.parse(localStorage.getItem('role')) == 4)
    ) {
        next('/404')
    }
    else next()
}
function checkAdminBeginnerView(to, from, next) {
    if (!
        (JSON.parse(localStorage.getItem('role')) == 3 || 
        JSON.parse(localStorage.getItem('role')) == 2 || 
        JSON.parse(localStorage.getItem('role')) == 1 || 
        JSON.parse(localStorage.getItem('role')) == 5)
    ) {
        next('/404')
    }
    else next()
}
function checkListerBeginnerView(to, from, next) {
    if (!
        (JSON.parse(localStorage.getItem('role')) == 4 || 
        JSON.parse(localStorage.getItem('role')) == 5)
    ) {
        next('/404')
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
        path: '/notifications',
        name: 'user.notifications',
        component: UserNotifications
    },
    {
        path: '/articles',
        name: 'articles.index',
        component: ArticlesIndex
    },
    {
        path: '/help/tickets',
        name: 'tickets.list',
        component: TicketsList
    },
    {
        path: '/articles/:slug',
        name: 'article.view',
        component: ArticleView
    },
    {
        path: '/articles/tags/:name',
        name: 'tag.articles',
        component: ArticlesIndex,
    },
    {
        path: '/listings',
        name: 'properties.index',
        component: PropertiesIndex,
    },
    {
        path: '/listings/:slug',
        name: 'property.view',
        component: PropertyView,
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
    {
        path: '/chats',
        name: 'chats.index',
        component: ChatsIndex,
    },
    {
        path: '/chats/:id',
        name: 'chat.view',
        component: ChatView,
    },

    {
        beforeEnter: checkAdminView,
        children: [
            {
                path: '/articles/my-articles/manage',
                name: 'articles.mine',
                component: ArticlesMine
            },
            {
                path: '/articles/new',
                name: 'article.create',
                component: ArticleCreate
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
                path: '/listings/logs',
                name: 'properties.logs',
                component: PropertiesLogs,
            },
            {
                path: '/reviews/listings/logs',
                name: 'reviews.logs',
                component: PropertyReviewsLogs
            },
            {
                path: '/users',
                name: 'users.index',
                component: UsersIndex
            },
            {
                path: '/users/logs',
                name: 'users.logs',
                component: UsersLogs
            },
            {
                path: '/users/profile/:username',
                name: 'user.manage',
                component: UserManage
            },
        ]
    },
    {
        beforeEnter: checkListerView,
        children: [
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
                path: '/listings/my-listings/:slug/:unit_slug',
                name: 'unit.manage',
                component: PropertyUnitManage,
            },
        ]
    },
    {
        beforeEnter: checkBeginnerView,
        children: [
            {
                path: '/reviews',
                name: 'reviews.mine',
                component: PropertyReviewsMine
            },
            {
                path: '/premium/waiting-list',
                name: 'waiting-list.index',
                component: WaitingListIndex,
            }
        ]
    },
    {
        beforeEnter: checkAdminListerView,
        children: [
            {
                path: '/listings/:slug/logs',
                name: 'property.logs',
                component: PropertyLogs,
            },
        ]
    },
    {
        beforeEnter: checkAdminBeginnerView,
        children: [

        ]
    },
    {
        beforeEnter: checkListerBeginnerView,
        children: [

        ]
    },
]

export default createRouter({
    history: createWebHistory(),
    routes,
})