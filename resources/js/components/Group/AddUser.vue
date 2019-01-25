<template>
    <v-dialog v-model="$parent.addUserDialog" max-width="500px">
        <v-card>
            <v-card-text>
                <h1 class="brown--text">Dodaj użytkownika</h1>
                <v-container grid-list-md>
                    <v-form @keyup.native.enter="add()" class="form">
                        <v-text-field
                                v-validate.in="'required|email'"
                                v-model="email"
                                :error-messages="errors.collect('email')"
                                label="Email"
                                data-vv-name="email"
                                required>
                        </v-text-field>
                    </v-form>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="success darken-1" flat @click="add()">Dodaj</v-btn>
                <v-btn color="red darken-1" flat @click="$parent.addUserDialog = false">Anuluj</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import Vue from 'vue'

    export default {
        name: "AddUser",
        data() {
            return {
                email: null,
            }
        },
        props: {
            group: {type: Object},
        },
        methods: {
            add() {
                this.$validator.validate().then(result => {
                    if (result) {
                        let data = {
                            email: this.email,
                        };

                        this.$http.post(`/api/invite/${this.group.id}`, data)
                            .then(response => {
                                Vue.toasted.show(response.data.message, {
                                    type: 'success'
                                });
                            })
                            .catch(error => {
                                Vue.toasted.show(error.data.message, {
                                    type: 'error'
                                });
                            })
                    }
                });
                this.$parent.addEventDialog = false;
            },
            clearForm(){
                this.email = null;
            }
        },
    }
</script>

<style scoped>

</style>