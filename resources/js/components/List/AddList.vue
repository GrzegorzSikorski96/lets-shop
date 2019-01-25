<template>
    <v-dialog v-model="$parent.addListDialog" max-width="500px">
        <v-card>
            <v-card-text>
                <h1 class="brown--text">Dodaj listę</h1>
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
                <v-btn color="red darken-1" flat @click="$parent.addListDialog = false">Anuluj</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import Vue from 'vue'

    export default {
        name: "AddList",
        data() {
            return {
                name: null,
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
                            name: this.name,
                        };

                        this.$http.post(`/api/list/${this.group.id}`, data)
                            .then(response => {
                                Vue.toasted.show(response.data.message, {
                                    type: 'success'
                                });
                                this.$parent.fetchLists();
                            })
                            .catch(error => {
                                Vue.toasted.show(error.data.message, {
                                    type: 'error'
                                });
                            });
                    }
                });
                this.$parent.addGroupDialog = false;
            },
            clearForm(){
                this.name = null;
            }
        },
    }
</script>

<style scoped>

</style>