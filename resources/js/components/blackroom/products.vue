<template>
    <div style="padding-left:50px;padding-right:50px;">
        <div class="text-center">
            <v-dialog
                v-model="deleteProductBox"
                width="500"
            >
                <v-card>
                    <v-card-title class="headline" primary-title style="background-color:#e91e63;">
                        <span style="color:white;">Effacer un produit</span>
                        <v-spacer></v-spacer>
                        <v-btn text icon color="white" right @click="deleteProductBox = false">
                            <v-icon large>close</v-icon>
                        </v-btn>
                    </v-card-title>
                    <v-card-text>
                        Le produit <b>{{ productNameToDelete }}</b> sera définitivement supprimé, êtes-vous certain de
                        vouloir faire cela ??
                    </v-card-text>

                    <v-divider></v-divider>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="secondary"
                            @click="deleteProductBox = false"
                        >
                            Annuler
                        </v-btn>
                        <v-btn
                            color="#e91e63"
                            @click="deleteProductAction()"
                            class="white--text"
                        >
                            Supprimer
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-dialog
                v-model="editProductBox"
                width="500"
            >
                <v-card>
                    <v-card-title class="headline" primary-title style="background-color:#e91e63;">
                        <span style="color:white;">Editer un produit</span>
                        <v-spacer></v-spacer>
                        <v-btn text icon color="white" right @click="editProductBox = false">
                            <v-icon large>close</v-icon>
                        </v-btn>
                    </v-card-title>
                    <v-form @submit.prevent="editProductAction()" v-model="editProductForm" ref="productFormEdit">
                        <v-card-text>

                            <v-text-field
                                id="name"
                                prepend-icon="room_service"
                                name="name"
                                label="Nom du produit"
                                color="#e91f62"
                                v-model="editedProduct.name"
                                :rules="nameRules"
                                required></v-text-field>
                            <v-textarea
                                prepend-icon="description"
                                name="description"
                                label="Description du produit"
                                v-model="editedProduct.description"
                                :rules="descriptionRules"
                            ></v-textarea>

                            <!--
                                                <v-file-input show-size
                                                              label="Photo du produit"
                                                              prepend-icon="party_mode"
                                                              accept=".jpg,.jpeg"
                                                              @change="onFileChange"
                                                              name="image"
                                                              :rules="imageRules">
                                                </v-file-input>

                            -->
                            <v-text-field
                                name="vSal_Base"
                                label="Prix"
                                prepend-icon="monetization_on"
                                id="Sal_Base"
                                required
                                v-model="editedProduct.vSal_Base"
                                :rules="iSal_BaseRules"
                            ></v-text-field>


                        </v-card-text>
                    </v-form>
                    <v-divider></v-divider>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="secondary"
                            @click="editProductBox = false"
                        >
                            Annuler
                        </v-btn>
                        <v-btn
                            color="#e91f62"
                            @click="editProductAction()"
                            :disabled="!editProductForm"
                            class="white--text"
                        >
                            Modifier
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </div>
        <h1 style="margin-bottom:20px;">Gestion des produits</h1>
        <v-card width="100%">
            <v-card-title>
                <v-icon x-large
                        color="black">
                    add_circle_outline
                </v-icon>
                &nbsp;Ajouter un produit
            </v-card-title>
            <v-form @submit.prevent="addProduct()" v-model="addProductForm" ref="productForm"
                    enctype="multipart/form-data">
                <v-card-text>

                    <v-text-field
                        id="name"
                        prepend-icon="room_service"
                        name="name"
                        label="Nom du produit"
                        color="#e91f62"
                        v-model="name"
                        :rules="nameRules"
                        required></v-text-field>
                    <v-textarea
                        prepend-icon="description"
                        name="description"
                        label="Description du produit"
                        v-model="description"
                        :rules="descriptionRules"
                    ></v-textarea>

                    <v-file-input show-size
                                  label="Photo du produit"
                                  prepend-icon="party_mode"
                                  accept=".jpg,.jpeg,.png"
                                  @change="onFileChange"
                                  name="image"
                    >
                    </v-file-input>

                    <v-text-field
                        name="vSal_Base"
                        label="Prix"
                        prepend-icon="monetization_on"
                        id="Sal_Base"
                        required
                        v-model="vSal_Base"
                        :rules="iSal_BaseRules"
                    ></v-text-field>

                </v-card-text>
                <v-card-actions style="padding:20px;">
                    <v-spacer></v-spacer>
                    <v-btn color="#e91f62" type="submit" x-large :disabled="!addProductForm" class="white--text">
                        Enregistrer
                        le produit
                    </v-btn>

                </v-card-actions>
            </v-form>
        </v-card>
        <v-card width="100%" style="margin-top:30px;">
            <v-card-title>
                <v-icon x-large
                        color="black">
                    room_service
                </v-icon>
                &nbsp;Liste des produits
            </v-card-title>
            <v-list>
                <v-list-item-group
                >
                    <template v-for="(product, index) in $store.state.products">
                        <v-list-item
                            :key="index + '-product'"
                        >
                            <!-- :key="product.id + '-product'" -->
                            <v-list-item-avatar>
                                <v-img :src="product.image"></v-img>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title class="ml-2"><strong>{{ product.name }}</strong>
                                    <v-chip
                                        class="ma-2"
                                        color="success"
                                        label
                                        text-color="white"
                                    >
                                        <v-icon left>
                                            monetization_on
                                        </v-icon>
                                        <b>{{ product.vSal_Base }} €</b>
                                    </v-chip>

                                    <small>{{ product.description }}</small>
                                </v-list-item-title>
                            </v-list-item-content>
                            <v-list-item-action>
                                <div>
                                    <v-btn icon
                                           @click="editProduct(product.id)">
                                        <v-icon color="grey lighten-1">create</v-icon>
                                    </v-btn>
                                    <v-btn icon
                                           @click="deleteProduct(product.id, product.name)">
                                        <v-icon color="grey lighten-1">delete</v-icon>
                                    </v-btn>
                                </div>
                            </v-list-item-action>

                        </v-list-item>
                        <v-divider
                            v-if="index < $store.state.products.length - 1"
                            :key="index"
                        ></v-divider>
                    </template>
                </v-list-item-group>
            </v-list>
        </v-card>
    </div>
