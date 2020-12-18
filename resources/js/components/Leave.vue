<template>
  <div>
    <v-toolbar flat>
      <template v-slot:extension>
        <v-tabs
          dark
          background-color="primary"
          fixed-tabs
          v-if="((user_type.includes('hr mngr') || user_type.includes('prp emp') || user_type.includes('general mngr')) && !user_type.includes('finance mngr'))"
        >
          <v-tabs-slider></v-tabs-slider>
          <v-tab
            v-if="!user_type.includes('general mngr') && !user_type.includes('admin')"
            @click="employees = false, requests = true, feedback = false"
          >My Requests</v-tab>
          <v-tab @click="requests = false, employees = true, feedback = false">Employees Requests</v-tab>
          <v-tab @click="requests = false, employees = false, feedback = true">History</v-tab>
        </v-tabs>
      </template>
    </v-toolbar>

    <!-- Feedback -->
    <v-data-table
      v-if="feedback"
      :headers="headersFeed"
      :items="feedbacks"
      :search="search"
      class="elevation-3"
    >
      <template v-slot:item.number_of_days="{ item }">
        {{
        displayTimeLengthInText(item.number_of_days)
        }}
      </template>
      <!-- format time -->
      <template v-slot:item.start_date="{ item }">
        {{
        formatDateStandard(item.start_date)
        }}
      </template>
      <template v-slot:item.end_date="{ item }">
        {{
        formatDateStandard(item.end_date)
        }}
      </template>
      <template v-slot:top>
        <v-toolbar
          class="mb-2"
          color="blue darken-1"
          dark
          flat
          v-if="(user_type.includes('hr mngr') || user_type.includes('general mngr'))"
        >
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
              <v-date-picker v-model="dates" range></v-date-picker>
            </v-menu>
          </v-col>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <!-- <v-btn color="light blue darken-2" @click="summary()" outlined>SUMMARY</v-btn> -->
          <v-menu transition="slide-y-transition" bottom>
            <template v-slot:activator="{ on, attrs }" v-if="!user_type.includes('general mngr')">
              <v-btn class="purple" color="primary" dark v-bind="attrs" v-on="on">Summary</v-btn>
            </template>
            <v-list>
              <v-list-item v-for="(item, i) in items" :key="i">
                <v-list-item-title
                  @click="summary(item.title)"
                  style="cursor: pointer;"
                >{{ item.title }}</v-list-item-title>
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
        <v-toolbar
          class="mb-2"
          color="blue darken-1"
          dark
          flat
          v-if="((user_type.includes('prp emp') || user_type.includes('finance mngr')) && (!user_type.includes('hr mngr') && !user_type.includes('general mngr')))"
        >
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
      <template v-slot:item.status.status_name="{ item }">
        <v-chip
          :color="getColor(item.status.status_name)"
          :text-color="getColor(item.status.status_name) != '#ffa500'? 'white': 'black'"
        >{{item.status.status_name === 'pending' ? 'PENDING' : item.status.status_name === 'approved' ? 'APPROVED' : item.status.status_name === 'disapproved' ? 'DISAPPROVED' : ''}}</v-chip>
      </template>
      <template v-slot:item.approver_role.role_name="{ item }">
        <v-chip
          class="ma-2"
          outlined
          :color="prpColor(item.approver_role.role_name)"
        >{{item.approver_role.role_name === 'prp emp' ? 'PRP' : item.approver_role.role_name === 'finance mngr' ? 'Finance Manager' : item.approver_role.role_name === 'hr mngr' ? 'HR' : item.approver_role.role_name === 'general mngr' ? 'General Manager': '' }}</v-chip>
      </template>
      <template v-slot:item.number_of_days="{ item }">
        {{
        displayTimeLengthInText(item.number_of_days)
        }}
      </template> 
    </v-data-table>

    <!-- Pending Requests -->
    <v-data-table
      v-if="employees"
      :headers="headersEmp"
      :items="prpPending"
      :search="search"
      class="elevation-3"
    >
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
      <template v-slot:item.user.first_name="{ item }">
        {{
        item.user.first_name + ' ' + item.user.last_name
        }}
      </template>
      <template v-slot:item.number_of_days="{ item }">
        {{
        displayTimeLengthInText(item.number_of_days)
        }}
      </template>
      <!-- format time -->
      <template v-slot:item.start_date="{ item }">
        {{
        formatDateStandard(item.start_date)
        }}
      </template>
      <template v-slot:item.end_date="{ item }">
        {{
        formatDateStandard(item.end_date)
        }}
      </template>
      <template v-slot:item.status.status_name="{ item }">
        <v-chip
          :color="getColor(item.status.status_name)"
          :text-color="getColor(item.status.status_name) != '#ffa500'? 'white': 'black'"
        >{{item.status.status_name === 'pending' ? 'PENDING' : item.status.status_name === '"approved"' ? 'APPROVED' : item.status.status_name === 'disapproved' ? 'DISAPPROVED' : ''}}</v-chip>
      </template>
      <template v-slot:item.approver_role.role_name="{ item }">
        <v-chip
          class="ma-2"
          outlined
          :color="prpColor(item.approver_role.role_name)"
        >{{item.approver_role.role_name === 'prp emp' ? 'PRP' : item.approver_role.role_name === 'finance mngr' ? 'Finance Manager' : item.approver_role.role_name === 'hr mngr' ? 'HR' : item.approver_role.role_name === 'general mngr' ? 'General Manager': '' }}</v-chip>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon
          medium
          class="mr-2"
          @click="approveModal(item)"
          style="color:green"
        >mdi-check-decagram</v-icon>
        <v-icon medium @click="disapproveModal(item)" style="color:red">mdi-close-circle</v-icon>
      </template>
    </v-data-table>

    <Confirmation
      ref="confirms"
      :title="approveThis === 'approve' ||'disapproved' ? 'Confirmation' : ''"
      :message="!user_type.includes('admin') ? 
      approveThis === 'approve' ? 'Are you sure you want to approve this request?' : approveThis === 'disapproved' ? 'Are you sure you want to reject this request?' : '' :
      approveThis === 'approve' ? 'Are you sure you want to OVERRIDE approval of this request?' : approveThis === 'disapproved' ? 'Are you sure you want to OVERRIDE rejection of this request?' : '' "
      @onConfirm="confirm($event)"
    ></Confirmation>
    <!-- End of Table -->

    <!-- Edit Modal -->
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card >
        <v-toolbar class="mb-2" color="blue darken-1" dark flat>
          <v-card-title>
            <span class="headline-bold">UPDATE LEAVE REQUEST</span>
          </v-card-title>
        </v-toolbar>
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
                  label="Duration of Leave*"
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
                <v-text-field
                  label="Start Date"
                  type="datetime-local"
                  v-model="editedItem.start_date"
                  :allowed-dates="disabledDates"
                  @change="changeDate()"
                  color="primary"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <span
                  v-if="error1"
                  class="ml-7"
                  style="color: red; font-size: 13px"
                >Higher the End Date</span>
                <v-text-field
                  label="End Date"
                  type="datetime-local"
                  :allowed-dates="disabledDates2"
                  v-model="editedItem.end_date"
                  @change="changeDate()"
                  color="primary"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red" class="white--text" @click="close">Cancel</v-btn>
          <v-btn color="success" @click="save()">Update</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <Loading v-if="loading"></Loading>

    <!-- Delete Modal -->
    <ConfirmationDel ref="confirmDel" @onConfirm="confirmDel($event)"></ConfirmationDel>

    <v-data-table
      v-if="requests"
      :headers="headers"
      :items="request"
      :search="search"
      class="elevation-3"
      >
      <template v-slot:top>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat>
          <v-toolbar-title
            class="col pa-3 py-4 white--text"
            v-if="!user_type.includes('general mngr')"
          >LEAVE REQUEST</v-toolbar-title>
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
            v-if="(prp_assigned_id === 'No PRP assign' || informationCheck === null) && !user_type.includes('general mngr')"
            color="light blue darken-2"
            rounded
            outlined
            dark
            @click="messagePop()"
          >
            <v-icon v-if="!user_type.includes('general mngr')">mdi-plus</v-icon>
            <v-toolbar-title
              style="font-size: 16px"
              v-if="!user_type.includes('general mngr')"
            >Make Request</v-toolbar-title>
          </v-btn>

          <Reminder
            ref="reminder"
            :message="messageCheck === 'prp' ? 'Please set your Assigned PRP' : messageCheck === 'user' ? 'Please set your personal information' : messageCheck === 'combine' ? 'Please set your PRP assign and your Personal Information' : ''"
            link="/MyAccount"
            routeName="go to MY ACCOUNT"
          ></Reminder>
        </v-toolbar>
      </template>
      <!--Math.round((item.number_of_days / 1000 / 60 / 60 % 24) * 60)  -->
      <!-- item.number_of_days >= 1 ? 
          (item.number_of_days / 1000 / 60 / 60 % 24) != 0 ? 
          Math.floor(item.number_of_days / 1000 / 60 / 60 / 24) + ' ' + 'Day/s' + ' ' + (Math.round(item.number_of_days / 1000 / 60 / 60 % 24) * 60) + ' ' + 'Hour/s' :
          Math.floor(item.number_of_days / 1000 / 60 / 60 / 24) + ' ' + 'Day/s' :
      (item.number_of_days / 1000 / 60 / 60 % 24) *60+ ' ' + 'minute/s'-->
      <template v-slot:item.number_of_days="{ item }">
        {{
        displayTimeLengthInText(item.number_of_days)
        }}
      </template>
      
      <template v-slot:item.user.first_name="{ item }">
        {{
        item.user.first_name + ' ' + item.user.last_name
        }}
      </template>
      <!-- format time -->
      <template v-slot:item.start_date="{ item }">
        {{
        formatDateStandard(item.start_date)
        }}
      </template>
      <template v-slot:item.end_date="{ item }">
        {{
        formatDateStandard(item.end_date)
        }}
      </template>
      <template v-slot:item.status.status_name="{ item }">
        <v-chip
          :color="getColor(item.status.status_name)"
          :text-color="getColor(item.status.status_name) != '#ffa500'? 'white': 'black'"
        >{{item.status.status_name === 'pending' ? 'PENDING' : item.status.status_name === 'approved' ? 'APPROVED' : item.status.status_name === 'disapproved' ? 'DISAPPROVED' : ''}}</v-chip>
      </template>
      <template v-slot:item.approver_role.role_name="{ item }">
        <v-chip
          class="ma-2"
          outlined
          :color="prpColor(item.approver_role.role_name)"
        >{{item.approver_role.role_name === 'prp emp' ? 'PRP' : item.approver_role.role_name === 'finance mngr' ? 'Finance Manager' : item.approver_role.role_name === 'hr mngr' ? 'HR' : item.approver_role.role_name === 'general mngr' ? 'General Manager': '' }}</v-chip>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon
          medium
          disabled
          class="mr-2"
          v-if="((user_type.includes('emp') && user_type.includes('prp emp') && user_type.includes('hr mngr')) && item.status.status_name === 'approved')"
        >mdi-pencil</v-icon>
        <v-icon
          medium
          disabled
          class="mr-2"
          v-else-if="((user_type.includes('emp') && user_type.includes('prp emp') && !(user_type.includes('hr mngr'))) && item.approver_role.role_name === 'general mngr')"
        >mdi-pencil</v-icon>
        <v-icon
          medium
          disabled
          class="mr-2"
          v-else-if="((user_type.includes('emp') && !user_type.includes('prp emp') && !user_type.includes('hr mngr')) && ((item.approver_role.role_name === 'hr mngr') || item.approver_role.role_name === 'general mngr'))"
        >mdi-pencil</v-icon>
        <v-icon medium class="mr-2" @click="editItem(item)" style="color:blue" v-else>mdi-pencil</v-icon>

        <v-icon
          medium
          disabled
          v-if="((user_type.includes('emp') && user_type.includes('prp emp') && user_type.includes('hr mngr')) && item.status.status_name === 'approved')"
        >mdi-delete</v-icon>
        <v-icon
          medium
          disabled
          v-else-if="((user_type.includes('emp') && user_type.includes('prp emp') && !(user_type.includes('hr mngr'))) && item.approver_role.role_name === 'general mngr')"
        >mdi-delete</v-icon>
        <v-icon
          medium
          disabled
          v-else-if="((user_type.includes('emp') && !user_type.includes('prp emp') && !user_type.includes('hr mngr')) && ((item.approver_role.role_name === 'hr mngr') || item.approver_role.role_name === 'general mngr'))"
        >mdi-delete</v-icon>
        <v-icon medium @click="deleteItem(item)" style="color:red" v-else>mdi-delete</v-icon>
      </template>
    </v-data-table>
    <!-- <ConfirmationUp
      ref="confirmUp"
      :title="'Confirmation'"
      :message="'Are you sure you want to update ?'"
      @onConfirm="save($event)"
    ></ConfirmationUp> -->
    <SummaryTemplate ref="summary"></SummaryTemplate>
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
// import ConfirmationUp from "./modals/confirmation/confirmation.vue";
import Confirmation from "./modals/confirmation/confirm.vue";
import ConfirmationDel from "./modals/confirmation/delete.vue";
import Reminder from "./modals/confirmation/reminder.vue";
import SummaryTemplate from "./modals/exports/leave_export.vue";
import Loading from "./Loading.vue";
import {formatDateStandard} from  "../helpers/date_format.js"
export default {
  // "employees = false, requests = true, feedback = false"
  data: () => ({
    user_type: localStorage.getItem("user_type"),
    user_id: localStorage.getItem("id"),
    prp_assigned_id: localStorage.getItem("assigned_prp_id"),
    employees: localStorage.getItem("user_type").includes('general mngr') || localStorage.getItem("user_type").includes('admin') ? true: false,
    requests: localStorage.getItem("user_type").includes('general mngr') || localStorage.getItem("user_type").includes('admin')  ? false: true,
    feedback: localStorage.getItem("user_type").includes('general mngr') || localStorage.getItem("user_type").includes('admin')  ? false: false,
    dialog: false,
    error: false,
    error1: false,
    informationCheck: null,
    error2: false,
    disable: false,
    end_date: null,
    start_date: null,
    loading: false,
    search: "",
    headers: [
      { text: "START DATE", value: "start_date" },
      { text: "END DATE", value: "end_date" },  
      { text: "DURATION OF LEAVE", value: "number_of_days" },
      {
        text: "TYPE OF LEAVE",
        align: "start",
        value: "leave_type.leave_type_name"
      },
      { text: "APPROVER", value: "approver_role.role_name" },
      { text: "STATUS", value: "status.status_name" },
      { text: "ACTIONS", value: "actions", sortable: false }
    ],
    headersEmp: [
      { text: "START DATE", value: "start_date" },
      { text: "END DATE", value: "end_date" },
      { text: "DURATION OF LEAVE", value: "number_of_days" },
      { text: "REQUESTER", align: "start", value: "user.first_name" },
      { text: "TYPE OF LEAVE", value: "leave_type.leave_type_name" },
      { text: "APPROVER", value: "approver_role.role_name" },
      { text: "STATUS", value: "status.status_name" },
      { text: "ACTIONS", value: "actions", sortable: false }
    ],
    headersFeed: [
      { text: "START DATE", value: "start_date" },
      { text: "END DATE", value: "end_date" },
      { text: "DURATION OF LEAVE", value: "number_of_days" },
      { text: "REQUESTER", align: "start", value: "user.first_name" },
      { text: "TYPE OF LEAVE", value: "leave_type.leave_type_name" },
      { text: "APPROVER", value: "approver_role.role_name" },
      { text: "STATUS", value: "status.status_name" },
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
    items: [{ title: "Approved Requests" }, { title: "Disapproved Requests" }],
    dates: [new Date().toISOString().substr(0, 10)],
    leaveType: [
      { value: 1, name: "Sick Leave" },
      { value: 2, name: "Solo Parent Leave" },
      { value: 3, name: "Vacation Leave" },
      { value: 4, name: "Emergency Leave" },
      { value: 5, name: "Paternity Leave" },
      { value: 6, name: "Maternity Leave" }
    ],
    approveThis: "",
    messageCheck: ""
  }),
  components: {
    createLeave,
    Confirmation,
    // ConfirmationUp,
    ConfirmationDel,
    SummaryTemplate,
    Reminder,
    Loading
  },
  computed: {
    dateRangeText() {
      return this.dates.join(" ~ ");
    }
  },
  mounted() {
    if (this.$store.getters.roleList.includes("general mngr")
      ) {
      this.retrievePendingPrp();
      this.retrieve();
      this.getAllFeedback();
      this.checkUser();
    } else if ((this.user_type.includes("hr mngr") ||
        this.user_type.includes("prp emp")) &&
      !this.user_type.includes("finance mngr")) {
      this.retrievePendingPrp();
      this.retrieve();
      this.getAllFeedback();
      this.checkUser();
    } else {
      this.retrieve();
      this.checkUser();
    }
    console.log(this.requests, this.employees, this.feedback)
  },
  methods: {
    // confirm(){
    //   if(this.editedItem.start_date !== null && this.editedItem.start_date !== "" && this.editedItem.end_date !== null && this.editedItem.end_date !== "" && this.editedItem.selectedLeaveType !== null && this.editedItem.selectedLeaveType !== "" && this.editedItem.total_days !== null && this.editedItem.total_days !== ""){
    //     this.$refs.confirmUp.show()
    //   }else {
    //     this.error = true
    //     this.dialog = true
    //   }
    // },
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
          // this.total_days = differenceInDay
          // console.log(this.total_days)
          // this.total_days_with_text = differenceInDay.toFixed(2) < 0.5 ? ((differenceInDay.toFixed(2))*24) + " hours of leave" : differenceInDay.toFixed(1) + "days of leave";
          // this.total_days_with_text = differenceInDay.toFixed(2) < 0.5 ? ((differenceInDay.toFixed(2))*24) + " hours of leave" : differenceInDay.toFixed(1) + "days of leave";
          this.total_days_with_text = this.displayTimeLengthInText(
            differenceInDay
          );
          // this.total_days_with_text = differenceInDay.toFixed(2) < 0.5 ? ((differenceInDay.toFixed(2))*24) + " hours of leave" : differenceInDay.toFixed(1) + "days of leave";
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
      this.loading = true;
      this.$axios
        .get("leave_request/" + this.user_id)
        .then(response => {
          this.request = response.data;
          this.loading = false;
        })
        .catch(e => {
          console.log(e);
        });
    },
    retrievePendingPrp() {
      if(this.user_type.includes('admin')) {
        console.log('nig');
        this.$axios
        .get("admin/leave_request/pending")
        .then(response => {
          this.prpPending = response.data;
        })
        .catch(e => {
          console.log(e);
        });
      }else {
        this.$axios
        .get("prp/leave_request/pending/" + this.user_id)
        .then(response => {
          this.prpPending = response.data;
        })
        .catch(e => {
          console.log(e);
        });
      }
    },
    editItem(item) {
      console.log('item', item)
      this.editedItem.id = item.id
      this.editedIndex = this.request.indexOf(item);
      this.editedItem.selectedLeaveType = item.leave_type_id;
      this.editedItem.total_days = item.number_of_days;
      this.total_days_with_text = this.displayTimeLengthInText(
        item.number_of_days
      );
      this.editedItem.start_date = moment(item.start_date).format('YYYY-MM-DDTHH:mm')
      this.editedItem.end_date = moment(item.end_date).format('YYYY-MM-DDTHH:mm')
      this.dialog = true;
    },
    convert(datetime) {
      // Check correct time format and split into components
      var time = datetime[1]
        .toString()
        .match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [datetime];
      if (time.length > 1) {
        // If time format correct
        time = time.slice(1); // Remove full string match value
        time[5] = +time[0] < 12 ? " AM" : " PM"; // Set AM/PM
        time[0] = +time[0] % 12 || 12; // Adjust hours
      }
      datetime[1] = time.join("");
      return datetime.join(" "); // return adjusted time or original string
    },
    displayTimeLengthInText(num) {
      var item = {
        number_of_days: num
      };
      return item.number_of_days >= 1
        ? // true
          Math.floor(item.number_of_days) == item.number_of_days
          ? Math.floor(item.number_of_days) > 1
            ? // true
              Math.floor(item.number_of_days) + " " + "days"
            : Math.floor(item.number_of_days) + " " + "day"
          : // false
          Math.floor(item.number_of_days) > 1
          ? Math.round(
              item.number_of_days * 24 - Math.trunc(item.number_of_days * 24)
            ) >= 1
            ? Math.round(
                item.number_of_days * 24 - Math.trunc(item.number_of_days * 24)
              ) > 1
              ? Math.round(
                  (item.number_of_days * 24 -
                    Math.trunc(item.number_of_days * 24)) *
                    60
                ) > 1
                ? // hours and minute/s
                  Math.floor(item.number_of_days) +
                  " " +
                  "days" +
                  " " +
                  Math.round(
                    item.number_of_days * 24 -
                      Math.trunc(item.number_of_days * 24)
                  ) +
                  " hours and " +
                  Math.round(
                    (item.number_of_days * 24 -
                      Math.trunc(item.number_of_days * 24)) *
                      60
                  ) +
                  " " +
                  "mins"
                : Math.floor(item.number_of_days) +
                  " " +
                  "days" +
                  " " +
                  Math.round(
                    item.number_of_days * 24 -
                      Math.trunc(item.number_of_days * 24)
                  ) +
                  " hours and " +
                  Math.round(
                    (item.number_of_days * 24 -
                      Math.trunc(item.number_of_days * 24)) *
                      60
                  ) +
                  " " +
                  "min"
              : // hour and minute/s
              Math.round(
                  (item.number_of_days * 24 -
                    Math.trunc(item.number_of_days * 24)) *
                    60
                ) > 1
              ? Math.floor(item.number_of_days) +
                " " +
                "days" +
                " " +
                Math.round(
                  item.number_of_days * 24 -
                    Math.trunc(item.number_of_days * 24)
                ) +
                " hour and " +
                Math.round(
                  (item.number_of_days * 24 -
                    Math.trunc(item.number_of_days * 24)) *
                    60
                ) +
                " " +
                "mins"
              : Math.floor(item.number_of_days) +
                " " +
                "days" +
                " " +
                Math.round(
                  item.number_of_days * 24 -
                    Math.trunc(item.number_of_days * 24)
                ) +
                " hour and " +
                Math.round(
                  (item.number_of_days * 24 -
                    Math.trunc(item.number_of_days * 24)) *
                    60
                ) +
                " " +
                "min"
            : // minutes
            Math.round(
                (item.number_of_days * 24 -
                  Math.trunc(item.number_of_days * 24)) *
                  60
              ) > 1
            ? Math.floor(item.number_of_days) +
              " " +
              "days" +
              " and " +
              Math.round(
                (item.number_of_days * 24 -
                  Math.trunc(item.number_of_days * 24)) *
                  60
              ) +
              " " +
              "mins"
            : Math.floor(item.number_of_days) +
              " " +
              "days" +
              " and " +
              Math.round(
                (item.number_of_days * 24 -
                  Math.trunc(item.number_of_days * 24)) *
                  60
              ) +
              " " +
              "min"
          : Math.round(
              item.number_of_days * 24 - Math.trunc(item.number_of_days * 24)
            ) >= 1
          ? Math.round(
              item.number_of_days * 24 - Math.trunc(item.number_of_days * 24)
            ) > 1
            ? Math.round(
                (item.number_of_days * 24 -
                  Math.trunc(item.number_of_days * 24)) *
                  60
              ) > 1
              ? // hours and minute/s
                Math.floor(item.number_of_days) +
                " " +
                "day" +
                " " +
                Math.round(
                  item.number_of_days * 24 -
                    Math.trunc(item.number_of_days * 24)
                ) +
                " hours and " +
                Math.round(
                  (item.number_of_days * 24 -
                    Math.trunc(item.number_of_days * 24)) *
                    60
                ) +
                " " +
                "mins"
              : Math.floor(item.number_of_days) +
                " " +
                "day" +
                " " +
                Math.round(
                  item.number_of_days * 24 -
                    Math.trunc(item.number_of_days * 24)
                ) +
                " hours and " +
                Math.round(
                  (item.number_of_days * 24 -
                    Math.trunc(item.number_of_days * 24)) *
                    60
                ) +
                " " +
                "min"
            : // hour and minute/s
            Math.round(
                (item.number_of_days * 24 -
                  Math.trunc(item.number_of_days * 24)) *
                  60
              ) > 1
            ? Math.floor(item.number_of_days) +
              " " +
              "day" +
              " " +
              Math.round(
                item.number_of_days * 24 - Math.trunc(item.number_of_days * 24)
              ) +
              " hour and " +
              Math.round(
                (item.number_of_days * 24 -
                  Math.trunc(item.number_of_days * 24)) *
                  60
              ) +
              " " +
              "mins"
            : Math.floor(item.number_of_days) +
              " " +
              "day" +
              " " +
              Math.round(
                item.number_of_days * 24 - Math.trunc(item.number_of_days * 24)
              ) +
              " hour and " +
              Math.round(
                (item.number_of_days * 24 -
                  Math.trunc(item.number_of_days * 24)) *
                  60
              ) +
              " " +
              "min"
          : // minutes
          Math.round(
              (item.number_of_days * 24 -
                Math.trunc(item.number_of_days * 24)) *
                60
            ) > 1
          ? Math.floor(item.number_of_days) +
            " " +
            "day" +
            " and " +
            Math.round(
              (item.number_of_days * 24 -
                Math.trunc(item.number_of_days * 24)) *
                60
            ) +
            " " +
            "mins"
          : Math.floor(item.number_of_days) +
            " " +
            "day" +
            " and " +
            Math.round(
              (item.number_of_days * 24 -
                Math.trunc(item.number_of_days * 24)) *
                60
            ) +
            " " +
            "min"
        : // false
        Math.round(item.number_of_days * 24) >= 1
        ? Math.round(item.number_of_days * 24) > 1
          ? Math.round(
              (item.number_of_days * 24 -
                Math.trunc(item.number_of_days * 24)) *
                60
            ) > 1
            ? // hours and minute/s
              Math.round(item.number_of_days * 24) +
              " hours and " +
              Math.round(
                (item.number_of_days * 24 -
                  Math.trunc(item.number_of_days * 24)) *
                  60
              ) +
              " " +
              "mins"
            : Math.round(item.number_of_days * 24) +
              " hours and " +
              Math.round(
                (item.number_of_days * 24 -
                  Math.trunc(item.number_of_days * 24)) *
                  60
              ) +
              " " +
              "min"
          : // hour and minute/s
          Math.round(
              (item.number_of_days * 24 -
                Math.trunc(item.number_of_days * 24)) *
                60
            ) > 1
          ? Math.round(item.number_of_days * 24) +
            " hour and " +
            Math.round(
              (item.number_of_days * 24 -
                Math.trunc(item.number_of_days * 24)) *
                60
            ) +
            " " +
            "mins"
          : Math.round(item.number_of_days * 24) +
            " hour and " +
            Math.round(
              (item.number_of_days * 24 -
                Math.trunc(item.number_of_days * 24)) *
                60
            ) +
            " " +
            "min"
        : // minutes
        Math.round(item.number_of_days * 24 * 60) > 1
        ? Math.round(item.number_of_days * 24 * 60) + " " + "mins"
        : Math.round(item.number_of_days * 24 * 60) + " " + "min";
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
          .post("leave_request/" + this.editedItem.id, params)
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
      this.$refs.confirmDel.show(item);
    },
    confirmDel() {
      this.$axios.delete("leave_request/" + this.id).then(response => {
        this.retrieve();
      });
    },
    close() {
      this.dialog = false;
    },
    getColor(status) {
      if (status === "pending") return "#ffa500";
      else if (status === "disapproved") return "red";
      else return "green";
    },
    prpColor(approver_role) {
      if (approver_role === "prp emp") return "#0047ab";
      else if (approver_role === "hr mngr") return "blue";
      else if (approver_role === "finance mngr") return "#00004d";
      else if (approver_role === "emp") return "0f52ba";
      else return "#002366";
    },
    approveModal(item) {
      this.approveThis = "approve";
      this.id = item.id;
      this.$refs.confirms.show(item);
    },
    checkUser() {
      this.$axios.get("user_info/" + this.user_id).then(response => {
        if (response.data.user_information === null) {
          this.informationCheck = null;
        } else {
          this.informationCheck = true;
        }
      });
    },
    messagePop() {
      if (
        this.prp_assigned_id === "No PRP assign" &&
        this.informationCheck === null
      ) {
        this.messageCheck = "combine";
        this.$refs.reminder.show();
      } else if (this.informationCheck === null) {
        this.messageCheck = "user";
        this.$refs.reminder.show();
      } else {
        this.messageCheck = "prp";
        this.$refs.reminder.show();
      }
    },
    confirm(item) {
      if (this.approveThis === "approve") {
        this.approve(item);
      } else {
        this.disapprove();
      }
    },
    disapproveModal(item) {
      this.approveThis = "disapproved";
      this.id = item.id;
      this.$refs.confirms.show(item);
    },
    approve(item) {
      let parameter = {};
      if (item.id.approver_role_id === 5) {
        parameter = {
          user_id: this.user_id,
          status_id: 2
        };
      } else {
        parameter = {
          user_id: this.user_id,
          status_id: 1
        };
      }
      if(this.user_type.includes('admin')) {
        this.$axios
          .post("admin/leave_request/feedback/" + this.id, parameter)
          .then(response => {
            this.retrievePendingPrp();
            this.getAllFeedback();
          });
      }else {
        this.$axios
          .post("prp/leave_request/feedback/" + this.id, parameter)
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
        .post("prp/leave_request/feedback/" + this.id, parameter)
        .then(res => {
          this.retrievePendingPrp();
          this.getAllFeedback();
        });
    },
    getAllFeedback() {
      if(!this.user_type.includes('admin')) {
        this.$axios
          .get("prp/leave_request/feedbacked/" + this.user_id)
          .then(response => {
            this.feedbacks = response.data.feedbacked_leave_requests;
          });
      }else {
        this.$axios
          .get("admin/leave_request")
          .then(response => {
            this.feedbacks = response.data;
          });
      }
      
    },
    summary(item) {
      this.$refs.summary.show(this.dates[0], this.dates[1], item);
    },
    formatDateStandard
  }
};
</script>