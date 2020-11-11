<template>
    <div style="padding-left:50px;padding-right:50px;">

        <h1 style="margin-bottom:20px;">Mon Panier</h1>
        <!--
        <button class="btn btn-primary">Cart ({{ numInCart }})</button>

        <table class="table">
            <tbody>
            <tr v-for="item in cart">
                <td>{{ item.name }}</td>
                <td>{{ item.price | dollars }}</td>
            </tr>
            <tr>
          <th></th>
          <th>{{ total | dollars }}</th>
        </tr>
            </tbody>
        </table>
    -->


        <v-dialog
            v-model="removeAllProductBox"
            width="500"
        >
            <v-card>
                <v-card-title class="headline" primary-title style="background-color:#e91e63;">
                    <span style="color:white;">Vider le panier</span>
                    <v-spacer></v-spacer>
                    <v-btn text icon color="white" right @click="removeAllProductBox = false">
                        <v-icon large>close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    Le panier sera définitivement vidé, êtes-vous certain de vouloir faire cela ??
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="secondary"
                        @click="removeAllProductBox = false"
                    >
                        Annuler
                    </v-btn>
                    <v-btn
                        color="#e91e63"
                        @click.prevent="removeAllFromCart()"
                        class="white--text"
                    >
                        Vider
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-form @submit.prevent="addOrder()" ref="orderForm" enctype="multipart/form-data">

            <v-card width="100%" style="margin-top:30px;">

                <v-card-title>
                    <v-icon x-large
                            color="black">
                        room_service
                    </v-icon>
                    &nbsp;Confirmation commande
                    <v-spacer></v-spacer>


                    <v-tooltip top>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn icon
                                   v-bind="attrs"
                                   v-on="on"
                                   class="error"
                                   :disabled="cart.length <= 0"
                                   @click="DialogRemoveAllFromCart()"
                            >
                                <v-icon color="white lighten-1">delete</v-icon>
                            </v-btn>
                        </template>
                        <span>Vider mon panier</span>
                    </v-tooltip>

                </v-card-title>
                <v-list>
                    <v-list-item-group
                    >
                        <template v-for="item in cart">
                            <v-list-item
                                :key="item.product.id"
                            >
                                <v-list-item-avatar>
                                    <v-img :src="item.product.image"></v-img>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                    <v-list-item-title class="ml-2"><strong>{{ item.product.name }}</strong>
                                    </v-list-item-title>
                                </v-list-item-content>
                                <v-list-item-action d-flex>
                                    <div>
                                        <v-chip
                                            class="ma-2"
                                            color="success"
                                            label
                                            text-color="white"
                                        >
                                            {{ item.quantity }}x<b> {{ item.product.vSal_Base }} €</b>
                                        </v-chip>
                                        <v-tooltip top>
                                            <template v-slot:activator="{ on, attrs }">
                                                <v-btn icon
                                                       v-bind="attrs"
                                                       v-on="on"
                                                       :disabled="cart.length <= 0"
                                                       @click.prevent="removeProductFromCart(item.product)"
                                                >
                                                    <v-icon color="grey lighten-1">delete</v-icon>
                                                </v-btn>
                                            </template>
                                            <span>Supprimer</span>
                                        </v-tooltip>

                                    </div>
                                </v-list-item-action>

                            </v-list-item>
                            <v-divider
                            ></v-divider>
                        </template>
                    </v-list-item-group>
                </v-list>


            </v-card>
            <v-card width="100%" style="margin-top:30px;">
                <v-list>
                    <v-list-item>
                        <v-list-item-content>
                            <v-list-item-title class="ml-2"><strong>Total:</strong><small>
                                ce montant sera facturé à la reception
                            </small>
                            </v-list-item-title>
                        </v-list-item-content>
                        <v-list-item-action>
                            <div>

                                <v-chip
                                    class="ma-2"
                                    color="error"
                                    label
                                    text-color="white"
                                >
                                    <v-icon left>
                                        monetization_on
                                    </v-icon>
                                    <b>{{ cartTotalPrice }} €</b>
                                </v-chip>
                            </div>
                        </v-list-item-action>

                    </v-list-item>
                </v-list>
            </v-card>

            <v-card-actions style="padding:20px;padding-right: 0;">
                <v-spacer></v-spacer>
                <v-btn color="#42b04f" type="submit" x-large class="white--text"
                       :disabled="cart.length <= 0"
                >
                    Passer ma commande
                </v-btn>

            </v-card-actions>
        </v-form>

    </div>
</template>

<script>
import Products from "./products";

export default {
    name: "cart",

    data: function () {
        return {
            removeAllProductBox: false,
            showCart: false,
        }
    },
    components: {
        Products,
    },
    computed: {
        cart() {
            return this.$store.state.cart;
        },
        cartTotalPrice() {
            return this.$store.getters.cartTotalPrice;
        }

    }, // computed

    created() {
        Echo.join('orders')
        .listen('OrderEvent', (event) => {
            this.cart.push(event.order);
        });
    },
    methods: {
        DialogRemoveAllFromCart() {
            this.removeAllProductBox = true
        },
        removeProductFromCart(product) {
            this.$store.dispatch('removeProductFromCart', product);
        },
        removeAllFromCart() {
            this.$store.dispatch('removeAllFromCart');
            this.removeAllProductBox = false
        },
        addOrder() {
            const payload = {
                user_id: this.$store.state.userData.id,
                cart: this.$store.state.cart,
            }
            this.$store.dispatch('addOrder', payload);
            this.$refs.orderForm.reset();
            this.$store.state.cart = [];

        }

    }// end methods
}
</script>

<style scoped>

</style>
