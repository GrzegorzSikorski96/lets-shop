<template>
    <v-dialog v-model="$parent.removeListDialog" max-width="500px">
        <v-card>
            <v-card-text>
                <h1 class="brown--text">Usuń listę</h1>
                <v-container grid-list-md>
                    Czy napewno chcesz usunąć listę <strong>{{ list.name }}</strong>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red darken-1" flat @click="remove()">Usuń</v-btn>
                <v-btn color="darken-1" flat @click="$parent.removeListDialog = false">Anuluj</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: "RemoveList",
        props: {
            list: {type: Object},
        },
        methods: {
            remove() {
                this.$http.post(`/api/list/remove/${this.list.id}`)
                    .then(response => {
                        this.$router.push({ name: 'HomePage'});

                        this.$toasted.show(response.data.message, {
                            type: 'success'
                        });
                    })
                    .catch(error => {
                        this.$toasted.show(error.data.message, {
                            type: 'error'
                        });
                    });
                this.$parent.removeListDialog = false;
            },
        }
    }
</script>

<style scoped>

</style>