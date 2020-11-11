import Vue from 'vue'
import VueRouter from 'vue-router'
import login from '../components/customers/login.vue'
import welcome from '../components/customers/welcome.vue'
import products from '../components/customers/products.vue'
import orders from '../components/customers/orders.vue'
import cart from '../components/customers/cart.vue'
import general from "../components/customers/general";

Vue.use(VueRouter)

const routes = [
    {
        path: '/customers',
        name: 'login',
        component: login
    },
    {
        path: '/customers',
        name: 'welcome',
        component: welcome,
        children: [
            {
                path: 'general',
                name: 'general',
                component: general
            },
            {
                path: 'products',
                name: 'products',
                component: products
            },
            {
                path: 'orders',
                name: 'orders',
                component: orders
            },
            {
                path: 'cart',
                name: 'cart',
                component: cart
            },
        ],
    }

]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

export default router
