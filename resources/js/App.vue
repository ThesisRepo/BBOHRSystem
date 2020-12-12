<template>
 <v-app id="sample">
        <!-- <h1>{{user}}</h1> -->
        <v-main>
            <v-container class="container" fluid>
                <sidebar id="sidebar"></sidebar>
                <router-view>
                </router-view>
                <Loading v-if="loading"></Loading>
            </v-container>
        </v-main>
        
    </v-app>
</template>
<script>
import Vuetify from "vuetify";
import sidebar from "./modules/sidebar.vue";
import Loading from "./components/Loading.vue";
import { mapGetters } from "vuex";

export default {
    name: "app",
    props: ['user'],
    components: {
        sidebar,
        Loading
    },
    data(){
        return {
            user_id: localStorage.getItem("id"),
            loading:  this.$store.getters.isLoading,
        }
    },
    created() {
        this.setUserType();
    },
    computed: {
        ...mapGetters(["isLoading"])
    },
    watch: {
        isLoading: function(newVal) {
            this.loading = newVal;
        },
    },
    mounted(){
        this.listenForChanges();
    },
    methods: {
        setUserType(){
            var roleList=[]
            this.user.roles.forEach(element => {
                roleList.push(element.role_name)
            });
            this.user.user_information ? localStorage.setItem('leave_number', this.user.user_information.allowed_leave_number) : localStorage.setItem('leave_number', 8)
            this.user.assigned_prp ? localStorage.setItem('assigned_prp_id', this.user.assigned_prp.id) : localStorage.setItem('assigned_prp_id', 'No PRP assign')
            this.user.assigned_finance ? localStorage.setItem('user_finance', this.user.assigned_finance.first_name + ' ' + this.user.assigned_finance.last_name) : localStorage.setItem('user_finance', 'No Finance assign')
            this.user.user_information ? this.user.user_information.profile_url ? localStorage.setItem('user_pic', this.user.user_information.profile_url) : '' : ''
            this.user.assigned_prp ? localStorage.setItem('prp_assign', this.user.assigned_prp.first_name + ' ' + this.user.assigned_prp.last_name) : localStorage.setItem('prp_assign', 'No PRP assign')
            this.user.user_information ? this.user.user_information.department ? localStorage.setItem('user_department', this.user.user_information.department.department_name): '' : ''    
            localStorage.setItem('user_type', roleList)
            this.$store.commit('intantiate_roleList', roleList);
            localStorage.setItem('id', this.user.id)
            this.user ? localStorage.setItem('user_name', this.user.first_name + " " + this.user.last_name) : ''
            localStorage.setItem('email', this.user.email)
            this.user.user_information ? localStorage.setItem('company_id', this.user.user_information.company_number) : ''
        },
        listenForChanges() {
        Echo.private('newrequest.' + this.user.id)
          .listen('NewRequest', notif => {
            this.$store.commit('notificationCountAdd');
            this.$store.commit('notificationAdd', {data:notif});       
            this.browserPopUp(notif);
          })

        Echo.channel('newcalendarevent')
          .listen('NewCalendarEvent', notif => {
            this.$store.commit('notificationCountAdd');
            this.$store.commit('notificationAdd', {data:notif});       
            this.browserPopUp(notif);
          })

        // Echo.private('feedbackrequest.' + this.user.id)
        //   .listen('FeebackRequest', notif => {
        //     this.browserPopUp(notif);
        //   })
        },
        browserPopUp(notif) {
            // console.log('NewRequest', notif)
            if (! ('Notification' in window)) {
              alert('Web Notification is not supported');
              return;
            }
            Notification.requestPermission( permission => {
              let notification = new Notification('New Notification from BBO Request Management!', {
                body: notif.message, // content for the alert
                icon: "img/logoCircle.png" // optional image url
              });

              // link to page on clicking the notification
              notification.onclick = () => {
                window.open(window.location.href);
              };
            });
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
.container-fluid{
    width: 100%;
    padding-right: 1px;
    padding-left: 1px;
    margin-right: auto;
    margin-left: auto;
}
</style>
