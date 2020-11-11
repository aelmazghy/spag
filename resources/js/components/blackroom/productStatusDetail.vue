<template>
    <div>

        <v-dialog
            v-model="changeStatusBox"
            width="500"
        >
            <v-card>
                <v-card-title class="headline" primary-title style="background-color:#e91e63;">
                    <span style="color:white;">Confirmation</span>
                    <v-spacer></v-spacer>
                    <v-btn text icon color="white" right @click="changeStatusBox = false">
                        <v-icon large>close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    Êtes-vous certain de vouloir de changer le statut du projet <b>{{ projectName }}</b>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="secondary"
                        @click="changeStatusBox = false"
                    >
                        Annuler
                    </v-btn>
                    <v-btn
                        color="#e91e63"
                        class="white--text"
                        @click="changeStatusScoring()"
                    >
                        Confirmer
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog
            v-model="closeStatusBox"
            width="500"
        >
            <v-card>
                <v-card-title class="headline" primary-title style="background-color:#e91e63;">
                    <span style="color:white;">Confirmation fermeture du projet</span>
                    <v-spacer></v-spacer>
                    <v-btn text icon color="white" right @click="closeStatusBox = false">
                        <v-icon large>close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    Êtes-vous certain de vouloir de fermer ce projet: <b>{{ projectName }}</b>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="secondary"
                        @click="closeStatusBox = false"
                    >
                        Annuler
                    </v-btn>
                    <v-btn
                        color="#e91e63"
                        class="white--text"
                        @click="changeStatusClosed()"
                    >
                        Confirmer
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-list-item
            :key="projectId + '-project'"
        >
            <v-list-item-icon>
                <v-icon large>build_circle</v-icon>
                <!--<v-icon large>check_circle</v-icon>-->
            </v-list-item-icon>
            <v-list-item-content>
                <v-list-item-title>
                    <strong> {{ projectName }} {{ projectStatus }} </strong>
                </v-list-item-title>
            </v-list-item-content>
            <v-list-item-action>
                <div>
                    <v-chip
                        color="#c90f54"
                        text-color="white"
                    >
                        <strong> 0 / 10</strong>
                    </v-chip>&nbsp;&nbsp;&nbsp;
                    <v-btn @click="getIdProject()" fab large class="mx-2"
                           :style="[projectStatus === 1 ? {'background-color':'green !important'}: {}]"
                           :disabled="disabledPending">
                        <v-icon :style="[projectStatus === 1 ? {'color':'white !important'}: {}]">schedule</v-icon>
                    </v-btn>
                    <v-btn @click="changeStatus()" fab large class="mx-2"
                           :style="[projectStatus === 2 ? {'background-color':'green !important'}: {}]"
                           :disabled="disabledOpened">
                        <v-icon :style="[projectStatus === 2 ? {'color':'white !important'}: {}]">how_to_vote</v-icon>
                    </v-btn>
                    <v-btn @click="closeStatus()" fab large class="mx-2"
                           :style="[projectStatus === 3 ? {'background-color':'green !important'}: {}]"
                           :disabled="disabledClosed">
                        <v-icon :style="[projectStatus === 3 ? {'color':'white !important'}: {}]">cancel</v-icon>
                    </v-btn>
                </div>
            </v-list-item-action>

        </v-list-item>
    </div>
</template>

<script>
export default {
    name: "projectStatusDetail.vue",
    props: ['projectId'],
    data: function () {
        return {
            projectName: "",
            projectStatus: 1,
            changeStatusBox: false,
            closeStatusBox: false,

            disabledPending: true,
            disabledOpened: false,
            disabledClosed: true,
        }
    },
    watch: {
        projectStatus: function () {
            switch (this.projectStatus) {
                case 2:
                    this.disabledPending = true;
                    this.disabledOpened = true;
                    this.disabledClosed = false;
                    break;
                case 3:
                    this.disabledPending = true;
                    this.disabledOpened = true;
                    this.disabledClosed = true;
                    break;
            }
        }

    },
    created: function () {
        let projectData = this.$store.state.products.find(project => project.id === this.projectId);
        this.projectName = projectData.name;
        this.projectStatus = projectData.status_id;
    },
    methods: {
        getIdProject: function () {
            //alert(this.$store.state.projects.find(project => project.id === this.projectId).id +'//' + this.$store.state.projects.find(project => project.id === this.projectId).status_id);
        },

        changeStatus: function () {
            this.changeStatusBox = true;
        },
        changeStatusScoring: function () {
            //                 this.$store.dispatch('addProject', {name: this.name, spot_id: this.spot_id});

            this.$store.dispatch('changeStatusScoring', {id: this.projectId});
            this.changeStatusBox = false;
            this.projectStatus = 2;
            this.disabledOpened = true;
        },
        closeStatus: function () {
            this.closeStatusBox = true;
        },
        changeStatusClosed: function () {
            this.$store.dispatch('changeStatusClosed', {id: this.projectId});
            this.closeStatusBox = false;
            this.projectStatus = 3;
            this.disabledClosed = true;

        },
    }
}
</script>

<style>

</style>
