<template>
  <div>
    <v-toolbar flat>
      <template v-slot:extension>
        <v-tabs
          dark
          background-color="primary"
          fixed-tabs
          v-if="(user_type.includes('hr mngr') || user_type.includes('prp emp') || user_type.includes('general mngr')) && !user_type.includes('finance mngr')"
        >
          <v-tabs-slider></v-tabs-slider>
          <v-tab @click="employees = false, requests = true, feedback = false">My Requests</v-tab>
          <v-tab @click="requests = false, employees = true, feedback = false">Employees Requests</v-tab>
          <v-tab @click="requests = false, employees = false, feedback = true">History</v-tab>
        </v-tabs>
      </template>
    </v-toolbar>

    <!-- Feedback -->
    <v-data-table v-if="feedback" :headers="headersFeed" :items="feedbacks" class="elevation-3">
      <template v-slot:top>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat>
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
          <v-btn color="light blue darken-2" outlined>SUMMARY</v-btn>
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
      </template>
      <template v-slot:item.status.status_name="{ item }"> <v-chip :color="getColor(item.status.status_name)">{{item.status.status_name === 'pending' ? 'PENDING' : item.status.status_name === 'approve' ? 'APPROVE' : item.status.status_name === 'disapproved' ? 'DISAPPROVE' : ''}}</v-chip> </template>
      <template v-slot:item.approver_role.role_name="{ item }"> <v-chip class="ma-2" outlined :color="prpColor(item.approver_role.role_name)">{{item.approver_role.role_name === 'prp emp' ? 'PRP' : item.approver_role.role_name === 'finance mngr' ? 'Finance Manager' : item.approver_role.role_name === 'hr mngr' ? 'HR' : item.approver_role.role_name === 'general mngr' ? 'General Manager': '' }}</v-chip> </template>
    </v-data-table>

    <!-- Pending Requests -->
    <v-data-table v-if="employees" :headers="headersEmp" :items="prpPending" class="elevation-3">
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
      <template v-slot:item.status.status_name="{ item }"> <v-chip :color="getColor(item.status.status_name)">{{item.status.status_name === 'pending' ? 'PENDING' : item.status.status_name === 'approve' ? 'APPROVE' : item.status.status_name === 'disapprove' ? 'DISAPPROVE' : ''}}</v-chip> </template>
      <template v-slot:item.approver_role.role_name="{ item }"> <v-chip class="ma-2" outlined :color="prpColor(item.approver_role.role_name)">{{item.approver_role.role_name === 'prp emp' ? 'PRP' : item.approver_role.role_name === 'finance mngr' ? 'Finance Manager' : item.approver_role.role_name === 'hr mngr' ? 'HR' : item.approver_role.role_name === 'general mngr' ? 'General Manager': '' }}</v-chip> </template>
      <template v-slot:item.actions="{ item }">
        <v-icon small class="mr-2" @click="approveModal(item)">mdi-check-decagram</v-icon>
        <v-icon small @click="disapproveModal(item)">mdi-close-circle</v-icon>
      </template>
    </v-data-table>

    <Confirmation
      ref="confirms"
      :title="approveThis === 'approve' || approveThis === 'disapprove' ? 'Confirmation' : approveThis === 'message' ? 'Reminder' : ''"
      :message="approveThis === 'approve' ? 'Are you sure you want to approve this request?' : approveThis === 'disapprove' ? 'Are you sure you want to reject this request?' : approveThis === 'message' ? 'Set-up your PRP first' : ''"
      @onConfirm="confirm($event)"
    ></Confirmation>
    <!-- End of Table -->

    <!-- Edit Modal -->
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card class="mt-5">
        <v-card-title>
          <span class="headline">Leave Request Form</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <span v-if="error" style="color: red; font-style: italic">All data are required!</span>
            <v-row>
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
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
          <v-btn color="blue darken-1" text @click="save">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Delete Modal -->
    <ConfirmationDel
      ref="confirmDel"
      @onConfirm="confirmDel($event)"
    ></ConfirmationDel>

    <v-data-table
      v-if="requests && (!user_type.includes('hr mngr') || !user_type.includes('finance mngr') || !user_type.includes('prp emp'))"
      :headers="headers"
      :items="request"
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

          <createLeave v-if="prp_assigned_id !== 'No Prp assign'"></createLeave>
          
          <v-btn
            v-if="prp_assigned_id === 'No Prp assign'"
            color="light blue darken-2"
            outlined
            @click="messagePop()"
          >
          <v-icon>mdi-plus</v-icon>
          <v-toolbar-title style="font-size: 16px"
            >Make Request</v-toolbar-title
          >
          </v-btn>

        </v-toolbar>
      </template>
      <template v-slot:item.status.status_name="{ item }"> <v-chip :color="getColor(item.status.status_name)">{{item.status.status_name === 'pending' ? 'PENDING' : item.status.status_name === 'approve' ? 'APPROVE' : item.status.status_name === 'disapprove' ? 'DISAPPROVE' : ''}}</v-chip> </template>
      <template v-slot:item.approver_role.role_name="{ item }"> <v-chip class="ma-2" outlined :color="prpColor(item.approver_role.role_name)">{{item.approver_role.role_name === 'prp emp' ? 'PRP' : item.approver_role.role_name === 'finance mngr' ? 'Finance Manager' : item.approver_role.role_name === 'hr mngr' ? 'HR' : item.approver_role.role_name === 'general mngr' ? 'General Manager': '' }}</v-chip> </template>
      <template v-slot:item.actions="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
        <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
      </template>
    </v-data-table>
  </div>
