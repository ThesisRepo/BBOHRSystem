<template>
  <v-app>
    <v-navigation-drawer v-model="drawer" app color="light-blue darken-4" class="example">
      <center>
        <v-sheet color="light-blue darken-4" class="pa-5">
          <v-avatar v-if="user_pic === null" class="mb-10" size="64">
            <img src="images/user.png" alt="profile pic">
          </v-avatar>
          <v-avatar v-else class="mb-10" color="grey darken-1" size="64">
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
      <v-toolbar-title style="color:black">
      
        <span style="color:#3490dc">Blue Bee One</span>  Request Management System</v-toolbar-title>
    </v-app-bar>

    <!-- <v-list v-if="isLoggedIn">
      <a id="logout-link" href="#" @click.prevent="logout">Logout</a>
    </v-list> -->
  </v-app>
  
   
        

</template>
<style>
</style>

<script>
import ROUTER from "../router";
export default {
  data: () => ({
    user_pic: localStorage.getItem('user_pic'),
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
      { icon: "mdi-account-cash-outline", text: "Budget ", route: "/Budget" },
      { icon: "mdi-airplane", text: "Travel Authorization", route: "/TravelAuthorization" },
      { icon: "mdi-logout", text: "LogOut"}
      // { icon: "mdi-logout", text: "LogOut", route: "/logout" }

    ],
  }),
  mounted(){
    console.log('gawas', this.user_pic, this.user_type, this.user_name)
    if(this.user_type.includes('hr mngr')){
      this.employ.splice(this.employ.length-1, 0, { icon: "mdi-account-group", text: "Manage Users", route: "/ManageUsers" })
    }
  },

  methods: {

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
       this.$axios
        .post(
          "logout")
        .then(response => {
          location.reload();
          localStorage.clear()
          window.location.replace("/");
          // localStorage.removeItem('assigned_prp_id')
          // localStorage.removeItem('user_finance')
          // localStorage.removeItem('prp_assign')
          // localStorage.removeItem('user_department')
          // localStorage.removeItem('user_type')
          // localStorage.removeItem('id')
          // localStorage.removeItem('user_name')
          // localStorage.removeItem('email')
          // localStorage.removeItem('company_id')
          // localStorage.removeItem('user_pic')
        })
    }
  }
};
</script> 
