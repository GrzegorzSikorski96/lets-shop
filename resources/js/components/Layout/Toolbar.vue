<template>
    <v-toolbar color="#005169" dense dark fixed app class="navbar">
        <slot></slot>
        <router-link class="title" :to="{name: 'HomePage'}">
            <v-toolbar-title class="title white--text" fill-width>
                Lets-shop
            </v-toolbar-title>
        </router-link>
    </v-toolbar>
</template>

<script>
    export default {
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