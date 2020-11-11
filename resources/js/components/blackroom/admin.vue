<template>
    <div>
        <v-snackbar
            v-model="$store.state.snack.status"
            timeout="3000"
            :color="$store.state.snack.color"
        >
            <strong> {{ $store.state.snack.text }} </strong>

        </v-snackbar>

        <v-navigation-drawer
            color="#30b5d7"
            permanent
            dark
            fixed
            app
        >
            <v-list style="padding-top:20px;"
                    dense
            >
                <div><img src="/img/logoTest.png" width="250" style="margin-bottom:30px;">
                </div>
                <v-subheader><strong>Notifications</strong></v-subheader>
                <v-list-item-group
                    active-class=" text--accent-4"
                >
                    <v-divider></v-divider>
                    <v-list-item @click="goToRoute('commandes')">
                        <v-list-item-icon>
                            <v-icon>shopping_bag</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title><strong>Commandes</strong></v-list-item-title>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-icon>
                            <v-icon>notifications_active</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title><strong>Alerts</strong></v-list-item-title>
                    </v-list-item>


                </v-list-item-group>
                <v-subheader><strong>GESTION</strong></v-subheader>
                <v-list-item-group
                    active-class=" text--accent-4"
                >
                    <v-divider></v-divider>
                    <v-list-item @click="goToRoute('users')">
                        <v-list-item-icon>
                            <v-icon>account_box</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title><strong>UTILISATEURS</strong></v-list-item-title>
                    </v-list-item>

                    <v-list-item @click="goToRoute('spots')">
                        <v-list-item-icon name="sdf">
                            <v-icon>water_damage</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title><strong>SALLES</strong></v-list-item-title>
                    </v-list-item>
                    <v-list-item h @click="goToRoute('products')">
                        <v-list-item-icon name="sdf">
                            <v-icon>room_service</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title><strong>PRODUITS</strong></v-list-item-title>
                    </v-list-item>

                </v-list-item-group>

            </v-list>
        </v-navigation-drawer>

        <v-app-bar
            color="black"
            dark
            app

        >
            <v-toolbar-title><strong>SPA</strong> <span class="font-weight-light">Privatif</span>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn color="white" @click="logOut">
                <v-icon color="#30b5d7">lock</v-icon>
                <span style="color:#30b5d7">&nbsp;DECONNEXION</span>
            </v-btn>
        </v-app-bar>

        <v-main>
            <v-container fluid>
                <transition name="fade" mode="out-in" appear>
                    <router-view></router-view>
                </transition>
            </v-container>
        </v-main>
    </div>

</template>

<script>
export default {
    name: "admin",
    data: function () {
        return {
            drawer: false
        }
    },
    methods: {
        goToRoute: function (routeName) {
            this.$root.$router.push({name: routeName});
        },

        logOut: function () {
            this.$store.dispatch('logout');
        },
    }
}
</script>

<style>

</style>
