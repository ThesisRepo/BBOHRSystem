<template>
  <v-container fluid>
    <v-toolbar-title
      class="py-4"
      >
      OVERTIME REQUESTS
    </v-toolbar-title>
    <v-toolbar flat>
      <!-- <template v-slot:extension> -->
        <v-tabs
          dark
          background-color="primary"
          fixed-tabs
          v-if="((user_type.includes('hr mngr') || user_type.includes('prp emp') || user_type.includes('general mngr')) && !user_type.includes('finance mngr'))"
        >
          <v-tabs-slider></v-tabs-slider>
          <v-tab v-if="!user_type.includes('general mngr')  && !user_type.includes('admin')" @click="employees = false, requests = true, feedback = false">My Requests</v-tab>
          <v-tab @click="requests = false, employees = true, feedback = false">Employees Requests</v-tab>
          <v-tab @click="requests = false, employees = false, feedback = true">History</v-tab>
        </v-tabs>
      <!-- </template> -->
    </v-toolbar>

    <!-- Feedback -->
    <v-data-table v-if="feedback" :headers="headersFeed" :items="feedbacks" :search="search" class="elevation-3">
      <template v-slot:top>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat v-if="(user_type.includes('hr mngr') || user_type.includes('general mngr'))">
          <v-col class="mt-8" v-if="!user_type.includes('general mngr')">
            <v-menu
              :close-on-content-click="false"
              transition="scale-transition"
              offset-y
              min-width="290px"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  class="input-name"
                  v-model="dateRangeText"
                  chips
                  label="DATE"
                  prepend-icon="mdi-calendar"
                  readonly
                  v-bind="attrs"
                  v-on="on"
                ></v-text-field>
              </template>
               <v-date-picker
                v-model="dates"
                range
              ></v-date-picker>
            </v-menu>
          </v-col>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <v-menu
            transition="slide-y-transition"
            bottom
          >
            <template v-slot:activator="{ on, attrs }" v-if="!user_type.includes('general mngr')">
              <v-btn
                class="purple"
                color="primary"
                dark
                v-bind="attrs"
                v-on="on"
              >
                Summary
              </v-btn>
            </template>
            <v-list>
              <v-list-item
                v-for="(item, i) in items"
                :key="i"
              >
                <v-list-item-title @click="summary(item.title)" style="cursor: pointer;">{{ item.title }}</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
          <v-divider class="mx-4" vertical v-if="!user_type.includes('general mngr')"></v-divider>
          <!-- <v-spacer></v-spacer> -->
          <v-text-field
            v-model="search"
            clearable
            flat
            solo-inverted
            hide-details
            prepend-inner-icon="mdi-magnify"
            label="Search"
          ></v-text-field>
        </v-toolbar>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat v-if="((user_type.includes('prp emp') || user_type.includes('finance mngr')) && (!user_type.includes('hr mngr') && !user_type.includes('general mngr')))">
          <v-text-field
            v-model="search"
            clearable
            flat
            solo-inverted
            hide-details
            prepend-inner-icon="mdi-magnify"
            label="Search"
          ></v-text-field>
        </v-toolbar>
      </template>
      <template v-slot:item.reason="{ item }">{{convertData(item)}}</template>
      <template v-slot:item.status.status_name="{ item }"> <v-chip :color="getColor(item.status.status_name)" :text-color="getColor(item.status.status_name) != '#ffa500'? 'white': 'black'">{{item.status.status_name === 'pending' ? 'PENDING' : item.status.status_name === 'approved' ? 'APPROVED' : item.status.status_name === 'disapproved' ? 'DISAPPROVED' : ''}}</v-chip> </template>
      <template v-slot:item.approver_role.role_name="{ item }"> <v-chip class="ma-2" outlined :color="prpColor(item.approver_role.role_name)">{{item.approver_role.role_name === 'prp emp' ? 'PRP' : item.approver_role.role_name === 'finance mngr' ? 'Finance Manager' : item.approver_role.role_name === 'hr mngr' ? 'HR' : item.approver_role.role_name === 'general mngr' ? 'General Manager': '' }}</v-chip> </template>
      <template 
        v-if="user_type.includes('admin')"
        v-slot:item.actions="{ item }">
        <v-icon medium 
        v-if="item.status_id != 2"
        class="mr-2" @click="approveModal(item)" style="color:green">mdi-check-decagram</v-icon>
        <v-icon 
        v-else
        medium @click="disapproveModal(item)" style="color:red">mdi-close-circle</v-icon>
      </template>
    </v-data-table>

    <!-- Employee Overtime -->
    <v-data-table v-if="employees" :headers="headersEmp" :items="overtimePending" :search="search" class="elevation-3">
      <template v-slot:top>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat>
          <v-text-field
            v-model="search"
            clearable
            flat
            solo-inverted
            hide-details
            prepend-inner-icon="mdi-magnify"
            label="Search"
          ></v-text-field>
        </v-toolbar>
      </template>
      <template v-slot:item.reason="{ item }">{{convertData(item)}}</template>
      <template v-slot:item.status.status_name="{ item }"> <v-chip :color="getColor(item.status.status_name)" :text-color="getColor(item.status.status_name) != '#ffa500'? 'white': 'black'">{{item.status.status_name === 'pending' ? 'PENDING' : item.status.status_name === 'approved' ? 'APPROVED' : item.status.status_name === 'disapproved' ? 'DISAPPROVED' : ''}}</v-chip> </template>
      <template v-slot:item.approver_role.role_name="{ item }"> <v-chip class="ma-2" outlined :color="prpColor(item.approver_role.role_name)">{{item.approver_role.role_name === 'prp emp' ? 'PRP' : item.approver_role.role_name === 'finance mngr' ? 'Finance Manager' : item.approver_role.role_name === 'hr mngr' ? 'HR' : item.approver_role.role_name === 'general mngr' ? 'General Manager': '' }}</v-chip> </template>
      <template v-slot:item.actions="{ item }">
        <v-icon medium class="mr-2" @click="approveModal(item)" style="color:green">mdi-check-decagram</v-icon>
        <v-icon medium @click="disapproveModal(item)" style="color:red">mdi-close-circle</v-icon>
      </template>
    </v-data-table>

    <Confirmation
      ref="confirms"
      :title="approveThis === 'approve' || 'disapproved' ? 'Confirmation' : ''"
      :message="!user_type.includes('admin') ? 
        approveThis === 'approve' ? 'Are you sure you want to approve this request?' : approveThis === 'disapproved' ? 'Are you sure you want to reject this request?' : '' :
        approveThis === 'approve' ? 'Are you sure you want to OVERRIDE approval of this request?' : approveThis === 'disapproved' ? 'Are you sure you want to OVERRIDE rejection of this request?' : '' "
      @onConfirm="confirm($event)"
    ></Confirmation>

    <!-- EditModal -->
      <v-dialog scrollable v-model="dialog" max-width="600px">
        <v-card>
         <v-toolbar class="mb-2" color="blue darken-1" dark flat>
            <v-card-title>   
              <span class="headline-bold">UPDATE OVERTIME REQUEST</span>
            </v-card-title>
          </v-toolbar>
          <!-- <v-divider></v-divider> -->
          <v-card-text>
            <v-container>
            <span v-if="error" style="color: red; font-style: italic">All data are required!</span>
              <v-row>
                <v-col cols="12" sm="6" md="12">
                  <v-textarea 
                    clearable
                    clear-icon="mdi-close-circle"
                    v-model="editedItem.reason"
                    label="Reason"
                    prepend-icon="mdi-file-document"
                  ></v-textarea>
                </v-col>
                <v-col cols="12" sm="6" md="12">
                  <v-menu
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  min-width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="editedItem.overtime_date"
                      label="Overtime Date"
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="overtime_date"
                    :allowed-dates="disabledDates"
                    no-title
                    scrollable
                    color="primary"
                  ></v-date-picker>
                </v-menu>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  <v-text-field
                    v-model="editedItem.start_time"
                    type="time"
                    @change="checkEndTime()"
                    prepend-icon="mdi-timer"
                    label="Start Time"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  <v-text-field
                    v-model="editedItem.end_time"
                    type="time"
                    @change="checkEndTime()"
                    prepend-icon="mdi-timer"
                    label="End Time"
                  ></v-text-field>
                  <span v-if="errorMessage !== null" style="color: red; font-style: italic">{{errorMessage}}</span>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="red" class="white--text" @click="close"> Cancel </v-btn>
            <v-btn color="success" @click="save"> Update </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <Loading v-if="loading"></Loading>


      <!-- DeleteModal -->
      <ConfirmationDel
        ref="confirmDel"
        @onConfirm="confirmDel($event)"
      ></ConfirmationDel>
            
    <v-data-table v-if="requests"
      :headers="headers"
      :items="overtime"
      :search="search"
      class="elevation-3">
      <template v-slot:top>

      <v-toolbar class="mb-2  hidden-sm-and-down" color="blue darken-1" dark flat>
      
        <!-- <v-toolbar-title v-if="!user_type.includes('general mngr')"
          >
          OVERTIME REQUEST
        </v-toolbar-title>
        <v-spacer></v-spacer> -->
        <v-text-field
          v-model="search"
          clearable
          flat
          solo-inverted
          hide-details
          prepend-inner-icon="mdi-magnify"
          label="Search"
        ></v-text-field>

        <createOvertime
        v-if="prp_assigned_id !== 'No PRP assign' && informationCheck !== null"
        ></createOvertime>

        <v-btn
          style="margin-left: 5%"
          v-if="(prp_assigned_id === 'No PRP assign' || informationCheck === null) && !user_type.includes('general mngr')"
          color="light blue darken-2"
          rounded
          outlined
          dark
          @click="messagePop()"
          >
          <v-icon v-if="!user_type.includes('general mngr')">mdi-plus</v-icon>
          <v-toolbar-title style="font-size: 16px" v-if="!user_type.includes('general mngr')">Make Request</v-toolbar-title>
        </v-btn>

        <Reminder
          ref="reminder"
          :message="messageCheck === 'prp' ? 'Please set your PRP Assign' : messageCheck === 'user' ? 'Please set your personal information' : messageCheck === 'combine' ? 'Please set your PRP assign and your Personal Information' : ''"
          link= "/MyAccount"
          routeName='go to MY ACCOUNT'
          >
        </Reminder>
      </v-toolbar>
      <v-container class="mb-2  hidden-md-and-up"  style="background-color:#3490dc" dark flat>
        <v-row>
          <v-col xs="6"><b style="color:white" >OVERTIME REQUEST</b>
          </v-col>
          <v-col xs="4">
             <v-btn
              color="light blue darken-2"
              rounded
              outlined
              dark
              @click="messagePop()"
              >
              <v-icon v-if="!user_type.includes('general mngr')">mdi-plus</v-icon>
              <v-toolbar-title style="font-size: 16px" v-if="!user_type.includes('general mngr')">Make Request</v-toolbar-title>
            </v-btn>
          </v-col>
        </v-row>
        <v-row>
           <v-text-field
          v-model="search"
          clearable
          flat
          solo-inverted
          hide-details
          prepend-inner-icon="mdi-magnify"
          label="Search"
        ></v-text-field>
        </v-row>
      </v-container>

    </template>
      <template v-slot:item.reason="{ item }">{{convertData(item)}}</template>
      <template v-slot:item.status.status_name="{ item }"> <v-chip :color="getColor(item.status.status_name)" :text-color="getColor(item.status.status_name) != '#ffa500'? 'white': 'black'">{{item.status.status_name === 'pending' ? 'PENDING' : item.status.status_name === 'approved' ? 'APPROVED' : item.status.status_name === 'disapproved' ? 'DISAPPROVED' : ''}}</v-chip> </template>
      <template v-slot:item.approver_role.role_name="{ item }"> <v-chip class="ma-2" outlined :color="prpColor(item.approver_role.role_name)">{{item.approver_role.role_name === 'prp emp' ? 'PRP' : item.approver_role.role_name === 'finance mngr' ? 'Finance Manager' : item.approver_role.role_name === 'hr mngr' ? 'HR' : item.approver_role.role_name === 'general mngr' ? 'General Manager': '' }}</v-chip> </template>
      <template v-slot:item.actions="{ item }">
        <v-icon medium disabled class="mr-2" v-if="((user_type.includes('emp') && user_type.includes('prp emp') && user_type.includes('hr mngr')) && item.status.status_name === 'approved')">mdi-pencil</v-icon>
        <v-icon medium disabled class="mr-2" v-else-if="((user_type.includes('emp') && user_type.includes('prp emp') && !(user_type.includes('hr mngr'))) && item.approver_role.role_name === 'general mngr')">mdi-pencil</v-icon>
        <v-icon medium disabled class="mr-2" v-else-if="((user_type.includes('emp') && !user_type.includes('prp emp') && !user_type.includes('hr mngr')) && ((item.approver_role.role_name === 'hr mngr') || item.approver_role.role_name === 'general mngr'))">mdi-pencil</v-icon>
        <v-icon medium class="mr-2" @click="editItem(item)" style="color:blue" v-else>mdi-pencil</v-icon>
        
        <v-icon medium disabled v-if="((user_type.includes('emp') && user_type.includes('prp emp') && user_type.includes('hr mngr')) && item.status.status_name === 'approved')">mdi-delete</v-icon>  
        <v-icon medium disabled v-else-if="((user_type.includes('emp') && user_type.includes('prp emp') && !(user_type.includes('hr mngr'))) && item.approver_role.role_name === 'general mngr')">mdi-delete</v-icon>  
        <v-icon medium disabled v-else-if="((user_type.includes('emp') && !user_type.includes('prp emp') && !user_type.includes('hr mngr')) && ((item.approver_role.role_name === 'hr mngr') || item.approver_role.role_name === 'general mngr'))">mdi-delete</v-icon>  
        <v-icon medium @click="deleteItem(item)" style="color:red" v-else>mdi-delete</v-icon>
      </template>
    </v-data-table>
    <SummaryTemplate
    ref="summary"
    ></SummaryTemplate>
  </v-container>
