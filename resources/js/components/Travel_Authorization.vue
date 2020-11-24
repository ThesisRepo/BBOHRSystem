<template>
  <div>
    <v-toolbar flat>
      <template v-slot:extension>
        <v-tabs
          dark
          background-color="primary"
          fixed-tabs
          v-if="(user_type.includes('hr mngr') || user_type.includes('prp emp') || user_type.includes('general mngr'))">
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
    <v-data-table v-if="employees" :headers="headersEmp" :items="travelPending" :search="search" class="elevation-3">
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
      :message="approveThis === 'approve' ? 'Are you sure you want to approve this request?' : 'Are you sure you want to reject this request?'"
      @onConfirm="confirm($event)"
    ></Confirmation>

    <!-- ****************start************** -->
    <v-dialog v-model="dialog" max-width="500px">
      <v-card>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat>
          <v-card-title>
            <span class="headline-bold">TRAVEL AUTHORIZATION REQUEST</span>
          </v-card-title>
        </v-toolbar>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" md="6">
                <v-text-field
                  v-model="editedItem.destination"
                  label="Destination"
                  prepend-icon=" mdi-home-modern"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field
                  v-model="editedItem.emergency_contact"
                  label="Emergency Contact"
                  prepend-icon="mdi-account-outline"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <span v-if="error2" style="color: red; font-style: italic">
                  Start date must not be higher than End
                  date!
                </span>
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
                      readonly
                      v-bind="attrs"
                      v-on="on"
                      prepend-icon=" mdi-calendar"
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
                <span v-if="error1" style="color: red; font-style: italic">
                  End date must be higher than start
                  date!
                </span>
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
                      readonly
                      v-bind="attrs"
                      v-on="on"
                      :disabled="disable"
                      prepend-icon=" mdi-calendar"
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
              <v-col cols="12">
                <v-select
                  :items="coDepartment"
                  :item-text="coDepartment => coDepartment.first_name + ' ' + coDepartment.last_name"
                  item-value="id"
                  label="Employee to Cover*"
                  v-model="editedItem.employee_to_cover"
                  prepend-icon=" mdi-account-outline"
                  required
                ></v-select>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red" class="white--text" @click="dialog = false">Cancel</v-btn>
          <v-btn color="success" @click="save">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- ************Delete Modal*************** -->
    <ConfirmationDel
      ref="confirmDel"
      @onConfirm="confirmDel($event)"
    ></ConfirmationDel>

    <v-dialog v-model="fileDialog" width="700px">
      <v-card>
        <v-card-title>
          <span class="headline">Attached File</span>
        </v-card-title>
        <v-divider></v-divider>
        <v-card class="mx-auto" max-width="344">
          <v-img :src="file_uri" width="500"></v-img>
        </v-card>
        <br>
      </v-card>
    </v-dialog>

    <v-data-table
      v-if="requests"
      :headers="headers"
      :items="travel"
      :search="search"
      class="elevation-3"
    >
      <template v-slot:top>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat>
          <v-toolbar-title class="col pa-3 py-4 white--text" style="font-size: 16px">TRAVEL REQUEST</v-toolbar-title>
          <v-text-field
            v-model="search"
            clearable
            flat
            solo-inverted
            hide-details
            prepend-inner-icon="mdi-magnify"
            label="Search"
          ></v-text-field>
          <createTravel v-if="prp_assigned_id !== 'No PRP assign' && informationCheck !== null"></createTravel>
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

      <template v-slot:item.file_uri="{ item }">
        <v-btn color="primary" @click="fileDialog = true; file_uri = item.file_uri">File</v-btn>
      </template>
      
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
  </div>
</template>

