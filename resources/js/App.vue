<template>
 <v-app id="sample">
        <!-- <h1>{{user}}</h1> -->
        <v-main>
            <v-container fluid>
                <sidebar id="sidebar"></sidebar>
                <router-view>
                </router-view>
                <Loading v-if="loading"></Loading>
                <succesMessage ref="success" :messages="messageData"></succesMessage>
                
                <!-- <v-btn @click="showed(true)">show</v-btn>
                <v-btn @click="showed(false)">hide</v-btn> -->
                <!-- <v-btn>hide</v-btn> -->
            </v-container>
        </v-main>
        
    </v-app>
</template>
<style>
</style>

<script>
import Vuetify from "vuetify";
import sidebar from "./modules/sidebar.vue";
import Loading from "./components/Loading.vue";
import { mapGetters } from "vuex";
import succesMessage from "./components/modals/confirmation/success.vue"

export default {
    name: "app",
    props: ['user'],
    components: {
        sidebar,
        Loading,
        succesMessage
    },
    data(){
        return {
            messageData: this.$store.getters.message,
            user_id: localStorage.getItem("id"),
            loading:  this.$store.getters.isLoading
        }
    },
    created() {
        this.setUserType();
        this.$store.commit('hasSmallScreen', { screenSize: window.innerWidth});
        window.addEventListener("resize", this.isSmall);
    },
    destroyed() {
        window.removeEventListener("resize", this.isSmall);
    },
    computed: {
        ...mapGetters(["isLoading", "message", "show"])
    },
    watch: {
        isLoading: function(newVal) {
            this.loading = newVal;
        },
        message: function(newVal) {
            this.messageData = newVal;
        },
        show: function(newVal) {
            if(newVal) {
                this.$refs.success.show()
            }
        }
    },
    
    mounted(){
        this.$store.commit('changeMessage', 'Successfully Updated')
        this.listenForChanges();
    },
    methods: {
        isSmall(e) {
            this.$store.commit('hasSmallScreen', { screenSize: window.innerWidth});
        },
        showed(bol) {
            this.$store.commit('changeStatusMessage', bol)
        },
        setUserType(){
            var roleList=[]
            this.user.roles.forEach(element => {
                roleList.push(element.role_name)
            });
            this.user.user_information ? localStorage.setItem('leave_number', this.user.user_information.allowed_leave_number) : localStorage.setItem('leave_number', 8)
            this.user.assigned_prp ? localStorage.setItem('assigned_prp_id', this.user.assigned_prp.id) : localStorage.setItem('assigned_prp_id', 'No PRP assign')
            this.user.assigned_finance ? localStorage.setItem('user_finance', this.user.assigned_finance.first_name + ' ' + this.user.assigned_finance.last_name) : localStorage.setItem('user_finance', '')
            this.user.user_information ? this.user.user_information.profile_url ? localStorage.setItem('user_pic', this.user.user_information.profile_url) : '' : ''
            this.user.assigned_prp ? localStorage.setItem('prp_assign', this.user.assigned_prp.first_name + ' ' + this.user.assigned_prp.last_name) : localStorage.setItem('prp_assign', '')
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

         Echo.channel('publiccalendar')
          .listen('PublicCalendarEvent', notif => {
            this.$store.commit('notificationCountAdd');
            this.$store.commit('notificationAdd', {data:notif});       
            this.browserPopUp(notif);
          })
        Echo.private('privatecalendar.' + this.user.id)
          .listen('PrivateCalendarEvent', notif => {
            this.browserPopUp(notif);
          })
        Echo.private('adminevent.' + this.user.id)
          .listen('AdminEvent', notif => {
            this.browserPopUp(notif);
          })
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
