<template>
    <v-app id="sample">
        <v-main>
            <sidebar id="sidebar"></sidebar>
            <v-container class="container" fluid>
                <router-view>
                </router-view>
            </v-container>
            <h1>{{ user.role.name }}</h1>
        </v-main>
    </v-app>
</template>
<script>
import Vuetify from "vuetify";
import sidebar from "./modules/sidebar.vue";
export default {
    name: "app",
    props: ['user'],
    components: {
        sidebar
        // dashboard
    },
    mounted(){
        this.setUserType()
    },
    methods: {
        setUserType(){
            localStorage.setItem('user_type', this.user.role.name)
        }
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
