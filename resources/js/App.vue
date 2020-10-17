<template>
    <v-app id="sample">
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
        this.setUserType();
        var params = {
            prp_assigned_id:5,
            user_id:4,
            reason:'hdfddaman',
            shift_date: '2020-10-10',
            shift_time: '7-8pm',
        };
        
        this.$axios
        .get(
          "http://localhost:8000/shift_change_request/4")
        .then(response => {
        //   if (response.data === 1) {
        //     this.$parent.$parent.getInfo()
        //     this.dialog = false
        //   } else {      
        //     this.$parent.$parent.getInfo()
        //   }
        })
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
