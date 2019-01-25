<template>
    <section id="sidebar-menu">
        <v-toolbar flat class="transparent" v-if="currentUser">
            <v-list class="pa-0">
                <v-list-tile avatar>
                    <v-list-tile-avatar>
                        <img src="https://randomuser.me/api/portraits/men/85.jpg">
                    </v-list-tile-avatar>

                    <v-list-tile-content>
                        <v-list-tile-title class=" font-weight-medium"> {{ currentUser.name }}</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-toolbar>

        <v-divider></v-divider>

        <v-list class="pa-0">
            <v-layout v-for="visitorRoute in visitorRoutes"
                      :key="visitorRoutes.label">
                <v-flex>
                    <router-link :to="{name: visitorRoute.name}" class="route black--text">
                        <v-list-tile @click="" :ripple="{ class: 'brown--text'}">
                            <v-list-tile-action>
                                <v-icon>{{ visitorRoute.icon }}</v-icon>
                            </v-list-tile-action>

                            <v-list-tile-content>
                                <v-list-tile-title text-colo class="font-weight-medium">
                                    {{ visitorRoute.label }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </router-link>
                </v-flex>
            </v-layout>

            <v-layout v-if="currentUser" v-for="authRoute in authRoutes"
                      :key="visitorRoutes.label">
                <v-flex>
                    <router-link :to="{name: authRoute.name}" class="route black--text">
                        <v-list-tile @click="" :ripple="{ class: 'brown--text' }">
                            <v-list-tile-action>
                                <v-icon>{{ authRoute.icon }}</v-icon>
                            </v-list-tile-action>

                            <v-list-tile-content>
                                <v-list-tile-title class=" font-weight-medium">
                                    {{ authRoute.label }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </router-link>
                </v-flex>
            </v-layout>

            <v-list-group
                    prepend-icon="group"
                    no-action
                    value="true"
                    v-if="currentUser"
            >
                <v-list-tile slot="activator">
                    <v-list-tile-title>Grupy</v-list-tile-title>
                </v-list-tile>

                <v-list-tile @click="addGroupDialog = true" color="success">
                    <v-list-tile-title>Dodaj grupę</v-list-tile-title>
                    <v-list-tile-action>
                        <v-icon color="success">fas fa-plus</v-icon>
                    </v-list-tile-action>
                </v-list-tile>

                <v-list-tile v-for="(group, i) in groups"
                             :key="i" :to="{name: 'Group', params: { id: group.id}}">
                    <v-list-tile-title>{{ group.name }}</v-list-tile-title>
                    <v-list-tile-action>
                        <v-icon>keyboard_arrow_right</v-icon>
                    </v-list-tile-action>
                </v-list-tile>
            </v-list-group>


            <v-layout v-if="currentUser">
                <v-flex>
                    <v-list-tile @click="logout" class="route error--text" ripple>
                        <v-list-tile-action>
                            <v-icon class="error--text">fas fa-sign-out-alt</v-icon>
                        </v-list-tile-action>

                        <v-list-tile-content>
                            <v-list-tile-title class=" font-weight-medium">
                                Wyloguj
                            </v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-flex>
            </v-layout>

            <v-layout v-else fill-height>
                <v-flex align-end>
                    <router-link :to="{name: 'Login'}" class="route success--text">
                        <v-list-tile @click="" ripple>
                            <v-list-tile-action>
                                <v-icon color="success">fas fa-sign-in-alt</v-icon>
                            </v-list-tile-action>

                            <v-list-tile-content>
                                <v-list-tile-title class=" font-weight-medium">
                                    Zaloguj
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </router-link>

                    <router-link :to="{name: 'Register'}" class="route info--text">
                        <v-list-tile @click="" ripple>
                            <v-list-tile-action>
                                <v-icon color="info">fas fa-user-plus</v-icon>
                            </v-list-tile-action>

                            <v-list-tile-content>
                                <v-list-tile-title class=" font-weight-medium">
                                    Zarejestruj
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </router-link>
                </v-flex>
            </v-layout>
        </v-list>

        <add-group></add-group>
    </section>
</template>

<script>
    import AddGroup from "../Group/AddGroup";

    export default {
        name: "NavigationDrawerItems",
        methods: {
            logout() {
                this.$store.commit('logout');
                this.$router.push('/login');
            },
            async fetchGroups() {
                this.$store.dispatch('getGroups');
            },
        },
        components:{
          AddGroup
        },
        data: () => ({
            drawer: true,

            addGroupDialog: false,

            authRoutes: [],
            visitorRoutes: [
                {label: 'Strona główna', name: 'HomePage', icon: 'home'},
            ],
        }),
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            },
            groups() {
                return this.$store.getters.getGroups;
            },
        },
        mounted() {
            if (this.currentUser) {
                this.$store.dispatch('getGroups');
            }
        },
        watch: {
            currentUser() {
                this.fetchGroups();
            },
        }
    }
</script>

<style scoped>
    .route {
        text-decoration: none;
    }
</style>