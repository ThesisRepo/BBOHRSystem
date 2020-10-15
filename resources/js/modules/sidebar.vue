<template>
  <v-app id="inspire">
    <v-navigation-drawer v-model="drawer" app color="light-blue darken-4">
      <center>
        <v-sheet color="light-blue darken-4" class="pa-5">
          <v-avatar class="mb-10" color="grey darken-1" size="64"></v-avatar>
          <div style="color:white">{{ user_name }}</div>
        </v-sheet>
      </center>

      <v-divider></v-divider>

      <v-list v-if="user_type === 'general mngr' || user_type === 'hr mngr'">
        <v-list-item-group active-class="sky blue blue--text">
          <v-list-item px-0
            v-for="(item, index) in links"
            :key="index"
            link
            @click="redirect(item.route)"
          >
            <v-list-item-icon>
              <v-icon color="white darken-2">{{ item.icon }}</v-icon>
            </v-list-item-icon>

          <v-list-item-content >
              <v-list-item-title class="white--text lighten-1--text">{{ item.text }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
      </v-list>
      <v-list v-if="user_type === 'emp' || user_type === 'finance mngr' || user_type === 'prp emp'">
        <v-list-item-group active-class="sky blue blue--text">
          <v-list-item
            v-for="(item, index) in employ"
            :key="index"
            link
            @click="redirect(item.route)"
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

    <v-app-bar app fixed color="light-blue darken-4">
      <v-app-bar-nav-icon @click="drawer = !drawer" color="white darken-2"></v-app-bar-nav-icon>

      <v-toolbar-title style="color:white"> BBO </v-toolbar-title>
    </v-app-bar>
  </v-app>
</template>
<style>
v-app-bar{
  overflow: hidden !important;
}

.v-list-item__title{
 font-size: 15px;
}
</style>

<script>
import ROUTER from "../router";
export default {
  data: () => ({
    user_type: localStorage.getItem('user_type'),
    user_name: localStorage.getItem('user_name'),
    drawer: null,
    data: null,
    links: [
      { icon: "mdi-account", text: "My Account", route: "/MyAccount" },
      { icon: "mdi-apps", text: "Dashboard", route: "/Dashboard" },
      { icon: "mdi-calendar-edit", text: "Leave Request", route: "/Leave" },
      { icon: "mdi-calendar-account", text: "Shift Change Request", route: "/ShiftChange" },
      { icon: "mdi-calendar-clock", text: "Overtime Request", route: "/Overtime" },
      { icon: "mdi-account-cash", text: "Petty Cash Request", route: "/PettyCash" },
      { icon: "mdi-account-cash-outline", text: "Budget Request", route: "/Budget" },
      { icon: "mdi-airplane", text: "Travel Authorization", route: "/TravelAuthorization" },
      { icon: "mdi-account-group", text: "Manage Users", route: "/ManageUsers" },
      { icon: "mdi-logout", text: "LogOut", route: "/logout" }
    ],
    employ: [
      { icon: "mdi-account", text: "My Account", route: "/MyAccount" },
      { icon: "mdi-apps", text: "Dashboard", route: "/Dashboard" },
      { icon: "mdi-calendar-edit", text: "Leave Request", route: "/Leave" },
      { icon: "mdi-calendar-account", text: "Shift Change Request", route: "/ShiftChange" },
      { icon: "mdi-calendar-clock", text: "Overtime Request", route: "/Overtime" },
      { icon: "mdi-account-cash", text: "Petty Cash Request", route: "/PettyCash" },
      { icon: "mdi-account-cash-outline", text: "Budget Request", route: "/Budget" },
      { icon: "mdi-airplane", text: "Travel Authorization", route: "/TravelAuthorization" },
      { icon: "mdi-logout", text: "LogOut", route: "/TravelAuthorization" }
    ],
  }),
  mounted(){
  },
  methods: {
    redirect(route) {
      ROUTER.push(route).catch(() => {});
    },
  },
};
</script> 
