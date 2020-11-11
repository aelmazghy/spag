<template>
    <div
        style="padding-left:50px;padding-right:50px;">
        <div class="text-center">
            <v-dialog
                v-model="deleteUserBox"
                width="500"
            >
                <v-card>
                    <v-card-title class="headline" primary-title style="background-color:#e91e63;">
                        <span style="color:white;">Effacer un utilisateur</span>
                        <v-spacer></v-spacer>
                        <v-btn text icon color="white" right @click="deleteUserBox = false">
                            <v-icon large>close</v-icon>
                        </v-btn>
                    </v-card-title>
                    <v-card-text>
                        L'utilisateur <b>{{ deleteUserNameBox }}</b> sera définitivement supprimé, êtes-vous certain de
                        vouloir faire cela ??
                    </v-card-text>
                    <v-divider></v-divider>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="secondary"
                            @click="deleteUserBox = false"
                            class="white--text"
                        >
                            Annuler
                        </v-btn>
                        <v-btn
                            color="#e91e63"
                            @click="deleteUserConfirm()"
                            class="white--text"
                        >
                            Supprimer l'utilisateur
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-dialog
                v-model="editUserBox"
                width="500"
            >
                <v-card>
                    <v-card-title class="headline" primary-title style="background-color:#e91e63;">
                        <span style="color:white;">Modifier un utilisateur</span>
                        <v-spacer></v-spacer>
                        <v-btn text icon color="white" right @click="editUserBox = false">
                            <v-icon large>close</v-icon>
                        </v-btn>
                    </v-card-title>
                    <v-form @submit.prevent="editUserConfirm()" v-model="editUserForm" ref="userForm">
                        <v-card-text>

                            <v-text-field
                                prepend-icon="face"
                                name="name"
                                label="Nom"
                                color="#e91f62"
                                v-model="editedUser.name"
                                :rules="nameRules"
                                background-color="white"
                                required></v-text-field>
                            <v-select
                                v-model="editedUser.spot_id"
                                :items="$store.state.spots"
                                item-text="name"
                                item-value="id"
                                id="spot_id"
                                prepend-icon="water_damage"
                                name="spot_id"
                                type="text"
                                color="#e91f62"
                                label="Plateau"
                                :rules="spotRules"
                                required
                            >
                            </v-select>
                            <v-text-field id="email"
                                          prepend-icon="email"
                                          name="email"
                                          label="Email"
                                          type="email"
                                          color="#e91f62"
                                          v-model="editedUser.email"
                                          :rules="emailRules"
                                          required></v-text-field>
                            <v-row>
                                <v-col style="width:200px;">
                                    <v-switch
                                        v-model="editedUser.is_admin"
                                        label="Administrateur"
                                        color="#C90F54"
                                        hide-details
                                    ></v-switch>
                                </v-col>
                                <v-col>
                                    <v-switch
                                        v-model="editedUser.is_user"
                                        label="Juge"
                                        color="#C90F54"
                                        hide-details
                                    ></v-switch>
                                </v-col>
                            </v-row>

                        </v-card-text>
                    </v-form>
                    <v-divider></v-divider>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="secondary"
                            @click="editUserBox = false"
                        >
                            Annuler
                        </v-btn>
                        <v-btn
                            color="#e91f62"
                            @click="editUserConfirm(editedUser)"
                            :disabled="!editUserForm"
                            class="white--text"
                        >
                            Modifier
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-dialog
                v-model="editPasswordBox"
                width="500"
            >
                <v-card>
                    <v-card-title class="headline" primary-title style="background-color:#e91e63;">
                        <span style="color:white;">Modifier le mot de passe</span>
                        <v-spacer></v-spacer>
                        <v-btn text icon color="white" right @click="resetPassword()">
                            <v-icon large>close</v-icon>
                        </v-btn>
                    </v-card-title>
                    <v-form @submit.prevent="editPasswordUserConfirm()" v-model="changePasswordForm" ref="passwordForm">
                        <v-card-text>
                            <v-text-field id="password"
                                          prepend-icon="vpn_key"
                                          name="password"
                                          label="Mot de passe"
                                          type="password"
                                          color="#e91f62"
                                          v-model="newPassword"
                                          :rules="passwordRules"
                                          :append-icon="showPass ? 'visibility' : 'visibility_off'"
                                          :type="showPass ? 'text' : 'password'"
                                          @click:append="showPass = !showPass"
                                          class="input-group--focused"
                                          required></v-text-field>
                        </v-card-text>
                    </v-form>
                    <v-divider></v-divider>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="secondary"
                            @click="resetPassword()"
                        >
                            Annuler
                        </v-btn>
                        <v-btn
                            color="#e91f62"
                            @click="changePassword()"
                            :disabled="!changePasswordForm"
                            class="white--text"
                        >
                            Modifier
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </div>
        <h1 style="margin-bottom:20px;">Gestion des utilisateurs</h1>
        <v-card width="100%">
            <v-card-title>
                <v-icon x-large
                        color="black">
                    add_circle_outline
                </v-icon>
                &nbsp;Ajouter un utilisateur
            </v-card-title>
            <v-form @submit.prevent="addUser()" v-model="addUserForm" ref="userForm">
                <v-card-text>

                    <v-text-field
                        prepend-icon="face"
                        name="name"
                        label="Nom"
                        color="#e91f62"
                        v-model="name"
                        :rules="nameRules"
                        background-color="white"
                        required></v-text-field>
                    <v-select
                        v-model="spot_id"
                        :items="$store.state.spots"
                        item-text="name"
                        item-value="id"
                        id="spot_id"
                        prepend-icon="water_damage"
                        name="spot_id"
                        type="text"
                        color="#e91f62"
                        label="Plateau"
                        :rules="spotRules"
                        required
                    >
                    </v-select>
                    <v-text-field id="email"
                                  prepend-icon="email"
                                  name="email"
                                  label="Email"
                                  type="email"
                                  color="#e91f62"
                                  v-model="email"
                                  :rules="emailRules"
                                  required></v-text-field>

                    <v-text-field id="password"
                                  prepend-icon="vpn_key"
                                  name="password"
                                  label="Mot de passe"
                                  type="password"
                                  color="#e91f62"
                                  v-model="password"
                                  :rules="passwordRules"
                                  :append-icon="showPass ? 'visibility' : 'visibility_off'"
                                  :type="showPass ? 'text' : 'password'"
                                  @click:append="showPass = !showPass"
                                  class="input-group--focused"
                                  required></v-text-field>
                    <v-row>
                        <v-col style="width:200px;">
                            <v-switch
                                v-model="is_admin"
                                label="Administrateur"
                                color="#C90F54"
                                hide-details
                            ></v-switch>
                        </v-col>
                        <v-col>
                            <v-switch
                                v-model="is_user"
                                label="User"
                                color="#C90F54"
                                hide-details
                            ></v-switch>
                        </v-col>
                    </v-row>

                </v-card-text>
                <v-card-actions style="padding:20px;">
                    <v-spacer></v-spacer>
                    <v-btn color="#e91f62" type="submit" x-large :disabled="!addUserForm" class="white--text">
                        Enregistrer l'utilisateur
                    </v-btn>

                </v-card-actions>
            </v-form>
        </v-card>

        <v-card width="100%" style="margin-top:30px;">
            <v-card-title>
                <v-icon x-large
                        color="black">
                    account_box
                </v-icon>
                &nbspListe des utilisateurs
            </v-card-title>
            <v-list>
                <v-list-item-group
                >

                    <template v-for="(user, index) in $store.state.users">
                        <v-list-item two-line
                                     :key="user.id + '-user'"
                        >
                            <v-list-item-icon>
                                <v-icon>portrait</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title><strong> {{ user.name }} </strong>
                                    <v-chip
                                        class="ma-2" v-show="user.is_admin"
                                    >
                                        administrateur
                                        <v-icon right>
                                            security
                                        </v-icon>
                                    </v-chip>

                                    <v-chip
                                        class="ma-2"
                                        color="pink"
                                        label
                                        text-color="white"
                                    >
                                        <v-icon left>
                                            water_damage
                                        </v-icon>
                                        {{ getSpot(user.spot_id) }}
                                    </v-chip>
                                </v-list-item-title>
                                <v-list-item-subtitle v-text="user.email"></v-list-item-subtitle>
                            </v-list-item-content>
                            <v-list-item-action>
                                <div>
                                    <v-btn icon
                                           @click="editPasswordUser(user.id)">
                                        <v-icon color="grey lighten-1">vpn_key</v-icon>
                                    </v-btn>
                                    <v-btn icon
                                           @click="editUser(user.id)">
                                        <v-icon color="grey lighten-1">create</v-icon>
                                    </v-btn>
                                    <v-btn icon
                                           @click="deleteUser(user.id, user.name)">
                                        <v-icon color="grey lighten-1">delete</v-icon>
                                    </v-btn>
                                </div>
                            </v-list-item-action>

                        </v-list-item>
                        <v-divider
                            v-if="index < $store.state.users.length - 1"
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
    name: "users.vue",
    data: function () {
        return {
            showPass: false,
            addUserForm: false,
            editUserForm: false,
            changePasswordForm: false,
            name: "",
            email: "",
            password: "",
            spot_id: "",
            is_admin: false,
            is_user: true,
            deleteUserBox: false,
            deleteUserNameBox: "",
            editUserBox: false,
            editPasswordBox: false,
            userIdToDelete: "",
            editedUser: {},
            newPassword: "",
            newPasswordUserId: "",
            nameRules: [
                v => !!v || 'Le nom est obligatoire',
            ],
            emailRules: [
                v => !!v || 'L\'adresse mail est obligatoire',
            ],
            spotRules: [
                v => !!v || 'Ce champ est obligatoire',
            ],
            passwordRules: [
                v => !!v || 'Ce champ est obligatoire',
            ],
        }
    },
    methods: {
        addUser: function () {
            this.$store.dispatch('addUser', {
                name: this.name,
                email: this.email,
                password: this.password,
                is_admin: this.is_admin,
                is_user: this.is_user,
                spot_id: this.spot_id
            });
            this.$refs.userForm.reset();
        },
        getSpot: function (spotId) {
            return this.$store.state.spots.find(spot => spot.id === spotId).name;
        },
        deleteUser: function (userId, userName) {
            this.deleteUserBox = true;
            this.userIdToDelete = userId;
            this.deleteUserNameBox = userName;
        },
        deleteUserConfirm: function () {
            //this.$store.state.users.splice(userIdToDelete, 1);
            this.$store.dispatch('deleteUser', this.userIdToDelete);
            this.userIdToDelete = "";
            this.deleteUserBox = false;
        },
        editUser: function (userId) {
            let userData = this.$store.state.users.find(user => user.id === userId);
            this.editedUser = _.clone(userData);
            this.editUserBox = true;
        },
        editUserConfirm: function () {
            this.$store.dispatch('editUserConfirm', {
                id: this.editedUser.id,
                name: this.editedUser.name,
                email: this.editedUser.email,
                is_admin: this.editedUser.is_admin,
                is_user: this.editedUser.is_user,
                spot_id: this.editedUser.spot_id
            });
            this.editUserBox = false;
        },
        editPasswordUser: function (userId) {
            this.newPasswordUserId = userId;
            this.editPasswordBox = true;
        },
        changePassword: function () {
            this.$store.dispatch('changePassword', {id: this.newPasswordUserId, password: this.newPassword});
            this.editPasswordBox = false;
            this.newPasswordUserId = "";
            this.newPassword = "";

        },
        resetPassword: function () {

            this.editPasswordBox = false;
            this.newPasswordUserId = '';
            this.newPassword = ''
            this.$refs.passwordForm.reset();
        }
    }
}
</script>

<style>
input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus textarea:-webkit-autofill,
textarea:-webkit-autofill:hover textarea:-webkit-autofill:focus,
select:-webkit-autofill,
select:-webkit-autofill:hover,
select:-webkit-autofill:focus {
    -webkit-box-shadow: 0 0 0px 30px #ffffff inset !important;
}
</style>