</template>
<style>
.input-name {
  font-size: 12px;
}
</style>
<script>

import createLeave from "./modals/exports/leave_export.vue";
import moment from "moment";
import Confirmation from "./modals/confirmation/confirm.vue";
import ConfirmationDel from "./modals/confirmation/delete.vue";
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
    error2: false,
    disable: false,
    end_date: null,
    start_date: null,
    search: null,
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
      end_date: null
    },
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
  }),
  components: {
    createLeave,
    Confirmation,
    ConfirmationDel
  },
  computed: {
    dateRangeText () {
      return this.dates.join(' ~ ')
    },
  },
  mounted() {
    if ( this.user_type.includes("hr mngr") || this.user_type.includes("prp emp") || this.user_type.includes("general mngr")) {
      this.retrievePendingPrp();
      this.retrieve();
      this.getAllFeedback();
    } else {
      this.retrieve();
    }
  },
  methods: {
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
        .get("http://localhost:8000/leave_request/" + this.user_id)
        .then(response => {
          this.request = response.data;
        })
        .catch(e => {
          console.log(e);
        });
    },
    retrievePendingPrp() {
      this.$axios
        .get("http://localhost:8000/prp/leave_request/pending/" + this.user_id)
        .then(response => {
          this.prpPending = response.data;
        })
        .catch(e => {
          console.log(e);
        });
    },
    editItem(item) {
      this.editedItem.id = item.id;
      this.editedIndex = this.request.indexOf(item);
      this.editedItem.selectedLeaveType = item.leave_type_id;
      this.editedItem.total_days = item.number_of_days;
      this.total_days_with_text = item.number_of_days + " days of leave";
      this.editedItem.start_date = item.start_date;
      this.editedItem.end_date = item.end_date;
      this.dialog = true;
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
            "http://localhost:8000/leave_request/" + this.editedItem.id,
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
        .delete("http://localhost:8000/leave_request/" + this.id)
        .then(response => {
          this.retrieve();
        });
    },
    close() {
      this.dialog = false;
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
    approveModal(item) {
      this.approveThis = 'approve'
      this.id = item.id;
      this.$refs.confirms.show(item)
    },
    messagePop(){
      this.approveThis = 'message'
      this.$refs.confirms.show()
    },
    confirm(){
      if(this.approveThis === 'approve'){
        this.approve()
      }else{
        this.disapprove()
      }
    },
    disapproveModal(item) {
      this.approveThis = 'disapprove'
      this.id = item.id;
      this.$refs.confirms.show(item)
    },
    approve() {
      let parameter = {
        user_id: this.user_id,
        status_id: 1
      };
      this.$axios
        .post(
          "http://localhost:8000/prp/leave_request/feedback/" + this.id,
          parameter
        )
        .then(response => {
          this.retrievePendingPrp();
          this.getAllFeedback();
        });
    },
    disapprove() {
      let parameter = {
        user_id: this.user_id,
        status_id: 3
      };
      this.$axios
        .post(
          "http://localhost:8000/prp/leave_request/feedback/" + this.id,
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
          "http://localhost:8000/prp/leave_request/feedbacked/" + this.user_id
        )
        .then(response => {
          this.feedbacks = response.data.feedbacked_leave_requests;
        });
    }
  }
};
</script>
