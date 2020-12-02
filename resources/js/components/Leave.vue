<template>
  <div>
    <v-toolbar flat>
      <template v-slot:extension>
        <v-tabs
          dark
          background-color="primary"
          fixed-tabs
          v-if="(user_type.includes('hr mngr') || user_type.includes('prp emp') || user_type.includes('general mngr'))"
        >
          <v-tabs-slider></v-tabs-slider>
          <v-tab @click="employees = false, requests = true, feedback = false">My Requests</v-tab>
          <v-tab @click="requests = false, employees = true, feedback = false">Employees Requests</v-tab>
          <v-tab @click="requests = false, employees = false, feedback = true">History</v-tab>
        </v-tabs>
      </template>
    </v-toolbar>

    <!-- Feedback -->
    <v-data-table v-if="feedback" :headers="headersFeed" :items="feedbacks" :search="search" class="elevation-3">
      <template v-slot:top>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat v-if="(user_type.includes('hr mngr') || user_type.includes('general mngr'))">
          <v-col class="mt-8">
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
          <!-- <v-btn color="light blue darken-2" @click="summary()" outlined>SUMMARY</v-btn> -->
          <v-menu
            transition="slide-y-transition"
            bottom
          >
            <template v-slot:activator="{ on, attrs }">
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
          <v-divider class="mx-4" vertical></v-divider>
          <v-spacer></v-spacer>
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
      <template v-slot:item.status.status_name="{ item }"> <v-chip :color="getColor(item.status.status_name)" :text-color="getColor(item.status.status_name) != '#ffa500'? 'white': 'black'">{{item.status.status_name === 'pending' ? 'PENDING' : item.status.status_name === 'approved' ? 'APPROVED' : item.status.status_name === 'disapproved' ? 'DISAPPROVED' : ''}}</v-chip> </template>
      <template v-slot:item.approver_role.role_name="{ item }"> <v-chip class="ma-2" outlined :color="prpColor(item.approver_role.role_name)">{{item.approver_role.role_name === 'prp emp' ? 'PRP' : item.approver_role.role_name === 'finance mngr' ? 'Finance Manager' : item.approver_role.role_name === 'hr mngr' ? 'HR' : item.approver_role.role_name === 'general mngr' ? 'General Manager': '' }}</v-chip> </template>
    </v-data-table>

    <!-- Pending Requests -->
    <v-data-table v-if="employees" :headers="headersEmp" :items="prpPending" 
      :search="search" class="elevation-3">
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
      <template v-slot:item.status.status_name="{ item }"> <v-chip :color="getColor(item.status.status_name)" :text-color="getColor(item.status.status_name) != '#ffa500'? 'white': 'black'">{{item.status.status_name === 'pending' ? 'PENDING' : item.status.status_name === '"approved"' ? 'APPROVED' : item.status.status_name === 'disapproved' ? 'DISAPPROVED' : ''}}</v-chip> </template>
      <template v-slot:item.approver_role.role_name="{ item }"> <v-chip class="ma-2" outlined :color="prpColor(item.approver_role.role_name)">{{item.approver_role.role_name === 'prp emp' ? 'PRP' : item.approver_role.role_name === 'finance mngr' ? 'Finance Manager' : item.approver_role.role_name === 'hr mngr' ? 'HR' : item.approver_role.role_name === 'general mngr' ? 'General Manager': '' }}</v-chip> </template>
      <template v-slot:item.actions="{ item }">
        <v-icon medium class="mr-2" @click="approveModal(item)" style="color:green">mdi-check-decagram</v-icon>
        <v-icon medium @click="disapproveModal(item)" style="color:red">mdi-close-circle</v-icon>
      </template>
    </v-data-table>

    <Confirmation
      ref="confirms"
      :title="approveThis === 'approve' ||'disapproved' ? 'Confirmation' : ''"
      :message="approveThis === 'approve' ? 'Are you sure you want to approve this request?' : approveThis === 'disapproved' ? 'Are you sure you want to reject this request?' : ''"
      @onConfirm="confirm($event)"
    ></Confirmation>
    <!-- End of Table -->

    <!-- Edit Modal -->
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card class="mt-5">
        <v-toolbar class="mb-2" color="blue darken-1" dark flat>
            <v-card-title>
                <span class="headline-bold">LEAVE REQUEST FORM</span>
            </v-card-title>
        </v-toolbar>
        <v-card-text>
          <v-container>
            <span v-if="error" style="color: red; font-style: italic">All data are required!</span>
            <v-tabs
            dark
            background-color="primary"
            fixed-tabs
            >
                <v-tabs-slider></v-tabs-slider>
                <v-tab @click="half = false, whole = true">Whole Day</v-tab>
                <v-tab @click="whole = false, half = true">Half Day</v-tab>
            </v-tabs>
            <v-row v-if="whole">
              <v-col cols="12" sm="6" md="6">
                <v-select
                  :items="leaveType"
                  label="Type of Leave"
                  v-model="editedItem.selectedLeaveType"
                  item-text="name"
                  item-value="value"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field
                  label="Total Day/s of Leave*"
                  type="text"
                  v-model="total_days_with_text"
                  disabled
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <span
                  v-if="error2"
                  style="color: red; font-style: italic"
                >Start date must not be higher than End date!</span>
                <v-menu
                  :close-on-content-click="true"
                  transition="scale-transition"
                  offset-y
                  min-width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="editedItem.start_date"
                      label="Start Date"
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="editedItem.start_date"
                    :allowed-dates="disabledDates"
                    no-title
                    scrollable
                    color="primary"
                    @change="changeDate()"
                  ></v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <span
                  v-if="error1"
                  style="color: red; font-style: italic"
                >End date must be higher than start date!</span>
                <v-menu
                  :close-on-content-click="true"
                  transition="scale-transition"
                  offset-y
                  min-width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="editedItem.end_date"
                      label="End Date"
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                      :disabled="disable"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="editedItem.end_date"
                    :allowed-dates="disabledDates2"
                    no-title
                    scrollable
                    color="primary"
                    @change="changeDate()"
                  ></v-date-picker>
                </v-menu>
              </v-col>
            </v-row>
            <v-row v-if="half">
              <v-col cols="12">
                <v-select
                  :items="leaveType"
                  label="Reason*"
                  v-model="editedItem.selectedLeaveType"
                  item-text="name"
                  item-value="value"
                  required
                ></v-select>
              </v-col>
              <v-col cols="4">
                <v-select
                  :items="halfSched"
                  label="Start Time*"
                  v-model="editedItem.start_time"
                  item-text="name"
                  item-value="value"
                  @change="timeClick()"
                  required
                ></v-select>
              </v-col>
              <v-col cols="4">
                <v-select
                  :items="halfSchedCorrespond"
                  disabled
                  label="End Time*"
                  v-model="editedItem.end_time"
                  item-text="name"
                  item-value="value"
                  required
                ></v-select>
              </v-col>
              <v-col cols="4">
                <v-text-field
                  label="Total Day/s of Leave*"
                  type="text"
                  v-model="half_days_with_text"
                  disabled
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red" class="white--text" @click="close">Cancel</v-btn>
          <v-btn color="success" @click="save">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Delete Modal -->
    <ConfirmationDel
      ref="confirmDel"
      @onConfirm="confirmDel($event)"
    ></ConfirmationDel>

    <v-data-table
      v-if="requests"
      :headers="headers"
      :items="request"
      :search="search"
      class="elevation-3"
    >
      <template v-slot:top>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat>
          <v-toolbar-title class="col pa-3 py-4 white--text">LEAVE REQUEST</v-toolbar-title>
          <v-text-field
            v-model="search"
            clearable
            flat
            solo-inverted
            hide-details
            prepend-inner-icon="mdi-magnify"
            label="Search"
          ></v-text-field>

          <createLeave v-if="prp_assigned_id !== 'No PRP assign' && informationCheck !== null"></createLeave>
          
          <v-btn
          style="margin-left: 5%"
          v-if="prp_assigned_id === 'No PRP assign' || informationCheck === null"
          color="light blue darken-2"
          rounded
          outlined
          dark
          @click="messagePop()"
        >
          <v-icon>mdi-plus</v-icon>
          <v-toolbar-title style="font-size: 16px">Make Request</v-toolbar-title>
        </v-btn>

          <Reminder
          ref="reminder"
          :message="messageCheck === 'prp' ? 'Please set your PRP Assign' : messageCheck === 'user' ? 'Please set your personal information' : messageCheck === 'combine' ? 'Please set your PRP assign and your Personal Information' : ''"
          ></Reminder>

        </v-toolbar>
      </template>
      <template v-slot:item.number_of_days="{ item }">{{item.number_of_days === 0 ? 'Half Day' : item.number_of_days + ' ' + 'Day/s' }}</template>
      <template v-slot:item.status.status_name="{ item }">
        <v-chip :color="getColor(item.status.status_name)" :text-color="getColor(item.status.status_name) != '#ffa500'? 'white': 'black'">{{item.status.status_name === 'pending' ? 'PENDING' : item.status.status_name === 'approved' ? 'APPROVED' : item.status.status_name === 'disapproved' ? 'DISAPPROVED' : ''}}</v-chip> </template>
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

  </div>