</template>

<script>
export default {
    name: "products.vue",
    data: function () {
        return {
            vSal_Base: "",
            aux_trans: "0,00",
            min_salary: "0,00",

            addProductForm: false,
            editProductForm: false,
            deleteProductBox: false,
            editProductBox: false,
            name: "",
            // image: "",
            //url: null,
            images: [],

            description: "",
            productIdToDelete: "",
            productNameToDelete: "",
            editedProduct: {},

            nameRules: [
                v => !!v || 'Le nom est obligatoire',
            ],
            descriptionRules: [
                v => !!v || 'Un plateau est obligatoire',
            ],
            iSal_BaseRules: [
                v => !!v || 'Le prix est obligatoire',
            ],
            imageRules: [
                v => !!v || 'Une image est obligatoire'
            ],
            money:
                {
                    decimal: ',',
                    thousands: '.',
                    prefix: '',
                    suffix: '',
                    precision: 2,
                    masked: false /* doesn't work with directive */
                },
        }

    },
    methods: {

        /*handleFilesUpload(){
            let uploadedFiles = this.$refs.files;
            console.log("uploadedFiles", uploadedFiles);
            /!*
              Adds the uploaded file to the files array
            *!/
            for( let i = 0; i < uploadedFiles.length; i++ ){
                this.files.push( uploadedFiles[i] );
            }
        },*/
        onFileChange(e) {
            if (e) {
                this.images.push(e);
                /*const file = e;
                this.image = URL.createObjectURL(file);
            } else {
                this.image = null;*/
            }
        },
        addProduct: function () {
            const payload = {
                name: this.name,
                description: this.description,
                vSal_Base: this.vSal_Base,
                images: this.images
            }

            this.$store.dispatch('addProduct', payload);
            this.$refs.productForm.reset();
            this.images = [];

            //this.$refs.articleForm.$el.submit();

        },
        /*getSpot: function (spotId) {
            return this.$store.state.spots.find(spot => spot.id === spotId).name;
        },

         */
        deleteProduct: function (productId, productName) {
            this.deleteProductBox = true;
            this.productNameToDelete = productName;
            this.productIdToDelete = productId;
        },
        deleteProductAction: function () {
            this.$store.dispatch('deleteProduct', this.productIdToDelete);
            this.productIdToDelete = "";
            this.productNameToDelete = "";
            this.deleteProductBox = false
        },
        editProduct: function (productId) {
            let productData = this.$store.state.products.find(product => product.id === productId);
            this.editedProduct = _.clone(productData);
            this.editProductBox = true;
        },
        editProductAction: function () {
            this.$store.dispatch('editProductAction', {
                id: this.editedProduct.id,
                name: this.editedProduct.name,
                description: this.editedProduct.description,
                vSal_Base: this.editedProduct.vSal_Base
            });
            this.editProductBox = false;
            this.$refs.productFormEdit.reset();
        },

    }
}
</script>

<style>

</style>