<script>
import createTravel from "./modals/create_travel.vue";
import moment from "moment";
import Confirmation from "./modals/confirmation/confirm.vue";
import ConfirmationDel from "./modals/confirmation/delete.vue";
import Reminder from "./modals/confirmation/reminder.vue";
import SummaryTemplate from "./modals/exports/travel_export.vue";
export default {
  data: () => ({
    file_uri: "",
    user_type: localStorage.getItem("user_type"),
    user_id: localStorage.getItem("id"),
    prp_assigned_id: localStorage.getItem("assigned_prp_id"),
    employees: false,
    requests: true,
    feedback: false,
    dialog: false,
    error: false,
    error1: false,
    fileDialog: false,
    files: "",
    uploadPercentage: 0,
    disable: false,
    end_date: null,
    error2: false,
    search: '',
    messageCheck: '',
    informationCheck: null,
    deleteModal: false,
    dialogDelete: false,
    headers: [
      { text: "DESTINATION", align: "start", sortable: false, value: "destination" },
      { text: "START DATE", value: "start_date" },
      { text: "END DATE", value: "end_date" },
      { text: "EMERGENCY CONTACT", value: "emergency_contact" },
      { text: "EMPLOYEE TO COVER", value: "employee_to_cover" },
      { text: "DOCUMENTS", value: "file_uri", sortable: false },
      { text: "APPROVER", value: "approver_role.role_name" },
      { text: "STATUS", value: "status.status_name" },
      { text: "ACTIONS", value: "actions", sortable: false }
    ],
    headersEmp: [
      { text: "REQUESTER", align: "start", value: "user.first_name" },
      { text: "DESTINATION", value: "destination" },
      { text: "START DATE", value: "start_date" },
      { text: "END DATE", value: "end_date" },
      { text: "EMERGENCY CONTACT", value: "emergency_contact" },
      { text: "EMPLOYEE TO COVER", value: "employee_to_cover" },
      { text: "DOCUMENTS", value: "file_uri", sortable: false },
      { text: "APPROVER", value: "approver_role.role_name" },
      { text: "STATUS", value: "status.status_name" },
      { text: "ACTIONS", value: "actions", sortable: false }
    ],
    headersFeed: [
      { text: "REQUESTER", align: "start", value: "user.first_name" },
      { text: "DESTINATION", value: "destination" },
      { text: "START DATE", value: "start_date" },
      { text: "END DATE", value: "end_date" },
      { text: "EMERGENCY CONTACT", value: "emergency_contact" },
      { text: "EMPLOYEE TO COVER", value: "employee_to_cover" },
      { text: "DOCUMENTS", value: "file_uri", sortable: false },
      { text: "APPROVER", value: "approver_role.role_name" },
      { text: "STATUS", value: "status.status_name" }
    ],
    travel: [],
    travelPending: [],
    feedbacks: [],
    coDepartment: [],
    items: [
      { title: 'Approved Requests' },
      { title: 'Disapproved Requests' }
    ],
    id: null,
    editedIndex: null,
    editedItem: {
      destination: null,
      substitute: null,
      start_date: null,
      end_date: null,
      emergency_contact: null,
      employee_cover: null,
      prp_assigned_id: null,
      details: null
    },
    dates: [new Date().toISOString().substr(0, 10), ],
    approveThis: '',
    user_id: localStorage.getItem("id")
  }),
  components: {
    createTravel,
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
      this.retrieveTravel();
      this.retrieve();
      this.getAllFeedback();
      this.getCoDepartment()
      this.checkUser()
    } else {
      this.retrieve();
      this.getCoDepartment()
      this.checkUser()
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
        this.disable = false;
      } else {
        this.disable = true;
      }
    },
    getAllPrp() {
      this.$axios.get("prp").then(response => {
        this.prp = response.data;
      });
    },
    getCoDepartment(){
      this.$axios.get("departments/employees").then (response => {
        response.data.forEach(element => {
          this.coDepartment.push(element)
        })
      })
    },
    retrieve() {
      this.$axios
        .get("travel_auth_request/" + this.user_id)
        .then(response => {
          this.travel = response.data;
          console.log('here', this.travel)
        })
        .catch(e => {
          console.log(e);
        });
    },
    checkUser(){
      this.$axios
        .get("user_info/" + this.user_id)
        .then(response => {
          console.log('hahah', response.data)
          if(response.data.user_information === null){
            this.informationCheck = null
          }else{
            this.informationCheck = true
          }
        })
    },
    messagePop(){
      console.log(this.prp_assigned_id, this.informationCheck)
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
    retrieveTravel() {
      this.$axios
        .get(
          "prp/travel_auth_request/pending/" +
            this.user_id
        )
        .then(response => {
          this.travelPending = response.data;
        })
        .catch(e => {
          console.log(e);
        });
    },
    editItem(item) {
      this.editedItem.id = item.id;
      this.editedIndex = this.travel.indexOf(item);
      this.editedItem.destination = item.destination;
      this.editedItem.start_date = item.start_date;
      this.editedItem.end_date = item.end_date;
      this.editedItem.emergency_contact = item.emergency_contact;
      // this.editedItem.file_uri = item.file_uri;
      this.editedItem.employee_to_cover = item.employee_to_cover;
      this.dialog = true;
    },
    save() {
      if (
        this.editedItem.destination !== null &&
        this.editedItem.start_date !== null &&
        this.editedItem.end_date !== null &&
        this.editedItem.emergency_contact !== null &&
        this.editedItem.employee_to_cover !== null &&
        this.editedItem.emergency_contact !== "" &&
        this.editedItem.employee_to_cover !== "" &&
        this.editedItem.start_date !== "" &&
        this.editedItem.end_date !== "" &&
        this.error2 === false
      ) {
        let params = {
          destination: this.editedItem.destination,
          start_date: this.editedItem.start_date,
          end_date: this.editedItem.end_date,
          emergency_contact: this.editedItem.emergency_contact,
          employee_to_cover: this.editedItem.employee_to_cover,
          file_uri: "test"
        };
        // console.log("params", params, this.editedItem.id);
        this.$axios
          .post(
            "travel_auth_request/" + this.editedItem.id,
            params
          )
          .then(response => {
            console.log(response.data)
            this.retrieve();
          });
        this.dialog = false;
      } else {
        this.error = true;
      }
    },
    deleteItem(item) {
      this.id = item.id;
      this.$refs.confirmDel.show(item)
    },

    confirmDel() {
      this.$axios
        .delete("travel_auth_request/" + this.id)
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
      if(item.id.approver_role_id === 5){
        let parameter = {
          user_id: this.user_id,
          status_id: 2
        };
        this.$axios
          .post(
            "prp/travel_auth_request/feedback/" + this.id,
            parameter
          )
          .then(response => {
            this.retrieveTravel();
            this.getAllFeedback();
          });
      }else{
        let parameter = {
          user_id: this.user_id,
          status_id: 1
        };
        this.$axios
          .post(
            "prp/travel_auth_request/feedback/" + this.id,
            parameter
          )
          .then(response => {
            this.retrieveTravel();
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
          "prp/travel_auth_request/feedback/" + this.id,
          parameter
        )
        .then(res => {
          this.retrieveTravel();
          this.getAllFeedback();
        });
    },
    getAllFeedback() {
      this.$axios
        .get(
          "prp/travel_auth_request/feedbacked/" +
            this.user_id
        )
        .then(response => {
          this.feedbacks = response.data.feedbacked_travel_auth_requests;
        });
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
    summary(item){
      console.log(this.dates[0], this.dates[1])
      this.$refs.summary.show(this.dates[0], this.dates[1], item)
    }
  }
};
</script>