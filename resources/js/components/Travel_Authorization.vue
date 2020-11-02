<template>
  <div>
    <v-toolbar flat>
      <template v-slot:extension>
        <v-tabs
          dark
          background-color="primary"
          fixed-tabs
          v-if="user_type.includes('hr mngr') || user_type.includes('prp emp') || user_type.includes('general mngr')">
          <v-tabs-slider></v-tabs-slider>
          <v-tab @click="employees = false, requests = true, feedback = false">My Requests</v-tab>
          <v-tab @click="requests = false, employees = true, feedback = false">Employees Requests</v-tab>
          <v-tab @click="requests = false, employees = false, feedback = true">Feedback</v-tab>
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
          <v-btn depressed color="primary">SUMMARY</v-btn>
          <v-divider class="mx-4" vertical></v-divider>
          <v-spacer></v-spacer>
          <v-text-field v-model="search" label="Search" single-line hide-details class="mx-5"></v-text-field>
        </v-toolbar>
      </template>
      <template v-slot:item.approver_role.role_name="{ item }">
        <v-chip
        class="ma-2"
        outlined
        :color="prpColor(item.approver_role.role_name)">{{item.approver_role.role_name}}</v-chip>
      </template>
      <template v-slot:item.status.status_name="{ item }">
        <v-chip :color="getColor(item.status.status_name)">{{item.status.status_name}}</v-chip>
      </template>
    </v-data-table>

    <!-- Pending Requests -->
    <v-data-table v-if="employees" :headers="headersEmp" :items="travelPending" class="elevation-3">
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
          </v-col>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <v-btn depressed color="primary">SUMMARY</v-btn>
          <v-divider class="mx-4" vertical></v-divider>
          <v-spacer></v-spacer>
          <v-text-field v-model="search" label="Search" single-line hide-details class="mx-5"></v-text-field>
        </v-toolbar>
      </template>
      <template v-slot:item.approver_role.role_name="{ item }">
        <v-chip 
        class="ma-2"
        outlined
        :color="prpColor(item.approver_role.role_name)">{{item.approver_role.role_name}}</v-chip>
      </template>
      <template v-slot:item.status.status_name="{ item }">
        <v-chip :color="getColor(item.status.status_name)">{{item.status.status_name}}</v-chip>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon small class="mr-2" @click="approveModal(item)">mdi-check-decagram</v-icon>
        <v-icon small @click="disapproveModal(item)">mdi-close-circle</v-icon>
      </template>
    </v-data-table>

    <Confirmation
      ref="confirms"
      :title="'Confirmation'"
      :message="approveThis === 'approve' ? 'Are you sure you want to approve this request?' : 'Are you sure you want to reject this request?'"
      @onConfirm="confirm($event)"
    ></Confirmation>

    <!-- ****************start************** -->
    <v-dialog v-model="dialog" max-width="500px">
      <v-card>
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
                <v-text-field
                  v-model="editedItem.employee_to_cover"
                  label="Employee to Cover"
                  prepend-icon=" mdi-account-outline"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">Cancel</v-btn>
          <v-btn color="blue darken-1" text @click="save">Save</v-btn>
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
      v-if="requests && (!user_type.includes('hr mngr') || !user_type.includes('prp mngr') || !user_type.includes('prp emp'))"
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
          <createTravel></createTravel>
        </v-toolbar>
      </template>

      <template v-slot:item.file_uri="{ item }">
        <v-btn color="primary" @click="fileDialog = true; file_uri = item.file_uri">File</v-btn>
      </template>

      <template v-slot:item.actions="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
        <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
      </template>
    </v-data-table>
  </div>
</template>

<script>
import createTravel from "./modals/create_travel.vue";
import moment from "moment";
import Confirmation from "./modals/confirmation/confirm.vue";
import ConfirmationDel from "./modals/confirmation/delete.vue";
export default {
  data: () => ({
    file_uri: "",
    user_type: localStorage.getItem("user_type"),
    user_id: localStorage.getItem("id"),
    employees: !localStorage.getItem("user_type").includes("finance mngr") ? false : true,
    requests: !localStorage.getItem("user_type").includes("finance mngr") ? true : false,
    feedback: !localStorage.getItem("user_type").includes("finance mngr") ? false : true,
    dialog: false,
    error: false,
    error1: false,
    fileDialog: false,
    files: "",
    uploadPercentage: 0,
    disable: false,
    end_date: null,
    error2: false,
    search: "",
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
    ConfirmationDel
  },
  computed: {
    dateRangeText () {
      return this.dates.join(' ~ ')
    },
  },
  mounted() {
    if (
      this.user_type.includes("hr mngr") ||
      this.user_type.includes("prp emp") ||
      this.user_type.includes("general mngr")
    ) {
      this.retrieveTravel();
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
        this.disable = false;
      } else {
        this.disable = true;
      }
    },
    getAllPrp() {
      this.$axios.get("http://localhost:8000/prp").then(response => {
        this.prp = response.data;
      });
    },
    retrieve() {
      this.$axios
        .get("http://localhost:8000/travel_auth_request/" + this.user_id)
        .then(response => {
          this.travel = response.data;
        })
        .catch(e => {
          console.log(e);
        });
    },
    retrieveTravel() {
      this.$axios
        .get(
          "http://localhost:8000/prp/travel_auth_request/pending/" +
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
    // remove(index) {
    //   this.files.splice(index, 1);
    // },
    // handleFilesUpload() {
    //   this.file = this.$refs.file.files[0];
    // },
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
            "http://localhost:8000/travel_auth_request/" + this.editedItem.id,
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
        .delete("http://localhost:8000/travel_auth_request/" + this.id)
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
          "http://localhost:8000/prp/travel_auth_request/feedback/" + this.id,
          parameter
        )
        .then(response => {
            console.log(response.data)
          this.retrieveTravel();
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
          "http://localhost:8000/prp/travel_auth_request/feedback/" + this.id,
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
          "http://localhost:8000/prp/travel_auth_request/feedbacked/" +
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
    }
  }
};
</script>