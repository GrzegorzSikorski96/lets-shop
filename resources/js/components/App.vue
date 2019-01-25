<template>
    <section id="main">
        <v-app>
            <v-navigation-drawer
                    fixed
                    v-model="drawer"
                    app
            >
                <navigation-drawer-items fill-height></navigation-drawer-items>
            </v-navigation-drawer>

            <toolbar>
                <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
            </toolbar>
            <v-content class="view" align-center fluid fill-height>
                <v-container fluid fill-height>
                    <v-layout align-center justify-center>
                        <v-flex>
                            <router-view>
                            </router-view>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-content>
            <bottom></bottom>
        </v-app>
    </section>
</template>

<script>
    import Toolbar from './Layout/Toolbar';
    import Bottom from './Layout/Footer';
    import NavigationDrawerItems from "./Layout/NavigationDrawerItems";

    export default {
        name: 'App',
        data: () => ({
            drawer: false,
        }),
        components: {
            NavigationDrawerItems,
            Toolbar,
            Bottom,
        },
        methods: {
            logout() {
                this.$store.commit('logout');
                this.$router.push('/login');
            },
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            },
        },
    }
</script>

<style lang="scss" scoped>
    #app {
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        display: flex;
        min-height: 95vh;
        flex-direction: column;
        text-align: center;
    }

    .view {
        background-image: url("./../assets/background.jpg");
        background-position: center;
        background-attachment: fixed;
        background-size: cover;
        flex: 1;
    }

    .nav {
        z-index: 5;
    }
</style>