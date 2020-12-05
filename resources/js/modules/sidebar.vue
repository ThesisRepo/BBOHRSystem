<template>
  <v-app>
    <v-navigation-drawer v-model="drawer" app color="light-blue darken-4" class="example">
      <center>
        <v-sheet color="light-blue darken-4" class="pa-5">
          <!-- <v-avatar v-if="user_pic === null" class="mb-10" size="64">
            <img src="images/user.png" alt="profile pic">
          </v-avatar> -->
          <v-avatar class="mb-10" color="grey darken-1" size="64">
            <img :src="user_pic" alt="profile pic">
          </v-avatar>
          <div style="color:white">{{ user_name }}</div>
        </v-sheet>
      </center>

      <v-divider></v-divider>

      <v-list v-if="user_type.includes('emp') || user_type.includes('finance mngr') || user_type.includes('prp emp')">
        <v-list-item-group active-class="sky blue blue--text">
          <v-list-item
            v-for="(item, index) in employ"
            :key="index"
            link
            @click="item.route ? redirect(item.route) : logout()"
          >
            <v-list-item-icon >
              <v-icon color="white darken-2">{{ item.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title class="white--text lighten-1--text">{{ item.text }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>
     <!-- <v-app-bar app fixed color="light-blue darken-4">
      <v-app-bar-nav-icon @click="drawer = !drawer" color="white darken-2"></v-app-bar-nav-icon>

      <v-toolbar-title style="color:white"> BBO </v-toolbar-title>
    </v-app-bar> -->
    <v-app-bar 
      app
      fixed
      color="white"
      elevate-on-scroll
      >
      <v-app-bar-nav-icon @click="drawer = !drawer" color="light-blue darken-4"></v-app-bar-nav-icon>
      <!-- <v-img
        lazy-src="../storage/img/logoCircle.png"
        max-height="25"
        max-width="25"
        src="../storage/img/logoCircle.png"
        class="ml-5 mr-2"
      ></v-img> -->
      <v-toolbar-title style="color:black;width:100%">
      
        <span style="color:#3490dc">Blue Bee One</span>  Request Management System</v-toolbar-title>
        <div id="cont">
          <span v-if="notification_count > 0" style="float:right;background-color:red;color:white;border-radius:50px;height:20px;width:20px;margin-top:-5px;"
          >{{ notification_count > 99 ? '99+': notification_count}}
          </span>
          <span v-else style="float:right;background-color:white;color:white;border-radius:50px;height:20px;width:20px;margin-top:-5px;"
          >{{ notification_count > 99 ? '99+': notification_count}}
          </span>
          <i class="fas fa-bell" id="bell" style="float:right;" @click="show()"></i>
          <Notification id="notification" ref="notification"/>
        </div>
    </v-app-bar>
     <Confirmation
      ref="confirms"
      :title="confirmationTitle"
      :message="confirmationMessage"
      @onConfirm="confirm($event)"
    ></Confirmation>
    <!-- <v-list v-if="isLoggedIn">
      <a id="logout-link" href="#" @click.prevent="logout">Logout</a>
    </v-list> -->
  </v-app>
  
   
        

</template>
<style scoped>
/* #container {
  background-color: red;
} */
#cont {
  /* background-color: yellow; */
  width:300px;
  text-align:center;
  position:relative;
  /* right: 0;
  position:absolute; */
};
#notification{
  /* right:150%;
  position:absolute; */
}
#bell {
  color: #01579b;
  font-size: 25px;
  cursor:pointer;
}
</style>

<script>
import ROUTER from "../router";
import { mapGetters } from "vuex";
import Confirmation from "../components/modals/confirmation/confirm.vue";
import Notification from "../components/notification.vue";

export default {
  data(){
    return {
      user_pic: this.$store.getters.profileUrl,
      notification_count: this.$store.getters.notificationCount ,
      user_type: localStorage.getItem('user_type'),
      user_name: localStorage.getItem('user_name'),
      drawer: null,
      data: null,
      employ: [
        { icon: "mdi-account", text: "My Account", route: "/MyAccount" },
        { icon: "mdi-apps", text: "Dashboard", route: "/" },
        { icon: "mdi-calendar-edit", text: "Leave", route: "/Leave" },
        { icon: "mdi-calendar-account", text: "Shift Change", route: "/ShiftChange" },
        { icon: "mdi-calendar-clock", text: "Overtime", route: "/Overtime" },
        { icon: "mdi-account-cash", text: "Petty Cash", route: "/PettyCash" },
        { icon: "mdi-account-cash-outline", text: "Budget", route: "/Budget" },
        { icon: "mdi-airplane", text: "Travel Authorization", route: "/TravelAuthorization" },
        { icon: "mdi-logout", text: "LogOut"}
        // { icon: "mdi-logout", text: "LogOut", route: "/logout" }

      ],
      confirmationTitle: null,
      confirmationMessage: null
    }
  },
  components: {
    Confirmation,
    Notification
  },
  mounted(){
    if(this.user_type.includes('hr mngr')){
      this.employ.splice(this.employ.length-1, 0, { icon: "mdi-account-group", text: "Manage Users", route: "/ManageUsers" })
    }
    if(this.user_pic === null){
      this.user_pic = 'images/user.png'
    }
  },
  computed: {
    ...mapGetters(["profileUrl", "notificationCount"])
  },
  watch: {
    profileUrl: function(newVal) {
        this.user_pic = newVal;
    },
    notificationCount: function(newVal) {
      this.notification_count = newVal;
    }
  },
  methods: {
    show() {
      this.$refs.notification.show();
    },
    confirm(){
      this.$axios
      .post(
        "logout")
      .then(response => {
        location.reload();
        localStorage.clear()
        window.location.replace("/");
      })
    },
    redirect(route) {
       ROUTER.push(route).catch(() => {});
      // if(route != '/logout') {
      //  ROUTER.push(route).catch(() => {});
      // }else {
      //   this.$router.push({ name: 'logout' });
      //   this.logout();
      // }
    },
    logout() {
      this.confirmationTitle= 'Logout',
      this.confirmationMessage= 'Are you sure you want to logout?'
      this.$refs.confirms.show();
    }
  }
};
</script> 
