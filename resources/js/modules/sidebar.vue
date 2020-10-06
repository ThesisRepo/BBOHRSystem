<template>
  <v-app id="inspire">
    <v-navigation-drawer v-model="drawer" app color="light-blue darken-4">
      <center>
        <v-sheet color="light-blue darken-4" class="pa-5">
          <v-avatar class="mb-10" color="grey darken-1" size="64"></v-avatar>
          <div style="color:white">Marion Jay Balugo</div>
        </v-sheet>
      </center>

      <v-divider></v-divider>

      <v-list v-if="user === 'ADMIN'">
        <v-list-item-group active-class="white blue--text">
          <v-list-item v-for="[icon, text] in links" :key="icon" link>
            <v-list-item-icon>
              <v-icon>{{ icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content >
              <v-list-item-title >{{ text }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
      </v-list>
      <v-list v-if="user === 'EMPLOYEE'">
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
              <v-list-item-title class="white--text lighten-1--text ">{{ item.text }}</v-list-item-title>
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
v-app-bar {
  overflow: hidden !important;
}
.v-list-item__title {
  font-size: 15px;
}
</style>

<script>
import ROUTER from "../router";
export default {
  data: () => ({
    user: "EMPLOYEE",
    drawer: null,
    links: [
      { icon: "mdi-account", text: "My Account", route: "/MyAccount" },
      { icon: "mdi-apps", text: "Dashboard", route: "/Dashboard" },
      { icon: "mdi-calendar-edit", text: "Leave Request", route: "/Leave" },
      { icon: "mdi-calendar-account", text: "Shift Change Request", route: "/ShiftChange" },
      { icon: "mdi-calendar-clock", text: "Overtime Request", route: "/Overtime" },
      { icon: "mdi-calendar-multiple-check", text: "Actual Overtime Request", route: "/ActualOverTime" },
      { icon: "mdi-account-cash", text: "Petty Cash Request", route: "/PettyCash" },
      { icon: "mdi-account-cash-outline", text: "Budget Request", route: "/Budget" },
      { icon: "mdi-airplane", text: "Travel Authorization", route: "/TravelAuthorization" },
      { icon: "mdi-users", text: "Manage Users", route: "/ManageUsers" },
      { icon: "mdi-logout", text: "LogOut", route: "/TravelAuthorization" }
    ],
    employ: [
      { icon: "mdi-account", text: "My Account", route: "/MyAccount" },
      { icon: "mdi-apps", text: "Dashboard", route: "/Dashboard" },
      { icon: "mdi-calendar-edit", text: "Leave Request", route: "/Leave" },
      { icon: "mdi-calendar-account", text: "Shift Change Request", route: "/ShiftChange" },
      { icon: "mdi-calendar-clock", text: "Overtime Request", route: "/Overtime" },
      { icon: "mdi-calendar-multiple-check", text: "Actual Overtime Request", route: "/ActualOverTime" },
      { icon: "mdi-account-cash", text: "Petty Cash Request", route: "/PettyCash" },
      { icon: "mdi-account-cash-outline", text: "Budget Request", route: "/Budget" },
      { icon: "mdi-airplane", text: "Travel Authorization", route: "/TravelAuthorization" },
      { icon: "mdi-logout", text: "LogOut", route: "/TravelAuthorization" }
    ],
  }),
  methods: {
    redirect(route) {
      ROUTER.push(route).catch(() => {});
    },
  },
};
</script>