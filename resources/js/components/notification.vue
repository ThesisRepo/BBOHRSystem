<template>
  <v-card id="container" v-if="isPop" v-on-clickaway="away">
    <v-btn  class="primary" id="title"><b>Notifications</b></v-btn>

    <p v-if="data.length == 0 " id="empMessage">no notification</p>
    <div v-if="data.length > 0" id="body">
      <v-card id="indvNotification" 
      v-for="(item,index) in data" :key="index"
      :style="[item.is_seen ?{'background-color':'#e3e3e7', 'cursor':'default'} : {}]"
      @click="!item.is_seen? redirect(item) : ''"
      >
        <span>{{item.message}}</span><br>
        <span id="message" v-if="!item.message.includes('due')">{{item.created_at}}</span>
      </v-card>
    </div>
    <v-btn id="seeMore" @click="more()">see more</v-btn>
    <v-btn id="seeMore" @click="readAll()">mark all as read</v-btn>
    <Confirmation
      ref="confirms"
      :title="confirmationTitle"
      :message="confirmationMessage"
      @onConfirm="confirm($event)"
    ></Confirmation>
  </v-card>
</template>
<script>
import { mixin as clickaway } from 'vue-clickaway';
import { mapGetters } from "vuex";
import ROUTER from "../router";
import Confirmation from "../components/modals/confirmation/confirm.vue";
export default {
  props: ['id'],
  mixins: [ clickaway ],
  data() {
    return {
      data: this.$store.getters.notifications,
      isDropdownActive: false,
      isPop: false,
      user_id: localStorage.getItem("id"),
      confirmationTitle: null,
      confirmationMessage: null
    }
  },
  components: {
    Confirmation
  },
  methods: {
    away() {
      this.isPop = false;
    },
    show() {
      this.isPop = true
    },
    redirect(item) {
      var type = item.request_type;
      var route = '';
      switch(type) {
        case 'Leave Request':
          route = "/Leave"
          break;
        case 'Shift Change Request':
          route = "/ShiftChange"
          break;
        case 'Overtime Request':
          route = "/Overtime"
          break;
        case 'Petty Cash Request':
          route = "/PettyCash"
          break;
        case 'Budget Request':
          route = "/Budget"
          break;
        case 'Travel Authorization Request':
          route = "/TravelAuthorization"
          break;
        default:
          route = "/Dashboard"
          break;

      };
      this.$store.dispatch('readNotification',{id: item.id != null ? item.id  : 0 }).then(()=> {});
      ROUTER.push(route).catch(() => {});
    },
    more() {
      this.$store.dispatch('moreNotification',{user_id: this.user_id}).then(()=> {});
    },
    readAll() {
      this.confirmationTitle= 'Mark all as read',
      this.confirmationMessage= 'Are you sure you want to mark all notifications as read?'
      this.$refs.confirms.show();
    },
    confirm() {
      this.$store.dispatch('markAllReadNotification',{user_id: this.user_id}).then(()=> {});
    }
  },
  computed: {
    ...mapGetters(["notifications", "notificationCount"])
  },
  watch: {
    notifications: function(newVal) {
        this.data = newVal;
    },
  }
};
</script>
<style scoped>
#body{
min-height: 30px;
max-height: 500px!important;
overflow-y: scroll;
}
#container{
  /* right:50%; */
  /* background-color: red; */
  top:25px;
  width:100%;
  background-color: white;
  position:absolute;
   -webkit-box-shadow: 0 6px 4px -4px black;
  -moz-box-shadow: 0 6px 4px -4px black;
  box-shadow: 0 6px 4px -4px black;
  border: solid #dadada 1px;
}
#title {
  width:100%;
  height: 25px;
  border-bottom: solid #dadada 1px;
  color:white;
  background-color: #1976d2;
}
#empMessage{
  margin-top:5px; 
}
#seeMore{
  width:100%;
  /* background-color: #1976d2; */

}
#indvNotification {
  text-align: justify !important;
  padding:2px;
  min-height: 35px;
}
#message {
  font-weight: 300;
}

</style>