</template>
<style>
.input-name {
  font-size: 12px;
}
</style>
<script>
import createOvertime from "./modals/create_overtime.vue";
import Confirmation from "./modals/confirmation/confirm.vue";
import ConfirmationDel from "./modals/confirmation/delete.vue";
import SummaryTemplate from "./modals/exports/overtime_export.vue";
import Reminder from "./modals/confirmation/reminder.vue";
import Loading from "./Loading.vue";

export default {
  data: () => ({
    user_type: localStorage.getItem("user_type"),
    user_id: localStorage.getItem("id"),
    prp_assigned_id: localStorage.getItem("assigned_prp_id"),
    employees: localStorage.getItem("user_type").includes('general mngr') || localStorage.getItem("user_type").includes('admin') ? true: false,
    requests: localStorage.getItem("user_type").includes('general mngr') || localStorage.getItem("user_type").includes('admin') ? false: true,
    feedback: localStorage.getItem("user_type").includes('general mngr') || localStorage.getItem("user_type").includes('admin') ? false: false,
    dialog: false,
    error: false,
    errorMessage: null,
    overtime_date: null,
    messageCheck: '',
    informationCheck: null,
    loading:false,
    search: '',
    totalSeconds1: 0,
    totalSeconds2: 0,
    headers: [
      { text: "REASON", align: "start", value: "reason" },
      { text: "OVERTIME DATE", value: "date" },
      { text: "START TIME", value: "start_time" },
      { text: "END TIME", value: "end_time" },
      { text: "APPROVER", value: "approver_role.role_name"},
      { text: "STATUS", value: "status.status_name" },
      { text: "ACTIONS", value: "actions", sortable: false }
    ],
    headersEmp: [
      { text: "REQUESTER", align: "start", value: "user.first_name" },
      { text: "REASON", value: "reason" },
      { text: "OVERTIME DATE", value: "date" },
      { text: "START TIME", value: "start_time" },
      { text: "END TIME", value: "end_time" },
      { text: "APPROVER", value: "approver_role.role_name"},
      { text: "STATUS", value: "status.status_name" },
      { text: "ACTIONS", value: "actions", sortable: false }
    ],
    headersFeed: [
      { text: "REQUESTER", align: "start", value: "user.first_name" },
      { text: "REASON", value: "reason" },
      { text: "OVERTIME DATE", value: "date" },
      { text: "START TIME", value: "start_time" },
      { text: "END TIME", value: "end_time" },
      { text: "APPROVER", value: "approver_role.role_name"},
      { text: "STATUS", value: "status.status_name" }
    ],
    overtime: [],
    overtimePending: [],
    feedbacks: [],
    items: [
      { title: 'Approved Requests' },
      { title: 'Disapproved Requests' }
    ],
    approveThis: '',
    start_time: null,
    reason: null,
    end_time: null,
    editedIndex: null,
    editedItem: {
      reason: null,
      overtime_date: null,
      start_time: null,
      end_time: null
    },
    dates: [new Date().toISOString().substr(0, 10), ]
  }),
  components: {
    createOvertime,
    Confirmation,
    ConfirmationDel,
    SummaryTemplate,
    Reminder,
    Loading
  },
  computed: {
    dateRangeText () {
      return this.dates.join(' ~ ')
    },
  },
  mounted(){
    if(this.$store.getters.roleList.includes("admin")) {
      this.headersFeed.push({ text: "ACTIONS", value: "actions", sortable: false });
    }else{
      this.retrieve();
    }
    if ((this.user_type.includes("hr mngr") || this.user_type.includes("prp emp")) && !(this.user_type.includes("finance mngr"))) {
      this.retrieveOvertime();
      this.getAllFeedback();
      this.checkUser()
    } else if(this.user_type.includes("general mngr")) {
      this.retrieveOvertime();
      this.getAllFeedback();
      this.checkUser()
    }else{
      this.checkUser()
    }
  },
  methods: {
    checkEndTime(){
      var str1 = this.editedItem.start_time
      var str2 = this.editedItem.end_time
      str1 =  str1.split(':');
      str2 =  str2.split(':');
      this.totalSeconds1 = parseInt(str1[0] * 3600 + str1[1] * 60 + str1[0]);
      this.totalSeconds2 = parseInt(str2[0] * 3600 + str2[1] * 60 + str2[0]);
      this.totalSeconds1 < this.totalSeconds2 ? this.errorMessage = null : this.errorMessage = 'End time must be higher than the start time'
    },
    disabledDates(date) {
      return date >  new Date().toISOString().substr(0, 10)
    },
    retrieve(){
      this.loading = true;
      this.$axios.get("overtime_request/" + this.user_id).then(response => {
        this.overtime = response.data
        this.loading = false;
      }).catch(err => {
        this.$store.commit('changeMessage', 'Please Try Again')
        this.$store.commit('changeStatusMessage', true)
      })
    },
    checkUser(){
      this.$axios
        .get("user_info/" + this.user_id)
        .then(response => {
          if(response.data.user_information === null){
            this.informationCheck = null
          }else{
            this.informationCheck = true
          }
        })
    },
    messagePop(){
      if(this.prp_assigned_id === 'No PRP assign' && this.informationCheck === null){
        this.messageCheck = 'combine'
        this.$refs.reminder.show()
      }else if(this.informationCheck === null){
        this.messageCheck = 'user'
        this.$refs.reminder.show()
      }else {
        this.messageCheck = 'prp'
        this.$refs.reminder.show()
      }
    },
    retrieveOvertime() {
      let route =  "prp/overtime_request/pending/" + this.user_id
      if(this.$store.getters.roleList.includes("admin")) {
      route =  "admin/overtime_request/pending";
      }
      this.$axios
        .get(route)
        .then(response => {
          this.overtimePending = response.data;
        }).catch(err => {
          this.$store.commit('changeMessage', 'Please Try Again')
          this.$store.commit('changeStatusMessage', true)
        });
    },
    convertData(item) {
      return item.reason.toUpperCase();
    },
    editItem(item) {
      this.editedItem.id = item.id
      this.editedIndex = this.overtime.indexOf(item)
      this.editedItem.reason = item.reason
      this.editedItem.overtime_date = item.date
      this.editedItem.start_time = item.start_time
      this.editedItem.end_time = item.end_time
      this.dialog = true;
    },
    save() {
      if(this.editedItem.date !== null && this.editedItem.date !== '' && this.editedItem.start_time !== null && this.editedItem.start_time !== '' &&
      this.editedItem.end_time !== null && this.editedItem.end_time !== '' && this.editedItem.reason !== null && this.editedItem.reason !== '' && this.errorMessage === null){
        let params = {
          id: this.editedItem.id,
          date: this.editedItem.overtime_date,
          start_time: this.editedItem.start_time,
          end_time: this.editedItem.end_time,
          reason: this.editedItem.reason,
          prp_assigned_id: this.prp_assigned_id
        }     
        this.$axios.post('overtime_request/' + this.editedItem.id, params).then(response=>{
          this.$store.commit('changeMessage', 'Successfully Updated')
          this.$store.commit('changeStatusMessage', true)
          this.retrieve()
        }).catch(err => {
            this.$store.commit('changeMessage', 'Please Try Again')
            this.$store.commit('changeStatusMessage', true)
          })
        this.dialog = false;
      }else{
        this.error = true;
      }
    },

    deleteItem(item) {
      this.id = item.id;
      this.$refs.confirmDel.show(item)
    },

    confirmDel() {
      this.$axios
        .delete("overtime_request/" + this.id)
        .then(response => {
          this.$store.commit('changeMessage', 'Successfully Deleted')
          this.$store.commit('changeStatusMessage', true)
          this.retrieve();
        }).catch(err => {
            this.$store.commit('changeMessage', 'Please Try Again')
            this.$store.commit('changeStatusMessage', true)
          });
    },
    close(){
      this.dialog = false
    },
    approveModal(item) {
      this.approveThis = 'approve'
      this.id = item.id;
      this.$refs.confirms.show(item)
    },
    confirm(item){
      if(this.approveThis === 'approve'){
        this.approve(item)
      }else{
        this.disapprove()
      }
    },
    disapproveModal(item) {
      this.approveThis = 'disapproved'
      this.id = item.id;
      this.$refs.confirms.show(item)
    },
    approve(item) {
      var permission = "prp";
      if(this.$store.getters.roleList.includes("admin")) {
        permission = "admin";
      }
      let route = permission + "/overtime_request/feedback/" + this.id;
      if(item.id.approver_role_id === 5){
          let parameter = {
          user_id: this.user_id,
          status_id: 2
        };     
      this.$axios.post(route, parameter)
        .then(response => {
          this.$store.commit('changeMessage', 'Approved Successfully')
          this.$store.commit('changeStatusMessage', true)
          this.retrieveOvertime();
          this.getAllFeedback();
        }).catch(err => {
            this.$store.commit('changeMessage', 'Please Try Again')
            this.$store.commit('changeStatusMessage', true)
          });
      }else{
        let parameter = {
          user_id: this.user_id,
          status_id: 1
        };
        this.$axios
          .post( route, parameter)
          .then(response => {
            this.$store.commit('changeMessage', 'Approved Successfully')
            this.$store.commit('changeStatusMessage', true)
            this.retrieveOvertime();
            this.getAllFeedback();
          }).catch(err => {
            this.$store.commit('changeMessage', 'Please Try Again')
            this.$store.commit('changeStatusMessage', true)
          });
      }
    },
    disapprove() {
      var permission = "prp";
      if(this.$store.getters.roleList.includes("admin")) {
        permission = "admin";
      }
      let route = permission + "/overtime_request/feedback/" + this.id;
      let parameter = {
        user_id: this.user_id,
        status_id: 3
      };
      this.$axios
        .post(route, parameter)
        .then(res => {
          this.$store.commit('changeMessage', 'Disapproved Successfully')
          this.$store.commit('changeStatusMessage', true)
          this.retrieveOvertime();
          this.getAllFeedback();
        }).catch(err => {
            this.$store.commit('changeMessage', 'Please Try Again')
            this.$store.commit('changeStatusMessage', true)
          });
    },
    getAllFeedback() {
      let route = "prp/overtime_request/feedbacked/" + this.user_id;
      if(this.$store.getters.roleList.includes('admin')) {
        route = "admin/overtime_request";
      }
      this.$axios
        .get(route)
        .then(response => {
          if(!this.$store.getters.roleList.includes('admin')) {
            this.feedbacks = response.data.feedbacked_overtime_requests;
          }else {
            this.feedbacks = response.data;
          }
        });
    },
    getColor(status) {
      if (status === 'pending') return '#ffa500'
      else if (status === 'approved') return 'green'
      else return 'red'
    },
    prpColor(approver_role) {
      if (approver_role === "prp emp") return "#0047ab"
      else if (approver_role === "hr mngr") return "blue"
      else if (approver_role === "finance mngr") return "#00004d"
      else if (approver_role === "emp") return "0f52ba"
      else return "#002366";
    },
    summary(item){
      this.$refs.summary.show(this.dates[0], this.dates[1], item)
    }
  }
}
</script>