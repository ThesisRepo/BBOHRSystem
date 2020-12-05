<template>
  <v-card id="container" v-if="isPop" v-on-clickaway="away">
    <v-card id="title"><b>Notifications</b></v-card>

    <p v-if="data.length == 0 " id="empMessage">nothing new</p>
    <div v-if="data.length > 0" id="body">
      <v-card id="indvNotification" v-for="(item,index) in data" :key="index">
        <span >{{item.message}}</span><br>
        <span id="message">{{item.time}}</span>
      </v-card>
    </div>
    <v-btn id="seeMore">see more</v-btn>
  </v-card>
</template>
<script>
import { mixin as clickaway } from 'vue-clickaway';
export default {
  props: ['id'],
  mixins: [ clickaway ],
  data() {
    return {
      data: [],
      // data: [
      //   {
      //     'message': 'Shielle Added a Leave Request',
      //     'time': '2 mins ago'
      //   },
      //   {
      //     'message': 'hi all',
      //     'time': '2 mins ago'
      //   },{
      //     'message': 'Shielle Added a Leave Request',
      //     'time': '2 mins ago'
      //   },
      //   {
      //     'message': 'hi all',
      //     'time': '2 mins ago'
      //   },{
      //     'message': 'Shielle Added a Leave Request',
      //     'time': '2 mins ago'
      //   },
      //   {
      //     'message': 'hi all',
      //     'time': '2 mins ago'
      //   },{
      //     'message': 'Shielle Added a Leave Request',
      //     'time': '2 mins ago'
      //   },
      //   {
      //     'message': 'hi all',
      //     'time': '2 mins ago'
      //   },{
      //     'message': 'Shielle Added a Leave Request',
      //     'time': '2 mins ago'
      //   },
      //   {
      //     'message': 'hi all',
      //     'time': '2 mins ago'
      //   },{
      //     'message': 'Shielle Added a Leave Request',
      //     'time': '2 mins ago'
      //   },
      //   {
      //     'message': 'hi all',
      //     'time': '2 mins ago'
      //   },{
      //     'message': 'Shielle Added a Leave Request',
      //     'time': '2 mins ago'
      //   },
      //   {
      //     'message': 'hi all',
      //     'time': '2 mins ago'
      //   },{
      //     'message': 'Shielle Added a Leave Request',
      //     'time': '2 mins ago'
      //   },
      //   {
      //     'message': 'hi all',
      //     'time': '2 mins ago'
      //   },{
      //     'message': 'Shielle Added a Leave Request',
      //     'time': '2 mins ago'
      //   },
      //   {
      //     'message': 'hi all',
      //     'time': '2 mins ago'
      //   },{
      //     'message': 'Shielle Added a Leave Request',
      //     'time': '2 mins ago'
      //   },
      //   {
      //     'message': 'hi all',
      //     'time': '2 mins ago'
      //   },{
      //     'message': 'Shielle Added a Leave Request',
      //     'time': '2 mins ago'
      //   },
      //   {
      //     'message': 'hi all',
      //     'time': '2 mins ago'
      //   },
      // ],
      isDropdownActive: false,
      isPop: false
    }
  },
  methods: {
    away() {
      this.isPop = false;
    },
    show() {
      this.isPop = true
    }
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