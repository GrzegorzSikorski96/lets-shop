<template>
    <v-dialog v-model="$parent.groupUsersDialog" max-width="500px">
    <v-card>
        <v-card-title primary-title>
            <div>
                <h3 class="headline mb-0">Użytkownicy</h3>
            </div>
        </v-card-title>

        <v-btn block color="secondary" dark v-for="(user, i) in this.$parent.users"
               :key="i" flat>{{ user.name }} {{ user.email }}
            <v-spacer></v-spacer>
            <v-btn falt icon>
                <v-icon>delete</v-icon>
            </v-btn>
        </v-btn>

        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="red darken-1" flat @click="$parent.groupUsersDialog = false">Zamknij</v-btn>
        </v-card-actions>
    </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: "GroupUsers",
        methods: {
        }
    }
</script>

<style scoped>

</style>