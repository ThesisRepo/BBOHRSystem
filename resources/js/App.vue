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
// import { constants } from 'fs';
export default {
    name: "app",
    props: ['user'],
    components: {
        sidebar
        // dashboard
    },
    data(){
        return {
            user_id: localStorage.getItem("id")
        }
    },
    created() {
        this.setUserType();
    },
    mounted(){
        this.listenForChanges();
        console.log(this.user);
        //  var params = {   
        //     first_name: 'mddion',
        //     last_name: 'balugo',
        //     email: 'sssssdfefs@gail.com',
        //     password: '123456789',
        //     password_confirmation: '123456789',
        //     role_id: 2,        
        //     department_id :  1, 
        //     shift_time_id: 1,
        //     gender: 1,
        //     company_number: '123456',
        //     profile_url: null,
        //     date_hired: '2020-12-12',
        //     company_status:'regular',
        //     birthday: '2020-10-10',
        //     allowed_leave_number: 10,
        //     address: 'paa, hilongos, leyte',
        //     civil_status: 'single',
        //     contact_number: '012346481',
        //     pag_ibig_number:'12313',
        //     sss_number:'1563',
        //     tin_number:'146512',
        //     philhealth_number:'561'
        // }
        // this.$axios
        // .post(
        //   "http://localhost:8000/hr/manage/user", params)
        // .then(response => {
        //     console.log('dat', response)
        //   if (response.data === 1) {

        //     this.$parent.$parent.getInfo()
        //     this.dialog = false
        //   } else {      
        //     this.$parent.$parent.getInfo()
        //   }
        // })
    },
    methods: {
        setUserType(){
            var roleList=[]
            this.user.roles.forEach(element => {
                // console.log(element.role_name)
                roleList.push(element.role_name)
                // element.role_name
            });
            this.user.user_information ? localStorage.setItem('leave_number', this.user.user_information.allowed_leave_number) : localStorage.setItem('leave_number', 0)
            this.user.assigned_prp ? localStorage.setItem('assigned_prp_id', this.user.assigned_prp.id) : localStorage.setItem('assigned_prp_id', 'No Prp assign')
            this.user.assigned_finance ? localStorage.setItem('user_finance', this.user.assigned_finance.first_name + ' ' + this.user.assigned_finance.last_name) : localStorage.setItem('user_finance', 'No Finance assign')
            this.user.user_information ? localStorage.setItem('user_pic', this.user.user_information.profile_url) : ''
            this.user.assigned_prp ? localStorage.setItem('prp_assign', this.user.assigned_prp.first_name + ' ' + this.user.assigned_prp.last_name) : localStorage.setItem('prp_assign', 'No Prp assign')
            this.user.user_information ? localStorage.setItem('user_department', this.user.user_information.department.department_name) : ''
            localStorage.setItem('user_type', roleList)
            localStorage.setItem('id', this.user.id)
            this.user ? localStorage.setItem('user_name', this.user.first_name + " " + this.user.last_name) : ''
            localStorage.setItem('email', this.user.email)
            this.user.user_information ? localStorage.setItem('company_id', this.user.user_information.company_number) : ''
        },
        listenForChanges() {
        console.log('listening');
        Echo.private('newrequest.' + this.user.id)
          .listen('NewRequest', notif => {
            // console.log('NewRequest', notif)
            if (! ('Notification' in window)) {
              alert('Web Notification is not supported');
              return;
            }
            Notification.requestPermission( permission => {
              let notification = new Notification('New Notificaion from BBO Request Management!', {
                body: notif.message, // content for the alert
                icon: "https://pusher.com/static_logos/320x320.png" // optional image url
              });

              // link to page on clicking the notification
              notification.onclick = () => {
                window.open(window.location.href);
              };
            });
          })
        }
    }
}
</script>  
<style>
@import url('https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap');
v-main {
    background-color: black;
}
#sidebar{
    position:absolute;
}

</style>

