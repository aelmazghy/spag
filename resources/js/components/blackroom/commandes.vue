<template>
    <div
        style="padding-left:50px;padding-right:50px;">
        <v-dialog
            v-model="infoBox"
            width="500"
        >
            <v-card>
                <v-card-title class="headline" primary-title style="background-color:#e91e63;">
                    <span style="color:white;">Détails de la commande #{{OrderIdToView}}</span>
                    <v-spacer></v-spacer>
                    <v-btn text icon color="white" right @click="infoBox = false">
                        <v-icon large>close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-list>
                    <v-chip
                        class="ma-2"
                        color="primary"
                    >

                        Salle: {{ OrderNameToView }}
                        <v-icon right>
                            water_damage
                        </v-icon>
                    </v-chip>
                    <v-chip
                        class="ma-2"
                        color="error"
                    >

                        Total: {{totalprice}}€
                        <v-icon right>
                            monetization_on
                        </v-icon>
                    </v-chip>
                    <v-list-item-group>
                        <template
                                  v-for="(orp, index) in $store.state.orp"
                        >
                        <v-list-item :key="orp.id + '-orp'">
                                <v-list-item-avatar>
                                    <v-img :src="orp.image"></v-img>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                    <v-list-item-title class="ml-2"><strong>{{orp.name}}</strong></v-list-item-title>
                                </v-list-item-content>
                                <v-list-item-action d-flex>
                                    <div>
                                        <v-chip
                                            class="ma-2"
                                            color="success"
                                            label
                                            text-color="white"
                                        >
                                            {{ orp.quantity }} x<b> {{ orp.vSal_Base }} €</b>
                                        </v-chip>
                                    </div>
                                </v-list-item-action>

                            </v-list-item>
                            <v-divider
                            ></v-divider>
                            <v-divider
                                v-if="index < $store.state.orp.length - 1"
                                :key="index"
                            ></v-divider>
                        </template>
                    </v-list-item-group>
                </v-list>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="secondary"
                        @click="infoBox = false"
                        class="white--text"
                    >
                        Fermer
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <h1 style="margin-bottom:20px;">Les grosses commandes</h1>
        <v-card width="100%" style="margin-top:30px;">
            <v-card-title>
                <v-icon x-large
                        color="black">
                    shopping_bag
                </v-icon>
                &nbspListe des commandes
            </v-card-title>
            <v-list>
                <v-list-item-group
                >

                    <template v-for="(order, index) in $store.state.orders">
                        <v-list-item two-line
                                     :key="order.id + '-order'"
                        >
                            <v-list-item-icon>
                                <v-icon>shopping_bag</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content @click="moreInfoOrder(order.id, getUser(order.user_id), getOrderProducts(order.id))">
                                <v-list-item-title><strong> Commande #{{ order.id }} </strong>
                                    <v-chip
                                        class="ma-2"
                                        color="primary"
                                    >

                                        SALLE: {{getUser(order.user_id)}}
                                        <v-icon right>
                                            water_damage
                                        </v-icon>
                                    </v-chip>
                                    <v-chip
                                        class="ma-2"
                                        color="success"
                                    > {{getStatus(order.status_id)}}
                                        <v-icon right>
                                            room_service
                                        </v-icon>
                                    </v-chip>
                                    <v-chip
                                        class="ma-2"
                                        color="error"
                                    >
                                        <b>{{ order.total }}</b>
                                        <v-icon right>
                                            euro
                                        </v-icon>
                                    </v-chip>
                                </v-list-item-title>
                                <v-list-item-subtitle>{{moment(order.created_at).locale("fr").format('LLL')}}</v-list-item-subtitle>
                            </v-list-item-content>
                            <v-list-item-action>
                                <div>
                                    <v-btn icon style="background-color: #ca993b;">
                                        <v-icon color="white lighten-1">cancel</v-icon>
                                    </v-btn>
                                    <v-btn icon style="background-color: #4caf50;">
                                        <v-icon color="white lighten-1">assignment_turned_in</v-icon>
                                    </v-btn>
                                    <v-btn icon style="background-color: #ff5252;">
                                        <v-icon color="white lighten-1">point_of_sale</v-icon>
                                    </v-btn>
                                </div>
                            </v-list-item-action>

                        </v-list-item>
                        <v-divider
                            v-if="index < $store.state.orders.length - 1"
                            :key="index"
                        ></v-divider>
                    </template>
                </v-list-item-group>
            </v-list>
        </v-card>
    </div>
</template>

<script>
import productStatusDetail from './productStatusDetail.vue'
import moment from 'moment'
import axios from "axios";
import store from "../../store/blackroom";



export default {

    name: "productsStatus.vue",
    components: {productStatusDetail},
    data: function () {
        return {
            infoBox: false,
            OrderIdToView: "",
            OrderNameToView: "",
            OrderProductsToView: {},
            totalprice : 0,
        }
    },
    created() {
        Echo.join('orders')
            .listen('OrderEvent', (event) => {
                this.cart.push(event.order);
            });
    },
    methods: {
        moment,
        moreInfoOrder(orderId, orderName, orderProducts) {
            this.infoBox = true;
            this.OrderIdToView = orderId;
            this.OrderNameToView = orderName;
            this.OrderProductsToView = orderProducts;

        },
        getUser: function (userId) {
            return this.$store.state.users.find(user => user.id === userId).name;
        },
        getStatus: function (statusId) {
            return this.$store.state.status.find(i => i.id === statusId).name;
        },
        getOrderProducts: function (orderProductsId) {
            let orderProductsData = this.$store.state.orp.find(i => i.id === orderProductsId);
            this.OrderProductsToView = _.clone(orderProductsData);
            let that = this;
            axios.get(window.location.origin + "/api/ordersproducts/"+orderProductsId)
                .then(response => {
                    // console.log(response);
                    store.dispatch('setOrdersProducts', response.data);
                    let total = 0;
                    for(let i = 0 ; i<response.data.length;i++)
                    {
                        total += response.data[i].vSal_Base * response.data[i].quantity;
                    }
                    that.totalprice = total;


                }).catch(error => {
            });

           // return this.$store.state.orp.find(i => i.id === orderProductsId).id;
        },


    }
}
</script>

<style>

</style>
