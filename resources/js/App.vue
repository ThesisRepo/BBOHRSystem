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
    data(){
        return {
            user_id: localStorage.getItem("id")
        }
    },
    created() {
        this.setUserType();
        // this.listenForChanges();
    },
    mounted(){
        console.log(this.user);
        var params = {  
            user_id:1,
            status_id:3,
        };
        
        this.$axios
        .get(
          "http://localhost:8000/user_info/pending_requests/count/" + this.user_id)
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
                // console.log(element.role_name)
                roleList.push(element.role_name)
                // element.role_name
            });
            // this.user.assigned_prp ? localStorage.setItem('assigned_prp_id', this.user.assigned_prp.id) : localStorage.setItem('assigned_prp_id', 'No Prp assign')
            // this.user.assigned_finance.first_name + ' ' + this.user.assigned_finance.last_name ? localStorage.setItem('user_finance', this.user.assigned_finance.first_name + ' ' + this.user.assigned_finance.last_name) : localStorage.setItem('user_finance', 'No Finance assign')
            localStorage.setItem('user_pic', this.user.user_information.profile_url)
            this.user.assigned_prp ? localStorage.setItem('prp_assign', this.user.assigned_prp.first_name + ' ' + this.user.assigned_prp.last_name) : localStorage.setItem('prp_assign', 'No Prp assign')
            localStorage.setItem('user_department', this.user.user_information.department.department_name)
            localStorage.setItem('user_type', roleList)
            localStorage.setItem('id', this.user.id)
            localStorage.setItem('user_name', this.user.first_name + " " + this.user.last_name)
            localStorage.setItem('email', this.user.email)
            localStorage.setItem('company_id', this.user.user_information.company_number)
        },
        listenForChanges() {
        console.log('listening');
        Echo.private('newrequest.' + this.user.id)
          .listen('NewRequest', notif => {
            console.log('NewRequest', notif)
            if (! ('Notification' in window)) {
              alert('Web Notification is not supported');
              return;
            }
            console.log('res', notif);
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
        // listenForChanges() {
        // console.log('listening');
        // Echo.private('newrequest.' + this.id)
        //   .listen('NewRequest', notif => {
        //     console.log('NewRequest', notif)
        //     if (! ('Notification' in window)) {
        //       alert('Web Notification is not supported');
        //       return;
        //     }
        //     console.log('res', notif);
        //     Notification.requestPermission( permission => {
        //       let notification = new Notification('New Notificaion from BBO Request Management!', {
        //         body: notif.message, // content for the alert
        //         icon: "https://pusher.com/static_logos/320x320.png" // optional image url
        //       });

        //       // link to page on clicking the notification
        //       notification.onclick = () => {
        //         window.open(window.location.href);
        //       };
        //     });
        //   })
        // }
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

