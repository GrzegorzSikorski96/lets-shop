<template>
    <v-dialog v-model="$parent.addProductDialog" max-width="500px">
        <v-card>
            <v-card-text>
                <h1 class="brown--text">Dodaj produkt</h1>
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

                        <v-select
                                :items="this.$parent.categories"
                                item-text="name"
                                :error-messages="errors.collect('kateogia')"
                                label="Kategoria"
                                data-vv-name="kategoria"
                                v-model="category"
                                item-value="id"
                        ></v-select>

                        <v-select
                                :items="this.$parent.shops"
                                item-text="name"
                                :error-messages="errors.collect('sklep')"
                                label="Sklep"
                                data-vv-name="sklep"
                                v-model="shop"
                                item-value="id"
                        ></v-select>

                        <v-text-field
                                label="Ilość"
                                v-model="count"
                                data-vv-name="count"
                        ></v-text-field>
                        <v-text-field
                                label="Opis"
                                v-model="description"
                                data-vv-name="description"
                        ></v-text-field>
                    </v-form>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="success darken-1" flat @click="add()">Dodaj</v-btn>
                <v-btn color="red darken-1" flat @click="$parent.addProductDialog = false">Anuluj</v-btn>
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
                description: null,
                category: [],
                shop: null,
                count: null,
                unit_type: null,
            }
        },
        methods: {
            add() {
                this.$validator.validate().then(result => {
                    if (result) {
                        alert(this.category);
                        let data = {
                            name: this.name,
                            description: this.description,
                            shop_list_id: this.$parent.list.id,
                            category_id: this.category,
                            shop_id: this.shop,
                            count: this.count,
                        };

                        this.$http.post("/api/product", data)
                            .then(response => {
                                Vue.toasted.show(response.data.message, {
                                    type: 'success'
                                });
                                this.$parent.fetchList();
                            })
                            .catch(error => {
                                Vue.toasted.show(error.data.message, {
                                    type: 'error'
                                });
                            });
                    }
                });
                this.$parent.addProductDialog = false;
            },
            clearForm(){
                this.name = null;
            }
        },
        computed:{
            unit(){
                return this.category.unit_type
            }
        }
    }
</script>

<style scoped>

</style>