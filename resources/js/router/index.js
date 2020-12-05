import Vue from "vue";
import Vuetify from 'vuetify';
import Router from "vue-router";
import MyAccount from "../components/MyAccount.vue";
import Dashboard from "../components/Dashboard.vue";
import Leave from "../components/Leave.vue";
import ShiftChange from "../components/Shift_change.vue";
import Overtime from "../components/Overtime.vue";
import PettyCash from "../components/Petty_Cash.vue";
import Budget from "../components/Budget.vue";
import TravelAuthorization from "../components/Travel_Authorization.vue";
import ManageUsers from "../components/ManageUsers.vue";


Vue.use(Router);
Vue.use(Vuetify);
function isLoggedIn(to, from, next)
{
 if(localStorage.getItem('isloggedin')) 
 {
  next('/Dashboard');
 } 
 else
 {
  next();
 }
};
function isLoggedIn2(to, from, next)
{
 if(localStorage.getItem('isloggedin')) 
 {
  next();
 } 
 else
 {
  next('/');
 }
};
const router = new Router({
  mode: "hash",
  base: process.env.BASE_URL,
    
  routes : [
    {
      path: "/MyAccount",
      name: "MyAccount",
      component: MyAccount,
      beforeEnter : isLoggedIn2
    },
    {
      path: '/',
      beforeEnter : isLoggedIn
    },
    {
      path: '*',
      redirect: '/'
    },
    {
      path: "/Dashboard",
      name: "Dashboard",
      component: Dashboard,
      beforeEnter : isLoggedIn2
    },
    {
      path: "/Leave",
      name: "Leave",
      component: Leave,
      beforeEnter : isLoggedIn2
    },
    {
      path: "/ShiftChange",
      name: "ShiftChange",
      component: ShiftChange,
      beforeEnter : isLoggedIn2
    },
    {
      path: "/Overtime",
      name: "Overtime",
      component: Overtime,
      beforeEnter : isLoggedIn2
    },
    {
      path: "/PettyCash",
      name: "PettyCash",
      component: PettyCash,
      beforeEnter : isLoggedIn2
    },
    {
      path: "/Budget",
      name: "Budget",
      component: Budget,
      beforeEnter : isLoggedIn2
    },
    {
      path: "/TravelAuthorization",
      name: "TravelAuthorization",
      component: TravelAuthorization,
      beforeEnter : isLoggedIn2
    },
    {
      path: "/ManageUsers",
      name: "ManageUsers",
      component: ManageUsers,
      beforeEnter : isLoggedIn2
    }
  ] 
});
export default router;