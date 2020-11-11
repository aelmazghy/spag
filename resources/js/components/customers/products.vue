<template>
    <div style="padding-left:50px;padding-right:50px;">
        <h1 style="margin-bottom:20px;">Nos Produits:

        </h1>


        <div class="post-outer col-xs-12 col-md-2 col-sm-4 d-block float-left overflow-hidden"
             v-for="product in $store.state.products"
             :key="product.id"
        >
            <v-card
                class="d-block float-left overflow-hidden ma-2"
            >
                <v-img
                    :src="product.image"
                ></v-img>

                <v-card-title>{{ product.name }}
                    <v-chip class="ml-2" text-color="white" color="green">{{ product.vSal_Base }} €</v-chip>
                </v-card-title>

                <v-card-text>

                    <div>{{ product.description }}.</div>
                </v-card-text>
                <v-card-actions>
                    <v-btn
                        @click="addToCart(product)"
                        depressed
                        color="#c8ffce"
                        :disabled="addBTN">
                        Ajouter au panier
                    </v-btn>
                </v-card-actions>
            </v-card>
        </div>


    </div>
</template>

<script>
import cart from "./cart";

export default {
    props: ['product'],

    name: "products",
    components: {cart},
    data: function () {
        return {
            addBTN: false,
        }
    },
    methods: {

        addToCart(product) {
            // alert('ok');
            this.$store.dispatch('addToCart', {
                product: product,
                quantity: 1

            })
        }

    }, // end methods
}
</script>

<style scoped>

</style>
