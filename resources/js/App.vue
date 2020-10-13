<template>
    <v-app id="sample">
        <!-- <h1>{{user}}</h1> -->
        <v-main>
            <sidebar id="sidebar"></sidebar>
            <v-container class="container" fluid>
                <router-view>
                </router-view>
            </v-container>
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
            localStorage.setItem('user_type', this.user.roles[0].role_name)
            localStorage.setItem('id', this.user.id)
            localStorage.setItem('user_name', this.user.first_name + " " + this.user.last_name)
            localStorage.setItem('email', this.user.email)
            localStorage.setItem('company_id', this.user.user_information.company_number)
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
