<template>
  <v-app id="inspire">
    <v-navigation-drawer v-model="drawer" app>
      <center>
        <v-sheet color="grey lighten-4" class="pa-4">
          <v-avatar class="mb-4" color="grey darken-1" size="64"></v-avatar>
          <div>Marion Jay Balugo</div>
        </v-sheet>
      </center>

      <v-divider></v-divider>

      <v-list v-if="user === 'ADMIN'">
        <v-list-item
          v-for="[icon, text] in links"
          :key="icon"
          link
        >
          <v-list-item-icon>
            <v-icon>{{ icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ text }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
      <v-list v-if="user === 'EMPLOYEE'">
        <v-list-item
          v-for="(item, index) in employ"
          :key="index"
          link
          @click="redirect(item.route)"
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.text }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app fixed>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title>
        BBO
      </v-toolbar-title>
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
import ROUTER from '../router'
  export default {
    data: () => ({
      user: 'EMPLOYEE',
      drawer: null,
      links: [
        ['mdi-inbox-arrow-down', 'Inbox'],
        ['mdi-send', 'Send'],
        ['mdi-delete', 'Trash'],
        ['mdi-alert-octagon', 'Spam'],
      ],
      employ: [
        { icon: 'mdi-account', text: 'My Account', route: "/MyAccount"},
        { icon: 'mdi-apps', text: 'Dashboard', route: "/Dashboard"},
        { icon: 'mdi-calendar-edit', text: 'Leave Request', route: "/Leave"},
        { icon: 'mdi-calendar-account', text: 'Shift Change Request', route: "/ShiftChange"},
        { icon: 'mdi-calendar-clock', text: 'Overtime Request', route: "/Overtime"},
        { icon: 'mdi-calendar-multiple-check', text: 'Actual Overtime Request', route: "/ActualOverTime"},
        { icon: 'mdi-account-cash', text: 'Petty Cash Request', route: "/PettyCash"},
        { icon: 'mdi-account-cash-outline', text: 'Budget Request', route: "/Budget"},
        { icon: 'mdi-airplane', text: 'Travel Authorization', route: "/TravelAuthorization"}
      ]
    }),
    methods: {
      redirect(route){
        ROUTER.push(route).catch(()=> {})
      }
    }
  }
</script>
