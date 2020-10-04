import Vue from "vue";
import Vuetify from 'vuetify';
import Router from "vue-router";
import MyAccount from "../components/MyAccount.vue";
import Dashboard from "../components/Dashboard.vue";
import Leave from "../components/Leave.vue";
import ShiftChange from "../components/Shift_change.vue";
import Overtime from "../components/Overtime.vue";
import ActualOverTime from "../components/Actual_OT.vue";
import PettyCash from "../components/Petty_Cash.vue";
import Budget from "../components/Budget.vue";
import TravelAuthorization from "../components/Travel_Authorization.vue";


Vue.use(Router);
Vue.use(Vuetify);

const router = new Router({
  mode: "history",
  base: process.env.BASE_URL,
  routes : [
    {
      path: "/MyAccount",
      name: "MyAccount",
      component: MyAccount
    },
    {
      path: "/Dashboard",
      name: "Dashboard",
      component: Dashboard
    },
    {
      path: "/Leave",
      name: "Leave",
      component: Leave
    },
    {
      path: "/ShiftChange",
      name: "ShiftChange",
      component: ShiftChange
    },
    {
      path: "/Overtime",
      name: "Overtime",
      component: Overtime
    },
    {
      path: "/ActualOverTime",
      name: "ActualOverTime",
      component: ActualOverTime
    },
    {
      path: "/PettyCash",
      name: "PettyCash",
      component: PettyCash
    },
    {
      path: "/Budget",
      name: "Budget",
      component: Budget
    },
    {
      path: "/TravelAuthorization",
      name: "TravelAuthorization",
      component: TravelAuthorization
    }
  ] 
});

export default router;
