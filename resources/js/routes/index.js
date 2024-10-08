import { createRouter, createWebHistory } from 'vue-router'
import PageNotFound from '../components/Misc/PageNotFound.vue'
import Home from '../components/Home.vue'
import About from '../components/Docs/About.vue'
import PrivacyPolicy from '../components/Docs/PrivacyPolicy.vue'
import Terms from '../components/Docs/Terms.vue'
import Login from '../components/Auth/Login.vue'
import Register from '../components/Auth/Register.vue'
import ForgotPassword from '../components/Auth/ForgotPassword.vue'
import ResetPassword from '../components/Auth/ResetPassword.vue'
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
import Dashboard from '../components/Dashboard/Index.vue'
import SystemIndex from '../components/System/Index.vue'
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
function checkSystemAdminView(to, from, next) {
    if (!
        (JSON.parse(localStorage.getItem('role')) == 1)
    ) {
        next('/404')
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
        component: Home,
        meta: {
            name: 'Home'
        }
    },
    {
        path: '/about',
        name: 'app.about',
        component: About,
        meta: {
            name: 'About'
        }
    },
    {
        path: '/privacy-policy',
        name: 'app.privacy',
        component: PrivacyPolicy,
        meta: {
            name: 'Privacy Policy'
        }
    },
    {
        path: '/terms-of-service',
        name: 'app.terms',
        component: Terms,
        meta: {
            name: 'Terms of Service'
        }
    },
    {
        path: '/sign-up',
        name: 'auth.register',
        component: Register,
        meta: {
            name: 'Sign up'
        }
    },
    {
        path: '/sign-in',
        name: 'auth.login',
        beforeEnter: checkLoginGuest,
        component: Login,
        meta: {
            name: 'Sign in'
        }
    },
    {
        path: '/forgot-password',
        name: 'auth.forgot',
        beforeEnter: checkLoginGuest,
        component: ForgotPassword,
        meta: {
            name: 'Forgot password'
        }
    },
    {
        path: '/reset-password/:token',
        name: 'auth.reset',
        beforeEnter: checkLoginGuest,
        component: ResetPassword,
        meta: {
            name: 'Reset password'
        }
    },
    {
        path: '/manage-account',
        name: 'users.account',
        beforeEnter: auth,
        component: UserAccount,
        meta: {
            name: 'Account'
        }
    },
    {
        path: '/notifications',
        name: 'user.notifications',
        component: UserNotifications,
        meta: {
            name: 'Notifications'
        }
    },
    {
        path: '/articles',
        name: 'articles.index',
        component: ArticlesIndex,
        meta: {
            name: 'Articles'
        }
    },
    {
        path: '/help/tickets',
        name: 'tickets.list',
        component: TicketsList,
        meta: {
            name: 'Tickets'
        }
    },
    {
        path: '/articles/:slug',
        name: 'article.view',
        component: ArticleView,
        meta: {
            name: 'View article'
        }
    },
    {
        path: '/articles/tags/:name',
        name: 'tag.articles',
        component: ArticlesIndex,
        meta: {
            name: 'Articles'
        }
    },
    {
        path: '/listings',
        name: 'properties.index',
        component: PropertiesIndex,
        meta: {
            name: 'Listings'
        }
    },
    {
        path: '/listings/:slug',
        name: 'property.view',
        component: PropertyView,
        meta: {
            name: 'View listing'
        }
    },
    {
        path: '/listings/:slug/:unit_slug',
        name: 'unit.view',
        component: PropertyUnitView,
        meta: {
            name: 'View unit'
        }
    },
    {
        path: '/listings/:slug/reviews',
        name: 'reviews.index',
        component: PropertyReviewsIndex,
        meta: {
            name: 'Reviews'
        }
    },
    
    {
        path: '/reviews/:slug',
        name: 'review.view',
        component: PropertyReviewsView,
        meta: {
            name: 'View review'
        }
    },
    {
        path: '/favourites',
        name: 'favourites.index',
        component: UserFavouritesIndex,
        meta: {
            name: 'Favourites'
        }
    },
    {
        path: '/help',
        name: 'help.index',
        component: HelpIndex,
        meta: {
            name: 'Help'
        }
    },
    {
        path: '/help/faq',
        name: 'help.faq',
        component: HelpFAQ,
        meta: {
            name: 'Help FAQs'
        }
    },
    {
        path: '/help/tickets/:id',
        name: 'ticket.view',
        component: TicketView,
        meta: {
            name: 'View ticket'
        }
    },
    {
        path: '/chats',
        name: 'chats.index',
        component: ChatsIndex,
        meta: {
            name: 'Chats'
        }
    },
    {
        path: '/chats/:id',
        name: 'chat.view',
        component: ChatView,
        meta: {
            name: 'View chat'
        }
    },
    {
        path: '/dashboard',
        name: 'dashboard.index',
        component: Dashboard,
        meta: {
            name: 'Dashboard'
        }
    },

    {
        beforeEnter: checkSystemAdminView,
        children: [
            {
                path: '/system',
                name: 'system.index',
                component: SystemIndex,
                meta: {
                    name: 'System'
                }
            },
        ]
    },

    {
        beforeEnter: checkAdminView,
        children: [
            {
                path: '/articles/my-articles/manage',
                name: 'articles.mine',
                component: ArticlesMine,
                meta: {
                    name: 'My articles'
                }
            },
            {
                path: '/articles/new',
                name: 'article.create',
                component: ArticleCreate,
                meta: {
                    name: 'Create article'
                }
            },
            {
                path: '/articles/:slug/edit',
                name: 'article.edit',
                component: ArticleEdit,
                meta: {
                    name: 'Update article'
                }
            },
            {
                path: '/tags',
                name: 'tags.index',
                component: TagsIndex,
                meta: {
                    name: 'Tags'
                }
            },
            {
                path: '/zones',
                name: 'zones.index',
                component: ZonesIndex,
                meta: {
                    name: 'Zones'
                }
            },
            {
                path: '/zones/:id',
                name: 'zone.view',
                component: ZoneView,
                meta: {
                    name: 'View zone'
                }
            },
            {
                path: '/zones/:zone_id/sub-zones/:sub_id',
                name: 'sub-zone.view',
                component: SubZoneView,
                meta: {
                    name: 'View sub-zone'
                }
            },
            {
                path: '/listings/logs',
                name: 'properties.logs',
                component: PropertiesLogs,
                meta: {
                    name: 'Listings logs'
                }
            },
            {
                path: '/reviews/listings/logs',
                name: 'reviews.logs',
                component: PropertyReviewsLogs,
                meta: {
                    name: 'Review logs'
                }
            },
            {
                path: '/users',
                name: 'users.index',
                component: UsersIndex,
                meta: {
                    name: 'Users'
                }
            },
            {
                path: '/users/logs',
                name: 'users.logs',
                component: UsersLogs,
                meta: {
                    name: 'User logs'
                }
            },
            {
                path: '/users/profile/:username',
                name: 'user.manage',
                component: UserManage,
                meta: {
                    name: 'Manage user'
                }
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
                meta: {
                    name: 'My listings'
                }
            },
            {
                path: '/listings/my-listings/:slug',
                name: 'property.manage',
                component: PropertyManage,
                meta: {
                    name: 'Manage listing'
                }
            },
            {
                path: '/listings/my-listings/:slug/:unit_slug',
                name: 'unit.manage',
                component: PropertyUnitManage,
                meta: {
                    name: 'Manage unit'
                }
            },
        ]
    },
    {
        beforeEnter: checkBeginnerView,
        children: [
            {
                path: '/reviews',
                name: 'reviews.mine',
                component: PropertyReviewsMine,
                meta: {
                    name: 'My reviews'
                }
            },
            {
                path: '/premium/waiting-list',
                name: 'waiting-list.index',
                component: WaitingListIndex,
                meta: {
                    name: 'Waiting list'
                }
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
                meta: {
                    name: 'Listing logs'
                }
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