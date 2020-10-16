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
        // var params = {
        //     leave_type_id:1,
        //     start_date: '2020-10-10',
        //     end_date: '2020-10-10',
        //     number_of_days: 7
        // };
        
        this.$axios
        .get(
          "http://localhost:8000/leave_request/4"
        )
        .then(response => {
          if (response.data === 1) {
            this.$parent.$parent.getInfo()
            this.dialog = false
          } else {      
            this.$parent.$parent.getInfo()
          }
        })
    },
    methods: {
        setUserType(){
            var roleList=[]
            this.user.roles.forEach(element => {
                console.log(element.role_name)
                roleList.push(element.role_name)
                // element.role_name
            });
            console.log(this.user.roles)
            localStorage.setItem('user_type', roleList)
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
