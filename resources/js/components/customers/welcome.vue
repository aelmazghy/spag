<template>
    <div>
        <v-dialog
            v-model="InfoPopup"
            width="500"
        >
            <v-card>
                <v-card-title class="headline" primary-title style="background-color:#e91e63;">
                    <span style="color:white;">Informations</span>
                    <v-spacer></v-spacer>
                    <v-btn text icon color="white" right @click="InfoPopup = false">
                        <v-icon large>close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text class="text-center">
                    VIP SPA - APP V.1.0.0 <br/>
                    Made by Luzine LAB 🏭
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="#e91e63"
                        @click="InfoPopup = false"
                        class="white--text"
                    >
                        Fermer
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-snackbar
            v-model="$store.state.snack.status"
            timeout="5000"
            :color="$store.state.snack.color"
        >
            <strong> {{ $store.state.snack.text }} </strong>

        </v-snackbar>
        <v-app-bar
            color="black"
            dark
            app
        >
            <v-app-bar-nav-icon href="/customers">
                <v-icon>invert_colors</v-icon>
            </v-app-bar-nav-icon>

            <v-toolbar-title><strong>SPA</strong> <span class="font-weight-light">Privatif
                <v-chip
                    class="ma-2"
                    color="green"
                    text-color="white"
                >
                  Suite: {{ $store.state.userData.name }}
                </v-chip>
            </span>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn color="dark" depressed @click="PopUpInfo()">
                <v-icon color="#30b5d7">help</v-icon>
            </v-btn>
            <v-btn color="dark" depressed class="ml-3" v-if="$store.state.userData.is_admin === 1" href="/blackroom"
                   target="_blank">
                <v-icon color="#30b5d7">admin_panel_settings</v-icon>
                <span style="color:#30b5d7">&nbsp;Admin</span>
            </v-btn>
        </v-app-bar>
        <div v-if="$router.currentRoute.path === '/customers'">
            <v-row class="full-height">
                <v-col align="center"
                       justify="center">
                    <img src="/img/logoTest.png" width="400" style="margin-top:200px;">
                </v-col>

            </v-row>
            <h1 style="margin-bottom:20px; text-align: center;">Bienvenu chez VIP SPA</h1>

        </div>
        <v-container fluid>
            <transition name="fade" mode="out-in" appear>
                <router-view></router-view>
            </transition>
        </v-container>


        <v-bottom-navigation
            fixed
            :value="value"
            color="primary">
            <v-btn value="recent" @click="goToRoute('orders')">
                <span>COMMANDES</span>

                <v-icon>shopping_bag</v-icon>
            </v-btn>

            <v-btn value="favorites" @click="goToRoute('products')">
                <span>PRODUITS</span>

                <v-icon>room_service</v-icon>
            </v-btn>

            <v-btn value="nearby" @click="goToRoute('cart')">

                <span>PANIER</span>
                <v-badge
                    color="green"
                    overlap
                    right
                    bordered
                    :content="CartItemCount > 0 ? CartItemCount : '0' "
                >
                    <v-icon> shopping_basket</v-icon>

                </v-badge>
            </v-btn>
        </v-bottom-navigation>
    </div>
</template>

<script>
import Products from "./products";

export default {
    name: "welcome.vue",
    components: {Products},
    data: function () {
        return {
            loading: false,
            selection: 1,
            value: 1,
            InfoPopup: false,

        }
    },
    computed: {
        cart() {
            return this.$store.state.cart;
        },
        CartItemCount() {
            return this.$store.getters.CartItemCount;
        }

    }, // computed
    methods: {
        goToRoute: function (routeName) {
            this.$root.$router.push({name: routeName});
        },
        PopUpInfo: function () {
            this.InfoPopup = true
        },

    }, // methods
}
</script>

<style>

</style>
