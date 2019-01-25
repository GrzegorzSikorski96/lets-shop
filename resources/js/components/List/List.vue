<template>
    <v-flex xs12 sm6 offset-sm3>
        <v-card>
            <v-card-title primary-title>
                <div>
                    <h3 class="headline mb-0">{{ list.name }}</h3>
                </div>
            </v-card-title>

                <v-card v-if="products.length > 0">
                    <v-slide-y-transition
                            class="py-0"
                            group
                            tag="v-list"
                    >
                        <template v-for="(product, i) in products">
                            <v-divider
                                    v-if="i !== 0"
                                    :key="`${i}-divider`"
                            ></v-divider>

                            <v-list-tile :key="`${i}-${product.name}`">
                                <v-list-tile-action>
                                    <v-checkbox
                                            v-model="product.status"
                                            color="info darken-3"
                                            @change="changeStatus(product.id)"
                                    >
                                        <div
                                                slot="label"
                                                :class="product.status && 'grey--text' || 'text--primary'"
                                                class="ml-3"
                                                v-text="generateLabel(product)"
                                        ></div>
                                    </v-checkbox>
                                </v-list-tile-action>

                                <v-spacer></v-spacer>
                                <v-scroll-x-transition>
                                    <v-icon
                                            v-if="product.status"
                                            color="success"
                                    >
                                        check
                                    </v-icon>
                                </v-scroll-x-transition>
                                <v-btn flat icon :href="`https://www.google.com/search?q=${product.name}&source=lnms&tbm=isch`">
                                    <v-icon >photo</v-icon>
                                </v-btn>
                            </v-list-tile>
                        </template>
                    </v-slide-y-transition>
                </v-card>

        </v-card>
        <v-speed-dial
                top
                right
                fixed
                direction="bottom"
                transition="slide-y-transition"
        >
            <v-btn
                    slot="activator"
                    color="#314b49"
                    dark
                    fab
            >
                <v-icon>menu</v-icon>
                <v-icon>close</v-icon>
            </v-btn>
            <v-btn
                    fab
                    dark
                    small
                    color="info"
                    @click="addProduct(list)"
            >
                <v-icon>playlist_add</v-icon>
            </v-btn>
            <v-btn
                    fab
                    dark
                    small
                    color="error"
                    @click="removeList(list)"
            >
                <v-icon>delete</v-icon>
            </v-btn>
            <v-btn
                    fab
                    dark
                    small
                    color="error"
                    @click="fetchList()"
            >
                <v-icon>refresh</v-icon>
            </v-btn>
        </v-speed-dial>

        <add-product v-if="addProductDialog" :list="list"></add-product>
        <remove-list v-if="removeListDialog" :list="list"></remove-list>
    </v-flex>
</template>

<script>
    import RemoveList from "./RemoveList";
    import AddProduct from "./AddProduct";

    export default {
        name: "List",
        methods: {
            addProduct(list) {
                this.list = Object.assign({}, list);
                this.addProductDialog = true;
            },
            removeList(list) {
                this.list = Object.assign({}, list);
                this.removeListDialog = true;
            },
            async fetchList() {
                this.$http.get(`api/list/${this.$route.params.id}`).then((response) => {
                    this.list = response.data.data.list;
                    this.products = response.data.data.products;
                    this.shops = response.data.data.shops;
                    this.categories = response.data.data.categories;
                });
            },
            async changeStatus(id) {
                let data = {
                    product_id: id,
                };

                this.$http.post("/api/product/check", data)
                    .then(response => {
                        Vue.toasted.show(response.data.message, {
                            type: 'success'
                        });
                    });
            },
            generateLabel(product) {
                let label = '';

                if(product.name) {
                    label += product.name + " ";
                }

                if(product.category_name) {
                    label += product.category_name + " ";
                }

                if(product.count) {
                    label += product.count;
                }

                if(product.unit_type) {
                    label += product.unit_type + " ";
                }

                if(product.shop_name) {
                    label += product.shop_name + " ";
                }

                if(product.description) {
                    label += product.description;
                }

                return label;
            }
        },
        data: () => ({
            list: [],
            products: [],
            shops: [],
            categories: [],
            addProductDialog: false,
            removeListDialog: false,
        }),
        components: {
            AddProduct,
            RemoveList
        },
        mounted() {
            if (this.currentUser) {
                this.fetchList();
            }

        },
        watch: {
            $route(to, from) {
                this.fetchList();
            },
        },
    }
</script>

<style scoped>

</style>