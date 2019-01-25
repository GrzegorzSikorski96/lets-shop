<template>
    <v-dialog v-model="$parent.addGroupDialog" max-width="500px">
        <v-card>
            <v-card-text>
                <h1 class="brown--text">Dodaj grupę</h1>
                <v-container grid-list-md>
                    <v-form @keyup.native.enter="add()" class="form">
                        <v-text-field
                                v-validate.in="'required'"
                                v-model="name"
                                :error-messages="errors.collect('nazwa')"
                                label="Nazwa"
                                data-vv-name="nazwa"
                                required>
                        </v-text-field>
                    </v-form>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="success darken-1" flat @click="add()">Dodaj</v-btn>
                <v-btn color="red darken-1" flat @click="$parent.addGroupDialog = false">Anuluj</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import Vue from 'vue'

    export default {
        name: "AddGroup",
        data() {
            return {
                name: null,
            }
        },
        methods: {
            add() {
                this.$validator.validate().then(result => {
                    if (result) {
                        let data = {
                            name: this.name,
                        };

                        this.$http.post("/api/group", data)
                            .then(response => {
                                Vue.toasted.show(response.data.message, {
                                    type: 'success'
                                });
                            })
                            .catch(error => {
                                Vue.toasted.show(response.data.message, {
                                    type: 'error'
                                });
                            })
                    }
                });
                this.$parent.addGroupDialog = false;
            },
        },
    }
</script>

<style scoped>

</style>