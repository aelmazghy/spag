<template>
    <div
        style="padding-left:50px;padding-right:50px;">
        <v-dialog
            v-model="deleteSpotBox"
            width="500"
        >
            <v-card>
                <v-card-title class="headline" primary-title style="background-color:#e91e63;">
                    <span style="color:white;">Effacer une salle</span>
                    <v-spacer></v-spacer>
                    <v-btn text icon color="white" right @click="deleteSpotBox = false">
                        <v-icon large>close</v-icon>
                    </v-btn>
                </v-card-title>

                <v-card-text>
                    La salle <b>{{ spotNameToDelete }}</b> sera définitivement supprimée, êtes-vous certain de vouloir
                    faire cela ??
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="secondary"
                        @click="deleteSpotBox = false"
                    >
                        Annuler
                    </v-btn>
                    <v-btn
                        color="#e91f62"
                        @click="deleteSpotAction()"
                        class="white--text"
                    >
                        Supprimer
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog
            v-model="editSpotBox"
            width="500"
        >
            <v-card>
                <v-card-title class="headline" primary-title style="background-color:#e91e63;">
                    <span style="color:white;">Modifier une salle</span>
                    <v-spacer></v-spacer>
                    <v-btn text icon color="white" right @click="editSpotBox = false">
                        <v-icon large>close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <v-form @submit.prevent="editSpotAction()" v-model="editSpotForm" ref="spotForm">
                        <v-card-text>

                            <v-text-field
                                id="name"
                                prepend-icon="water_damage"
                                name="name"
                                label="Nom de la salle"
                                color="#e91f62"
                                v-model="editedSpot.name"
                                :rules="nameRules"
                                required></v-text-field>


                            <v-text-field id="slug"
                                          prepend-icon="link"
                                          name="slug"
                                          label="slug"
                                          color="#e91f62"
                                          v-model="editedSpot.slug"
                                          :rules="slugRules"
                                          required></v-text-field>


                        </v-card-text>
                    </v-form>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="secondary"
                        @click="editSpotBox = false"
                    >
                        Annuler
                    </v-btn>
                    <v-btn
                        color="#e91f62"
                        @click="editSpotAction(editedSpot)"
                        :disabled="!editSpotForm"
                        class="white--text"
                    >
                        Modifier
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <h1 style="margin-bottom:20px;">Gestion des salles</h1>
        <v-card width="100%">
            <v-card-title>
                <v-icon x-large
                        color="black">
                    add_circle_outline
                </v-icon>
                &nbsp;Ajouter une salle
            </v-card-title>
            <v-form @submit.prevent="addSpot()" v-model="addSpotForm" ref="spotForm">
                <v-card-text>

                    <v-text-field
                        id="name"
                        prepend-icon="water_damage"
                        name="name"
                        label="Nom de la salle"
                        color="#e91f62"
                        v-model="name"
                        :rules="nameRules"
                        required></v-text-field>


                    <v-text-field id="slug"
                                  prepend-icon="link"
                                  name="slug"
                                  label="slug"
                                  color="#e91f62"
                                  v-model="slug"
                                  :rules="slugRules"
                                  required></v-text-field>


                </v-card-text>
                <v-card-actions style="padding:20px;">
                    <v-spacer></v-spacer>
                    <v-btn color="#e91f62" type="submit" x-large :disabled="!addSpotForm" class="white--text">
                        Enregistrer
                        la salle
                    </v-btn>

                </v-card-actions>
            </v-form>
        </v-card>
        <v-card width="100%" style="margin-top:30px;">
            <v-card-title>
                <v-icon x-large
                        color="black">
                    water_damage
                </v-icon>
                &nbsp;Liste des salles
            </v-card-title>
            <v-list>
                <v-list-item-group
                >
                    <template v-for="(spot, index) in $store.state.spots">
                        <v-list-item two-line

                                     :key="spot.id + '-spot'"
                        >
                            <v-list-item-icon>
                                <v-icon>water_damage</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title v-text="spot.name"></v-list-item-title>
                                <v-list-item-subtitle v-text="spot.slug"></v-list-item-subtitle>
                            </v-list-item-content>
                            <v-list-item-action>
                                <div>
                                    <v-btn icon
                                           @click="editSpot(spot.id)">
                                        <v-icon color="grey lighten-1">create</v-icon>
                                    </v-btn>
                                    <v-btn icon
                                           @click="deleteSpot(spot.id, spot.name)">
                                        <v-icon color="grey lighten-1">delete</v-icon>
                                    </v-btn>
                                </div>
                            </v-list-item-action>

                        </v-list-item>
                        <v-divider
                            v-if="index < $store.state.spots.length - 1"
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
    name: "spots.vue",
    data: function () {
        return {
            addSpotForm: false,
            editSpotForm: false,
            name: "",
            slug: "",
            deleteSpotBox: false,
            editSpotBox: false,
            spotIdToDelete: "",
            spotNameToDelete: "",
            deleteSpotNameBox: "",
            editedSpot: {},

            nameRules: [
                v => !!v || 'Le nom est obligatoire',
            ],
            slugRules: [
                v => !!v || 'Le slug est obligatoire',
            ],
        }
    },
    methods: {
        addSpot: function () {
            this.$store.dispatch('addSpot', {name: this.name, slug: this.slug});
            this.$refs.spotForm.reset();
        },
        deleteSpot: function (spotId, spotName) {
            this.deleteSpotBox = true;
            this.spotIdToDelete = spotId;
            this.spotNameToDelete = spotName;
        },
        deleteSpotAction: function () {
            this.$store.dispatch('deleteSpot', this.spotIdToDelete);
            this.spotIdToDelete = "";
            this.spotNameToDelete = "";
            this.deleteSpotBox = false
        },
        editSpot: function (spotId) {
            let spotData = this.$store.state.spots.find(spot => spot.id === spotId);
            this.editedSpot = _.clone(spotData);
            this.editSpotBox = true;
        },
        editSpotAction: function () {
            this.$store.dispatch('editSpotConfirm', {
                id: this.editedSpot.id,
                name: this.editedSpot.name,
                slug: this.editedSpot.slug
            });
            this.editSpotBox = false
        },
    }
}
</script>

<style>

</style>
