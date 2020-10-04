<template>
    <v-main>
        <sidebar id="sidebar"></sidebar>
        <v-container class="container" fluid>
            <router-view>
            </router-view>
        </v-container>
    </v-main>
</template>
<script>
import Vuetify from "vuetify";
import sidebar from "./modules/sidebar.vue";
export default {
    name: "app",
    components: {
        sidebar
        // dashboard
    }
}
</script>  
<style>
v-main {
    background-color: black;
}
#sidebar{
    position:absolute;
}
</style>
