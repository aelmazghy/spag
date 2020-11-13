<template>
    <v-container fill-height fluid
                 style="background-color:black;background-image:url('/img/back-spa.jpg');background-size: cover;">
        <v-snackbar
            v-model="$store.state.snack.status"
            timeout="5000"
            :color="$store.state.snack.color"
        >
            <strong> {{ $store.state.snack.text }} </strong>

        </v-snackbar>
        <v-row align="center"
               justify="center">
            <v-col>
                <v-card
                    class="mx-auto"
                    max-width="400"
                >
                    <v-card-text style="background-color:#30b5d7;" class="text-center">
                        <img
                            src="/img/logoTest.png"

                            class="white--text align-end"
                            height="300" width="300"
                        >
                    </v-card-text>
                    <v-form ref="userLogin">
                        <v-card-text>
                            <v-text-field
                                prepend-icon="email"
                                label="Email"
                                required
                                v-model="userData.email"
                            ></v-text-field>
                            <v-text-field
                                prepend-icon="vpn_key"
                                name="UserPassword"
                                label="Mot de passe"
                                v-model="userData.password"
                                class="input-group--focused"
                                type="password"
                            ></v-text-field>

                        </v-card-text>
                        <v-card-actions style="padding:20px;">
                            <v-spacer></v-spacer>
                            <v-btn color="#30b5d7" dark @click="login"><strong> Se connecter admin</strong>
                            </v-btn>
                        </v-card-actions>
                    </v-form>

                </v-card>
            </v-col>
        </v-row>
    </v-container>


</template>

<script>
export default {
    name: "login",
    data: function () {
        return {
            userData: {
                email: null,
                password: null
            }
        };
    },
    methods: {
        goToGeneral: function () {
            this.$router.push({name: 'general'})
        },
        login: function () {
            this.$store.dispatch('loginUser', this.userData);
        }
    }
}
</script>

<style>

</style>