</template>
<style>
.input-name {
  font-size: 12px;
}
</style>
<script>

import createLeave from "./modals/create_leave.vue";
import moment from "moment";
import Confirmation from "./modals/confirmation/confirm.vue";
import ConfirmationDel from "./modals/confirmation/delete.vue";
import Reminder from "./modals/confirmation/reminder.vue";
import SummaryTemplate from "./modals/exports/leave_export.vue";
export default {
  // "employees = false, requests = true, feedback = false"
  data: () => ({
    user_type: localStorage.getItem("user_type"),
    user_id: localStorage.getItem("id"),
    prp_assigned_id: localStorage.getItem("assigned_prp_id"),
    employees: false,
    requests: true,
    feedback: false,  
    dialog: false,
    error: false,
    error1: false,
    informationCheck: null,
    whole: true,
    half: false,
    error2: false,
    disable: false,
    end_date: null,
    start_date: null,
    search: '',
    headers: [
      { text: "TYPE OF LEAVE", align: "start", value: "leave_type.leave_type_name" },
      { text: "TOTAL DAY/S LEAVE", value: "number_of_days" },
      { text: "START DATE", value: "start_date" },
      { text: "END DATE", value: "end_date" },
      { text: "APPROVER", value: "approver_role.role_name" },
      { text: "STATUS", value: "status.status_name" },
      { text: "ACTIONS", value: "actions", sortable: false }
    ],
    headersEmp: [
      { text: "REQUESTER", align: "start", value: "user.first_name" },
      { text: "TYPE OF LEAVE", value: "leave_type.leave_type_name" },
      { text: "TOTAL DAY/S LEAVE", value: "number_of_days" },
      { text: "START DATE", value: "start_date" },
      { text: "END DATE", value: "end_date" },
      { text: "APPROVER", value: "approver_role.role_name" },
      { text: "STATUS", value: "status.status_name" },
      { text: "ACTIONS", value: "actions", sortable: false }
    ],
    headersFeed: [
      { text: "REQUESTER", align: "start", value: "user.first_name" },
      { text: "TYPE OF LEAVE", value: "leave_type.leave_type_name" },
      { text: "TOTAL DAY/S LEAVE", value: "number_of_days" },
      { text: "START DATE", value: "start_date" },
      { text: "END DATE", value: "end_date" },
      { text: "APPROVER", value: "approver_role.role_name" },
      { text: "STATUS", value: "status.status_name" }
    ],
    request: [],
    prpPending: [],
    feedbacks: [],
    editedIndex: null,
    prp: null,
    menu: false,
    total_days: null,
    total_days_with_text: null,
    editedItem: {
      id: null,
      selectedLeaveType: null,
      total_days: null,
      start_date: null,
      end_date: null,
      start_time: null,
      end_time: null
    },
    items: [
      { title: 'Approved Requests' },
      { title: 'Disapproved Requests' }
    ],
    halfSched: [
        {value: 1, name: "10am"}, 
        {value: 2, name: "2pm"}
      ],
      halfSchedCorrespond: [
        {value: 1, name: "2pm"}, 
        {value: 2, name: "7pm"}
      ],
    dates: [new Date().toISOString().substr(0, 10), ],
    leaveType: [
      { value: 1, name: "Sick Leave" },
      { value: 2, name: "Solo Parent Leave" },
      { value: 3, name: "Vacation Leave" },
      { value: 4, name: "Emergency Leave" },
      { value: 5, name: "Paternity Leave" },
      { value: 6, name: "Maternity Leave" }
    ],
    approveThis: '',
    messageCheck: '',
  }),
  components: {
    createLeave,
    Confirmation,
    ConfirmationDel,
    SummaryTemplate,
    Reminder
  },
  computed: {
    dateRangeText () {
      return this.dates.join(' ~ ')
    },
  },
  mounted() {
    if ((this.user_type.includes("hr mngr") || this.user_type.includes("prp emp") || this.user_type.includes("general mngr")) && !(this.user_type.includes("finance mngr"))) {
      this.retrievePendingPrp();
      this.retrieve();
      this.getAllFeedback();
      this.checkUser()
    } else {
      this.retrieve();
      this.checkUser()
    }
  },
  methods: {
    timeClick(){
      if(this.start_time === 1){
        this.end_time = this.halfSchedCorrespond[0]
      }else{
        this.end_time = this.halfSchedCorrespond[1]
      }
      console.log(this.end_time)
    },
    changeDate() {
      if (
        this.editedItem.start_date !== null &&
        this.editedItem.start_date !== ""
      ) {
        let start = moment(String(this.editedItem.start_date));
        let end = moment(String(this.editedItem.end_date));
        if (end >= start) {
          let diff = end.diff(start);
          let differenceInDay = diff / 1000 / 60 / 60 / 24;
          this.editedItem.total_days = differenceInDay;
          this.total_days_with_text = differenceInDay + " days of leave";
          this.error1 = false;
          this.error2 = false;
        } else {
          this.error1 = true;
          this.error2 = true;
        }
        this.disable = false;
      } else {
        this.disable = true;
      }
    },
    retrieve() {
      this.$axios
        .get("leave_request/" + this.user_id)
        .then(response => {
          this.request = response.data;
        })
        .catch(e => {
          console.log(e);
        });
    },
    retrievePendingPrp() {
      this.$axios
        .get("prp/leave_request/pending/" + this.user_id)
        .then(response => {
          this.prpPending = response.data;
        })
        .catch(e => {
          console.log(e);
        });
    },
    editItem(item) {
      if(this.whole === true){
        this.editedItem.id = item.id;
        this.editedIndex = this.request.indexOf(item);
        this.editedItem.selectedLeaveType = item.leave_type_id;
        this.editedItem.total_days = item.number_of_days;
        this.total_days_with_text = item.number_of_days + " days of leave";
        this.editedItem.start_date = item.start_date;
        this.editedItem.end_date = item.end_date;
        this.dialog = true;
      }else{
        this.editedItem.id = item.id;
        this.editedIndex = this.request.indexOf(item);
          this.start_time !== null &&
          this.error1 === false
        this.editedItem.selectedLeaveType = item.leave_type_id;
        this.editedItem.total_days = item.number_of_days;
        this.total_days_with_text = item.number_of_days + " days of leave";
        this.editedItem.start_date = item.start_date;
        this.editedItem.end_date = item.end_date;
        this.dialog = true;
      }
    },
    save() {
      if (
        this.editedItem.selectedLeaveType !== null &&
        this.editedItem.total_days !== null &&
        this.editedItem.start_date !== null &&
        this.editedItem.end_date !== null &&
        this.editedItem.selectedLeaveType !== "" &&
        this.editedItem.total_days !== "" &&
        this.editedItem.start_date !== "" &&
        this.editedItem.end_date !== "" &&
        this.error2 === false
      ) {
        let params = {
          id: this.editedItem.id,
          leave_type_id: this.editedItem.selectedLeaveType,
          number_of_days: this.editedItem.total_days,
          start_date: this.editedItem.start_date,
          end_date: this.editedItem.end_date,
          prp_assigned_id: this.prp_assigned_id
        };
        this.$axios
          .post(
            "leave_request/" + this.editedItem.id,
            params
          )
          .then(response => {
            this.retrieve();
          });
        this.dialog = false;
      } else {
        this.error = true;
      }
    },
    disabledDates(date) {
      return date > new Date().toISOString().substr(0, 10);
    },
    disabledDates2(date) {
      return (
        date > new Date(this.editedItem.start_date).toISOString().substr(0, 10)
      );
      this.differenceDates();
    },

    deleteItem(item) {
      this.id = item.id;
      this.$refs.confirmDel.show(item)
    },
    confirmDel(){
      this.$axios
        .delete("leave_request/" + this.id)
        .then(response => {
          this.retrieve();
        });
    },
    close() {
      this.dialog = false;
    },
    getColor(status) {
      if (status === "pending") return "#ffa500"
      else if (status === "disapproved") return "red"
      else return "green";
    },
    prpColor(approver_role) {
      if (approver_role === "prp emp") return "#0047ab"
      else if (approver_role === "hr mngr") return "blue"
      else if (approver_role === "finance mngr") return "#00004d"
      else if (approver_role === "emp") return "0f52ba"
      else return "#002366";
    },
    approveModal(item) {
      this.approveThis = 'approve'
      this.id = item.id;
      this.$refs.confirms.show(item)
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
      if(item.id.approver_role_id === 5) {
        let parameter = {
          user_id: this.user_id,
          status_id: 2
        };
        this.$axios
          .post(
            "prp/leave_request/feedback/" + this.id,
            parameter
          )
          .then(response => {
            this.retrievePendingPrp();
            this.getAllFeedback();
          });
      }else{
        let parameter = {
          user_id: this.user_id,
          status_id: 1
        };
        this.$axios
          .post(
            "prp/leave_request/feedback/" + this.id,
            parameter
          )
          .then(response => {
            this.retrievePendingPrp();
            this.getAllFeedback();
          });
      }
    },
    disapprove() {
      let parameter = {
        user_id: this.user_id,
        status_id: 3
      };
      this.$axios
        .post(
          "prp/leave_request/feedback/" + this.id,
          parameter
        )
        .then(res => {
          this.retrievePendingPrp();
          this.getAllFeedback();
        });
    },
    getAllFeedback() {
      this.$axios
        .get(
          "prp/leave_request/feedbacked/" + this.user_id
        )
        .then(response => {
          this.feedbacks = response.data.feedbacked_leave_requests;
        });
    },
    summary(item){
      this.$refs.summary.show(this.dates[0], this.dates[1], item)
    }
  }
};
</script>
