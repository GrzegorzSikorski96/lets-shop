<template>
    <v-toolbar color="#ab8464" dense dark fixed app class="navbar">
        <slot></slot>
        <router-link class="title" :to="{name: 'HomePage'}">
            <v-toolbar-title class="title white--text" fill-width>
                Kalendarze
            </v-toolbar-title>
        </router-link>
    </v-toolbar>
</template>

<script>
    export default {
        methods: {
            isAdmin() {
                return currentUser.role.name === 'ADMIN' || currentUser.role.name === 'SUPERADMIN';
            }
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            }
        },
    }
</script>

<style lang="scss">
    .title {
        font-weight: bold;
        text-decoration: none;
    }

    .route {
        text-decoration: none;
    }
</style>