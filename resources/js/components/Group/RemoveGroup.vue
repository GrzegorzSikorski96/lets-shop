<template>
    <v-dialog v-model="$parent.removeGroupDialog" max-width="500px">
        <v-card>
            <v-card-text>
                <h1 class="brown--text">Usuń grupę</h1>
                <v-container grid-list-md>
                    Czy napewno chcesz usunąć grupę <strong>{{ group.name }}</strong>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red darken-1" flat @click="remove()">Usuń</v-btn>
                <v-btn color="darken-1" flat @click="$parent.removeGroupDialog = false">Anuluj</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: "RemoveGroup",
        props: {
            group: {type: Object},
        },
        methods: {
            remove() {
                this.$http.post(`/api/group/${this.group.id}/remove`)
                    .then(response => {
                        this.$parent.fetchGroups();
                        this.$router.push({ name: 'HomePage'});

                        this.$toasted.show(response.data.message, {
                            type: 'success'
                        });
                        this.$parent.fetchGroups();
                    })
                    .catch(error => {
                        this.$toasted.show(error.data.message, {
                            type: 'error'
                        });
                    });
                this.$parent.removeGroupDialog = false;
            },
        }
    }
</script>

<style scoped>

</style>