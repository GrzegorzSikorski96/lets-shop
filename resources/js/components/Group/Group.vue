<template>
    <v-flex xs12 sm6 offset-sm3>
        <v-card>
            <v-card-title primary-title>
                <div>
                    <h3 class="headline mb-0">{{ group.name }}</h3>
                </div>
            </v-card-title>
            <v-expansion-panel>
                <v-expansion-panel-content
                        v-for="(list, i) in lists"
                        :key="i"
                >
                    <div slot="header">{{ list.name }}</div>
                    <v-card>
                        <v-card-text>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</v-card-text>
                    </v-card>
                </v-expansion-panel-content>
            </v-expansion-panel>
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
                <v-icon>account_circle</v-icon>
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
             <!--<v-btn
                     fab
                     dark
                     small
                     color="info"
                     @click="editCalendar(calendar)"
             >
                 <v-icon>edit</v-icon>
             </v-btn>-->
            <v-btn
                    fab
                    dark
                    small
                    color="error"
                    @click="removeGroup(group)"
            >
                <v-icon>delete</v-icon>
            </v-btn>
        </v-speed-dial>

        <remove-group v-if="removeGroupDialog" :group="group"></remove-group>
        <add-user v-if="addUserDialog" :group="group"></add-user>
    </v-flex>
</template>

<script>
    import RemoveGroup from "./RemoveGroup";
    import AddUser from "./AddUser";

    export default {
        name: "Group",
        methods: {
            removeGroup(group) {
                this.group = Object.assign({}, group);
                this.removeGroupDialog = true;
            },
            addUser(group) {
                this.group = Object.assign({}, group);
                this.addUserDialog = true;
            },
            async fetchGroup() {
                this.$http.get(`api/group/${this.$route.params.id}`).then((response) => {
                    this.group = response.data.data.group
                });
            },
            async fetchGroups() {
                this.$store.dispatch('getGroups');
            },
        },
        data: () => ({
            group: [],
            lists: [{
                name: "tes",
            }],
            removeGroupDialog: false,
            addUserDialog: false,
        }),
        components: {
            RemoveGroup,
            AddUser
        },
        mounted() {
            if (this.currentUser) {
                this.fetchGroup();
            }

        },
        watch: {
            $route(to, from) {
                this.fetchGroup();
            },

        }
    }
</script>

<style scoped>

</style>