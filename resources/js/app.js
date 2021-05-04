import VueRouter from 'vue-router'
window.Vue = require('vue');
Vue.use(require('vue-resource'));
Vue.component('pagination', require('laravel-vue-pagination'));
import 'bootstrap';
import App from './views/App'
import Dashboard from './views/admin/Board'
import Login from './views/auth/Login'
import Register from './views/auth/Register'
import Home from './views/MainPage'
import Post from './views/admin/Posts/Post'
import PostDetails from './views/post/PostDetails'
import PostCreate from './views/admin/Posts/PostCreate'
import PostEdit from './views/admin/Posts/PostEdit'
import Category from './views/admin/Category/Category'
import CategoryCreate from './views/admin/Category/CategoryCreate'
import CategoryEdit from './views/admin/Category/CategoryEdit'
import User from './views/admin/User/User'
import UserCreate from './views/admin/User/UserCreate'
import UserEdit from './views/admin/User/UserEdit'
import StaticSite from './views/admin/Static/StaticSite'
import StaticSiteCreate from './views/admin/Static/StaticSiteCreate'
import StaticSiteEdit from './views/admin/Static/StaticSiteEdit'
import ContactForm from './views/contact/ContactForm'
import Message from './views/admin/Message'
import CategoryDetails from './views/Category'
import EventDetails from './views/event/EventDetails'
import AboutUs from './views/static/AboutUs'
import Search from './views/search/Search'
import SearchHelp from '@components/SearchHelp'
import Data from './views/user/Data'
import UserProfile from './views/User'
import FavoritePost from './views/user/FavoritePost'
import FavoriteUser from './views/user/FavoriteUser'
import UserPost from './views/user/post/Post'
import UserPostEdit from './views/user/post/PostEdit'
import UserEvent from './views/user/event/Event'
import UserEventEdit from './views/user/event/EventEdit'
import EventMember from './views/user/EventMember'
import EventList from '@views/event/EventList'
import ChatComponent from './views/chat/ChatComponent'
Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: [{
            path: '/',
            name: 'home',
            component: Home
        },


        // <!-- AUTH
        {
            path: '/login',
            name: 'login',
            component: Login,
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
        },
        // AUTH -->


        // <!-- ADMIN
        {
            path: '/admin/board',
            name: 'board',
            component: Dashboard,
        },
        {
            path: '/admin/posts/create',
            name: 'admin-posts-create',
            component: PostCreate,
        },
        {
            path: '/admin/categories',
            name: 'admin-categories',
            component: Category,
        },
        {
            path: '/admin/categories/create',
            name: 'admin-categories-create',
            component: CategoryCreate,
        },
        {
            path: '/admin/categories/:id/edit',
            name: 'admin-categories-edit',
            component: CategoryEdit,
        },
        {
            path: '/admin/users',
            name: 'admin-users',
            component: User,
        },
        {
            path: '/admin/users/create',
            name: 'admin-users-create',
            component: UserCreate,
        },
        {
            path: '/admin/users/:id/edit',
            name: 'admin-users-edit',
            component: UserEdit,
        },
        {
            path: '/admin/static-sites',
            name: 'admin-static-sites',
            component: StaticSite,
        },
        {
            path: '/admin/static-sites/create',
            name: 'admin-static-sites-create',
            component: StaticSiteCreate,
        },
        {
            path: '/admin/static-sites/:id/edit',
            name: 'admin-static-sites-edit',
            component: StaticSiteEdit,
        },
        {
            path: '/admin/messages',
            name: 'admin-messages',
            component: Message,
        },

        // ADMIN -->

        // <!-- STRONY STATYCZNE

        {
            path: '/kontakt',
            name: 'form-contact',
            component: ContactForm,
        },
        {
            path: '/o-nas',
            name: 'about-us',
            component: AboutUs,
        },

        // STRONY STATYCZNE -->

        // SZUKAJKA -->

        {
            path: '/search/:search',
            name: 'search',
            component: Search,
        },
        {
            path: '/search-hints/:search',
            name: 'searchhints',
            component: SearchHelp,
        },

        // SZUKAJKA -->

        // <!-- PANEL UZYTKOWNIKA
        {
            path: '/user/data',
            name: 'user-data',
            component: Data,
        },

        {
            path: '/user/favorite-post',
            name: 'favorite-post',
            component: FavoritePost
        },
        {
            path: '/user/favorite-user',
            name: 'favorite-user',
            component: FavoriteUser
        },

        {
            path: '/user/event-member',
            name: 'user-event-member',
            component: EventMember
        },

        {
            path: '/user/posts',
            name: 'user-posts',
            component: UserPost,
        },

        {
            path: '/user/posts/:id/edit',
            name: 'user-posts-edit',
            component: UserPostEdit,
        },

        {
            path: '/user/events',
            name: 'user-events',
            component: UserEvent,
        },

        {
            path: '/user/events/:id/edit',
            name: 'user-events-edit',
            component: UserEventEdit,
        },

        // PANEL UZYTKOWNIKA -->


        {
            path: '/category/:id/:name',
            name: 'category-details',
            component: CategoryDetails,
        },
        {
            path: '/post/:id-:title',
            name: 'post-details',
            component: PostDetails
        },
        {
            path: '/event/:id-:title',
            name: 'event-details',
            component: EventDetails
        },
        {
            path: '/user/:id',
            name: 'user-profile',
            component: UserProfile
        },
        {
            path: '/events',
            name: 'events',
            component: EventList
        },

        {
            path: '/chat',
            name: 'chat',
            component: ChatComponent
        },

        {
            path: 'messages',
            name: 'messages'
        },

        {
            path: 'send-message',
            name: 'send-message'
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    comments: false,
    router,
});
