import Vue from 'vue'
import Vuex from 'vuex'
import router from '../router/customers'
import axios from "axios";


Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        errors: [],
        status: [],
        userData: null,
        authToken: null,
        products: [],
        cart: [],
        orders: [],
        orp: [],
        snack: {color: "success", text: "no text", status: false}
    },
    getters: {
        products: state => state.products,
        orders: state => state.orders,
        CartItemCount: state => state.cart.length,

        cartTotalPrice(state) {
            let total = 0;
            state.cart.forEach(item => {
                total += item.product.vSal_Base * item.quantity;
            })
            return total;
        },
    },
    mutations: {
        ADD_TO_CART(state, {product, quantity}) {
            let productInCart = state.cart.find(item => {
                return item.product.id === product.id;
            });
            if (productInCart) {
                productInCart.quantity += quantity;
                return;
            }
            state.cart.push({product, quantity});
        },
        REMOVE_PRODUCT_FROM_CART(state, product) {
            state.cart = state.cart.filter(item => {
                return item.product.id !== product.id;
            })
        },
        REMOVE_ALL_FROM_CART(state) {
            state.cart = [];
        },
        snackMessage(state, payload) {
            state.snack = payload;
        },
        setErrors(state, errors) {
            state.errors = errors;
        },
        setUserData(state, payload) {
            state.userData = payload;
        },
        setToken(state, payload) {
            state.authToken = payload;
        },
        killToken(state, payload) {
            state.authToken = null;
        },
        logOut(state) {
            state.userData = null;
            state.authToken = null;
        },
        setProductsData(state, payload) {
            state.products = payload;
        },
        setOrdersData(state, payload) {
            state.orders = payload;
        },
        setStatusData(state, payload) {
            state.status = payload;
        },
        setOrdersProductsData(state, payload) {
            state.orp = payload;
        },
    },
    actions: {
        addToCart({commit}, {product, quantity}) {
            commit("ADD_TO_CART", {product, quantity});
        },
        removeProductFromCart({commit}, product) {
            commit("REMOVE_PRODUCT_FROM_CART", product);
        },
        removeAllFromCart({commit}) {
            commit("REMOVE_ALL_FROM_CART");
            // context.commit("snackMessage", {color:"success", text:"Votre panier est vide", status: true});

        },
        setProducts({commit}, payload) {
            commit("setProductsData", payload);
        },
        setOrders({commit}, payload) {
            commit("setOrdersData", payload);
        },
        setStatus({commit}, payload) {
            commit("setStatusData", payload);
        },
        addOrder({commit}, payload) {
            axios.post(window.location.origin + "/api/orders", payload)
                .then(response => {
                    commit("setOrdersData", response.data);
                    commit("snackMessage", {color: "success", text: "Commande validée", status: true});
                    setTimeout( () => router.push({ name: "orders"}), 5000);
                }).catch(error => {
            });
        },
        loginUser({commit}, payload) {

            axios.post(window.location.origin + "/api/login", payload)
                .then(response => {
                    commit("setUserData", response.data.user);
                    commit("setToken", response.data.token);
                    router.push({name: "welcome"});
                }).catch(error => {
                //console.log('KO');
                commit("snackMessage", {color: "error", text: "Email ou Mot de passe incorrect", status: true});
            });
        },
        consoleUser({commit}) {
            axios.get(window.location.origin + "/api/user")
                .then(response => {
                    console.log(response.data);
                }).catch(error => {
            });
        },
        logout({commit}) {
            axios.post(window.location.origin + "/api/logout").then(() => {
                router.push({name: "Login"});
                commit("logOut");
            });
        },
    }
})

