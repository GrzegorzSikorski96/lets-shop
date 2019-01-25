<template>
    <v-flex xs12 sm6 offset-sm3>
        <v-card>
            <v-card-title primary-title>
                <div>
                    <h3 class="headline mb-0">{{ group.name }}</h3>
                </div>
            </v-card-title>

            <v-btn block color="secondary" dark v-for="(list, i) in lists" :to="{name: 'List', params: { id: list.id}}"
                   :key="i" flat>{{ list.name }} <v-spacer></v-spacer><v-icon>keyboard_arrow_right</v-icon>
            </v-btn>
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
                    color="success"
                    @click="addUser(group)"
            >
                <v-icon>person_add</v-icon>
            </v-btn>
            <v-btn
                    fab
                    dark
                    small
                    color="info"
                    @click="addList(group)"
            >
                <v-icon>playlist_add</v-icon>
            </v-btn>
            <v-btn
                    fab
                    dark
                    small
                    color="info"
                    @click="groupUsers()"
            >
                <v-icon>person</v-icon>
            </v-btn>
            <v-btn
                    fab
                    dark
                    small
                    color="error"
                    @click="removeGroup(group)"
            >
                <v-icon>delete</v-icon>
            </v-btn>
            <v-btn
                    fab
                    dark
                    small
                    color="error"
                    @click="refresh()"
            >
                <v-icon>refresh</v-icon>
            </v-btn>
        </v-speed-dial>

        <remove-group v-if="removeGroupDialog" :group="group"></remove-group>
        <add-user v-if="addUserDialog" :group="group"></add-user>
        <add-list v-if="addListDialog" :group="group"></add-list>
        <group-users v-if="groupUsersDialog"></group-users>
    </v-flex>
</template>

<script>
    import RemoveGroup from "./RemoveGroup";
    import AddUser from "./AddUser";
    import AddList from "../List/AddList";
    import GroupUsers from "./GroupUsers";

    export default {
        name: "Group",
        methods: {
            refresh()
            {
                this.fetchGroup();
                this.fetchLists();
            },
            removeGroup(group) {
                this.group = Object.assign({}, group);
                this.removeGroupDialog = true;
            },
            addUser(group) {
                this.group = Object.assign({}, group);
                this.addUserDialog = true;
            },
            addList(group) {
                this.group = Object.assign({}, group);
                this.addListDialog = true;
            },
            groupUsers() {
                this.groupUsersDialog = true;
            },
            fetchGroup() {
                this.$http.get(`api/group/${this.$route.params.id}`).then((response) => {
                    this.group = response.data.data.group
                });
            },
            fetchUsers() {
                this.$http.get(`api/group/${this.$route.params.id}/users`).then((response) => {
                    this.users = response.data.data.users
                });
            },
            async fetchGroups() {
                this.$store.dispatch('getGroups');
            },
            async fetchLists() {
                this.$http.get(`api/lists/${this.$route.params.id}`).then((response) => {
                    this.lists = response.data.data.lists
                });
            },
        },
        data: () => ({
            group: [],
            users: [],
            lists: [],
            removeGroupDialog: false,
            addUserDialog: false,
            addListDialog: false,
            groupUsersDialog: false,
        }),
        components: {
            RemoveGroup,
            AddUser,
            AddList,
            GroupUsers
        },
        mounted() {
            if (this.currentUser) {
                this.fetchGroup();
                this.fetchLists();
                this.fetchUsers();
            }

        },
        watch: {
            $route(to, from) {
                this.fetchGroup();
                this.fetchLists();
            },

        }
    }
</script>

<style scoped>

</style>