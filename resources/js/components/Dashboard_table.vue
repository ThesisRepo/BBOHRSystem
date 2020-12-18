<template>
  <v-data-table 
  :headers="headers" 
  :items="requests" 
  item-key="key"
  class="elevation-1">
    <template v-slot:top>
    <v-toolbar class="mb-2" color="blue darken-1" dark flat>
      <v-toolbar-title class="col pa-3 py-4 white--text" style="font-size:16px">{{ !isGenManager &&  !isAdmin ? 'MY PENDING REQUESTS' : 'PENDING EMPLOYEE REQUESTS'}}</v-toolbar-title>
    </v-toolbar>
    </template>
    <template v-if="!isGenManager" v-slot:item.status.status_name="{ item }"> <v-chip :color="getColor(item.status.status_name)">{{item.status.status_name === 'pending' ? 'PENDING' : ''}}</v-chip> </template>
    <template v-if="!isGenManager" v-slot:item.approver_role.role_name="{ item }"> <v-chip class="ma-2" outlined :color="prpColor(item.approver_role.role_name)">{{item.approver_role.role_name === 'prp emp' ? 'PRP' : item.approver_role.role_name === 'finance mngr' ? 'Finance Manager' : item.approver_role.role_name === 'hr mngr' ? 'HR' : item.approver_role.role_name === 'general mngr' ? 'General Manager': '' }}</v-chip> </template>
    <template v-if="isGenManager || isAdmin" v-slot:item.user="{ item }">
      {{item.user.first_name + ' ' + item.user.last_name }}
    </template>

    <template v-slot:item.request_type="{ item }"> <span>{{item.request_type === 'leave_requests' ?
       'Leave Request' :
        item.request_type  === 'shift_change_requests' ? 'Shift Request' :
         item.request_type === 'budget_requests' ? 'Budget Request' : 
         item.request_type === 'petty_cash_requests' ? 'Petty Cash Request': 
         item.request_type === 'travel_auth_requests' ? 'Travel Request' :
         item.request_type === 'overtime_requests' ? 'Overtime Request' :
          '' }}</span> </template>
    <template v-slot:item.created_at="{ item }"> <span>{{getDate(item.created_at)}}</span> </template>
  </v-data-table>
</template>
<script>
import moment from 'moment'
import {hasGeneralManager, hasAdmin} from '../helpers/user_roles.js'
export default {
  data: () => ({
    user_id: localStorage.getItem("id"),
    user_type: localStorage.getItem('user_type'),
    appprover: null,
    headers: [
      { text: "DATE", align: "start", value: "created_at" },
      { text: "TYPE OF REQUEST", value: "request_type" },
      { text: "STATUS", value: "status.status_name" },
      { text: "APPROVER", value: "approver_role.role_name" }
    ],
    requests: [],
    isGenManager: false,
    isAdmin: false
  }),
  mounted(){
    this.isGenManager = this.hasGeneralManager(this.user_type);
    this.isAdmin = this.hasAdmin(this.user_type);
    this.getRequests()
  },
  methods: {
    hasGeneralManager,
    hasAdmin,
    getDate(date){
      return moment(date).format('MM/DD/YYYY hh:mm A')
    },
    getRequests(){
      if(this.isGenManager) {
        this.headers = [
          { text: "DATE", align: "start", value: "created_at" },
          { text: "TYPE OF REQUEST", value: "request_type" },
          { text: "REQUESTER", align: "start", value: "user" },
          { text: "COMPANY POSITION", align: "start", value: "user.user_information.company_positions[0].position_name" },
          { text: "DEPARTMENT", align: "start", value: "user.user_information.department.department_name" },   
        ];
        this.$axios.get('gm/user_info/pending_requests/' + this.user_id).then(response =>{
          this.requests = response.data
        })
      }else if(this.isAdmin) {
         this.headers = [
          { text: "DATE", align: "start", value: "created_at" },
          { text: "TYPE OF REQUEST", value: "request_type" },
          { text: "REQUESTER", align: "start", value: "user" },
          { text: "APPROVER", value: "approver_role.role_name" },
          { text: "STATUS", value: "status.status_name" },
          { text: "COMPANY POSITION", align: "start", value: "user.user_information.company_positions[0].position_name" },
          { text: "DEPARTMENT", align: "start", value: "user.user_information.department.department_name" },   
        ];
        this.$axios.get('admin/pending_requests').then(response =>{
          this.requests = response.data
        })
      }
      else{
        this.$axios.get('user_info/pending_requests/' + this.user_id).then(response =>{
          this.requests = response.data
        })
      }
    },
    getColor(status) {
      if (status === "pending") return "#ffa500";
      else if (status === "approved") return "green";
      else return "red";
    },
    prpColor(approver_role) {
      if (approver_role === "prp emp") return "#0047ab"
      else if (approver_role === "hr mngr") return "blue"
      else if (approver_role === "finance mngr") return "#00004d"
      else if (approver_role === "emp") return "0f52ba"
      else return "#002366";
    },
  }
}
</script>