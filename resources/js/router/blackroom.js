import Vue from 'vue'
import VueRouter from 'vue-router'
import login from '../components/blackroom/login'
import admin from '../components/blackroom/admin'
import general from '../components/blackroom/general'
import users from '../components/blackroom/users'
import spots from '../components/blackroom/spots'
import products from '../components/blackroom/products'
import commandes from '../components/blackroom/commandes'


Vue.use(VueRouter)

const routes = [
    {
        path: '/blackroom',
        name: 'login',
        component: login
    },
    {
        path: '/blackroom',
        name: 'admin',
        component: admin,
        children: [
            {
                path: 'general',
                name: 'general',
                component: general
            },
            {
                path: 'users',
                name: 'users',
                component: users
            },
            {
                path: 'spots',
                name: 'spots',
                component: spots
            },
            {
                path: 'spots/:id',
                name: 'spotsEdit',
                component: spots
            },
            {
                path: 'products',
                name: 'products',
                component: products
            },
            {
                path: 'commandes',
                name: 'commandes',
                component: commandes
            },
        ]
    },

]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

export default router
