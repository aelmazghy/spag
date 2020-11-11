import Vue from 'vue'
import Vuex from 'vuex'
import axios from "axios";
import router from '../router/blackroom'


Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        spots: [],
        users: [],
        status: [],
        products: [],
        userData: null,
        authToken: null,
        isLoggedIn: !!localStorage.getItem("token"),
        errors: [],
        orders: [],
        orp: [],
        snack: {color: "success", text: "no text", status: false}
    },
    mutations: {
        setSpotsData(state, payload) {
            state.spots = payload;
        },
        setUsersData(state, payload) {
            state.users = payload;
        },
        setStatusData(state, payload) {
            state.status = payload;
        },
        setOrdersProductsData(state, payload) {
            state.orp = payload;
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
        setErrors(state, errors) {
            state.errors = errors;
        },
        setProductsData(state, payload) {
            state.products = payload;
        },
        setOrdersData(state, payload) {
            state.orders = payload;
        },
        snackMessage(state, payload) {
            state.snack = payload;
        },
        changeStatusScoring(state, payload) {
            const product = state.products.find(item => item.id === payload);
            product.status_id = 2;
        },
        changeStatusClosed(state, payload) {
            const product = state.products.find(item => item.id === payload);
            product.status_id = 3;
        }
    },
    actions: {
        setSpots({commit}, payload) {
            commit("setSpotsData", payload);
        },
        addSpot({commit}, payload) {
            axios.post(window.location.origin + "/api/spots", payload)
                .then(response => {
                    commit("setSpotsData", response.data);
                    commit("snackMessage", {color: "success", text: "Salle ajoutée", status: true});
                }).catch(error => {
            });
        },
        setUsers({commit}, payload) {
            commit("setUsersData", payload);
        },
        setStatus({commit}, payload) {
            commit("setStatusData", payload);
        },
        addUser({commit}, payload) {
            axios.post(window.location.origin + "/api/users", payload)
                .then(response => {
                    commit("setUsersData", response.data);
                    commit("snackMessage", {color: "success", text: "Utilisateur ajouté", status: true});
                }).catch(error => {
            });
        },

        /*DELETE USER*/
        deleteUser({commit}, payload) {
            axios.delete(window.location.origin + "/api/users/" + payload, payload)
                .then(response => {
                    commit("setUsersData", response.data);
                    commit("snackMessage", {color: "success", text: "Utilisateur supprimé", status: true});
                }).catch(error => {
            });
        },
        /*DELETE USER*/

        /*EDIT USER*/
        editUserConfirm({commit}, payload) {
            axios.put(window.location.origin + "/api/users/" + payload.id, payload)
                .then(response => {
                    commit("setUsersData", response.data);
                    commit("snackMessage", {color: "success", text: "Utilisateur modifié", status: true});
                }).catch(error => {
            });
        },
        /*EDIT USER*/

        /*EDIT USER PASSWORD*/
        changePassword({commit}, payload) {
            axios.patch(window.location.origin + "/api/users/" + payload.id, payload)
                .then(response => {
                    commit("snackMessage", {color: "success", text: "Mot de passe modifié", status: true});
                }).catch(error => {
            });
        },
        /*EDIT USER PASSWORD*/

        /* DELETE SPOT */
        deleteSpot({commit}, payload) {
            axios.delete(window.location.origin + "/api/spots/" + payload, payload)
                .then(response => {
                    commit("setSpotsData", response.data);
                    commit("snackMessage", {color: "success", text: "Salle supprimée", status: true});
                }).catch(error => {
            });
        },
        /*DELETE SPOT*/

        /*EDIT SPOT*/
        editSpotConfirm({commit}, payload) {
            axios.put(window.location.origin + "/api/spots/" + payload.id, payload)
                .then(response => {
                    commit("setSpotsData", response.data);
                    commit("snackMessage", {color: "success", text: "Salle modifiée", status: true});
                }).catch(error => {
            });
        },
        /*EDIT SPOT*/

        addProduct({commit}, payload) {
            let formData = new FormData();
            /*
              Iterate over any file sent over appending the files
              to the form data.
            */
            for (let i = 0; i < payload.images.length; i++) {
                let file = payload.images[i];
                formData.append('files[' + i + ']', file);
            }
            for (let key in payload) {
                if (key != 'images')
                    formData.append(key, payload[key]);
            }
            axios.post(
                `${window.location.origin}/api/products`,
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data; charset=utf-8' /*; boundary=' + Math.random().toString().substr(2)*/
                    }
                })
                .then(response => {
                    commit("setProductsData", response.data);
                    commit("snackMessage", {color: "success", text: "Produit ajouté", status: true});
                })
                .catch(error => {
                    console.log(error.message);
                });
        },
        /* DELETE SPOT */
        deleteProduct({commit}, payload) {
            axios.delete(window.location.origin + "/api/products/" + payload, payload)
                .then(response => {
                    commit("setProductsData", response.data);
                    commit("snackMessage", {color: "success", text: "Produit supprimé", status: true});
                }).catch(error => {
            });
        },
        /*DELETE SPOT*/

        /*EDIT product*/
        editProductAction({commit}, payload) {
            axios.put(window.location.origin + "/api/products/" + payload.id, payload)
                .then(response => {
                    commit("setProductsData", response.data);
                    commit("snackMessage", {color: "success", text: "Produit modifié", status: true});
                }).catch(error => {
            });
        },
        /*EDIT product*/


        loginUser({commit}, payload) {
            axios.post(window.location.origin + "/api/login", payload)
                .then(response => {
                    commit("setUserData", response.data.user);
                    commit("setToken", response.data.token);
                    router.push({name:"general"});
                }).catch(error => {
                commit("snackMessage", {color:"error", text:"Email ou Mot de passe incorrect", status: true});
            });
        },
        logout({ commit }) {
            axios.post(window.location.origin + "/api/logout").then(() => {
                router.push({name:"login"});
                commit("logOut");
            });
        },
        setProducts({commit}, payload) {
            commit("setProductsData", payload);
        },
        setOrders({commit}, payload) {
            commit("setOrdersData", payload);
        },
        setOrdersProducts({commit}, payload) {
            commit("setOrdersProductsData", payload);
        },
        changeStatusScoring({commit}, payload) {

            axios.post(window.location.origin + "/api/products/" + payload.id + "/openscoring", payload)
                .then(response => {
                    commit("setProductsData", response.data);
                    commit("snackMessage", {color: "success", text: "Statut modifié", status: true});
                }).catch(error => {
            });


            // commit("changeStatusScoring", payload);
        },

        changeStatusClosed({commit}, payload) {

            axios.post(window.location.origin + "/api/products/" + payload.id + "/closescoring", payload)
                .then(response => {
                    commit("setProductsData", response.data);
                    commit("snackMessage", {color: "success", text: "Statut modifié", status: true});
                }).catch(error => {
            });


            // commit("changeStatusScoring", payload);
        },
    }
})



