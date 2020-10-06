<template>
    <v-main>
        <sidebar id="sidebar" />
        <v-container class="fill-height" fluid>
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
 #sidebar{
     position: absolute;
 }
</style>
