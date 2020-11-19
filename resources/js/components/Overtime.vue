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
      <template v-slot:item.status.status_name="{ item }"> <v-chip :color="getColor(item.status.status_name)" :text-color="getColor(item.status.status_name) != '#ffa500'? 'white': 'black'">{{item.status.status_name === 'pending' ? 'PENDING' : item.status.status_name === 'approve' ? 'APPROVE' : item.status.status_name === 'disapproved' ? 'DISAPPROVED' : ''}}</v-chip> </template>
      <template v-slot:item.approver_role.role_name="{ item }"> <v-chip class="ma-2" outlined :color="prpColor(item.approver_role.role_name)">{{item.approver_role.role_name === 'prp emp' ? 'PRP' : item.approver_role.role_name === 'finance mngr' ? 'Finance Manager' : item.approver_role.role_name === 'hr mngr' ? 'HR' : item.approver_role.role_name === 'general mngr' ? 'General Manager': '' }}</v-chip> </template>
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
      <template v-slot:item.status.status_name="{ item }"> <v-chip :color="getColor(item.status.status_name)" :text-color="getColor(item.status.status_name) != '#ffa500'? 'white': 'black'">{{item.status.status_name === 'pending' ? 'PENDING' : item.status.status_name === 'approve' ? 'APPROVE' : item.status.status_name === 'disapproved' ? 'DISAPPROVED' : ''}}</v-chip> </template>
      <template v-slot:item.approver_role.role_name="{ item }"> <v-chip class="ma-2" outlined :color="prpColor(item.approver_role.role_name)">{{item.approver_role.role_name === 'prp emp' ? 'PRP' : item.approver_role.role_name === 'finance mngr' ? 'Finance Manager' : item.approver_role.role_name === 'hr mngr' ? 'HR' : item.approver_role.role_name === 'general mngr' ? 'General Manager': '' }}</v-chip> </template>
      <template v-slot:item.actions="{ item }">
        <v-icon small class="mr-2" @click="approveModal(item)">mdi-check-decagram</v-icon>
        <v-icon small @click="disapproveModal(item)">mdi-close-circle</v-icon>
      </template>
    </v-data-table>

    <Confirmation
      ref="confirms"
      :title="approveThis === 'approve' || 'disapproved' ? 'Confirmation' : ''"
      :message="approveThis === 'approve' ? 'Are you sure you want to approve this request?' : 'Are you sure you want to reject this request?'"
      @onConfirm="confirm($event)"
    ></Confirmation>

    <!-- EditModal -->
      <v-dialog v-model="dialog" max-width="500px">
        <v-card>
         <v-toolbar class="mb-2" color="blue darken-1" dark flat>
            <v-card-title>   
              <span class="headline-bold">OVERTIME REQUEST FORM</span>
            </v-card-title>
          </v-toolbar>
          <v-divider></v-divider>
          <v-card-text>
            <v-container>
            <span v-if="error" style="color: red; font-style: italic">All data are required!</span>
              <v-row>
                <v-col cols="12" sm="6" md="6">
                  <v-text-field
                    v-model="editedItem.reason"
                    label="Reason"
                    prepend-icon="mdi-file-document"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
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
                    prepend-icon="mdi-timer"
                    label="Start Time"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  <v-text-field
                    v-model="editedItem.end_time"
                    type="time"
                     prepend-icon="mdi-timer"
                    label="End Time"
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="red" class="white--text" @click="close"> Cancel </v-btn>
            <v-btn color="success" @click="save"> Save </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

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
      <v-toolbar class="mb-2" color="blue darken-1" dark flat>
        <v-toolbar-title class="col pa-3 py-4 white--text"  style="font-size:16px "
          >OVERTIME REQUEST</v-toolbar-title
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

        <createOvertime
        v-if="prp_assigned_id !== 'No Prp assign'"
        ></createOvertime>

        <v-btn
          style="margin-left: 5%"
          v-if="prp_assigned_id === 'No Prp assign'"
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
          :message="'Please set your PRP Assign'"
          ></Reminder>

      </v-toolbar>
    </template>
      <template v-slot:item.status.status_name="{ item }"> <v-chip :color="getColor(item.status.status_name)" :text-color="getColor(item.status.status_name) != '#ffa500'? 'white': 'black'">{{item.status.status_name === 'pending' ? 'PENDING' : item.status.status_name === 'approve' ? 'APPROVE' : item.status.status_name === 'disapproved' ? 'DISAPPROVED' : ''}}</v-chip> </template>
      <template v-slot:item.approver_role.role_name="{ item }"> <v-chip class="ma-2" outlined :color="prpColor(item.approver_role.role_name)">{{item.approver_role.role_name === 'prp emp' ? 'PRP' : item.approver_role.role_name === 'finance mngr' ? 'Finance Manager' : item.approver_role.role_name === 'hr mngr' ? 'HR' : item.approver_role.role_name === 'general mngr' ? 'General Manager': '' }}</v-chip> </template>
      <template v-slot:item.actions="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
        <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
      </template>
    </v-data-table>
    <SummaryTemplate
    ref="summary"
    ></SummaryTemplate>
  </div>
</template>
<script>
import createOvertime from "./modals/create_overtime.vue";
import Confirmation from "./modals/confirmation/confirm.vue";
import ConfirmationDel from "./modals/confirmation/delete.vue";
import SummaryTemplate from "./modals/exports/overtime_export.vue";
import Reminder from "./modals/confirmation/reminder.vue";
export default {
  data: () => ({
    user_type: localStorage.getItem("user_type"),
    user_id: localStorage.getItem("id"),
    prp_assigned_id: localStorage.getItem("assigned_prp_id"),
    employees: false,
    requests: true,
    feedback: false,
    dialog: false,
    error: false,
    overtime_date: null,
    search: '',
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
    Reminder
  },
  computed: {
    dateRangeText () {
      return this.dates.join(' ~ ')
    },
  },
  mounted(){
    if (
      this.user_type.includes("hr mngr") ||
      this.user_type.includes("prp emp") ||
      this.user_type.includes("general mngr")
    ) {
      this.retrieveOvertime();
      this.getAllFeedback();
      this.retrieve();
    } else {
      this.retrieve();
    }
  },
  methods: {
    disabledDates(date) {
      return date >  new Date().toISOString().substr(0, 10)
    },
    retrieve(){
      this.$axios.get("overtime_request/" + this.user_id).then(response => {
        this.overtime = response.data
        console.log(this.overtime)
      })
      .catch(e => {
        console.log(e);
      })
    },
    messagePop(){
      this.$refs.reminder.show()
    },
    retrieveOvertime() {
      this.$axios
        .get(
          "prp/overtime_request/pending/" +
            this.user_id
        )
        .then(response => {
          this.overtimePending = response.data;
        })
        .catch(e => {
          console.log(e);
        });
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
      this.editedItem.end_time !== null && this.editedItem.end_time !== '' && this.editedItem.reason !== null && this.editedItem.reason !== ''){
        let params = {
          id: this.editedItem.id,
          date: this.editedItem.overtime_date,
          start_time: this.editedItem.start_time,
          end_time: this.editedItem.end_time,
          reason: this.editedItem.reason,
          prp_assigned_id: this.prp_assigned_id
        }     
        this.$axios.post('overtime_request/' + this.editedItem.id, params).then(response=>{
          this.retrieve()
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
          this.retrieve();
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
    confirm(){
      if(this.approveThis === 'approve'){
        this.approve()
      }else{
        this.disapprove()
      }
    },
    disapproveModal(item) {
      this.approveThis = 'disapproved'
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
          "prp/overtime_request/feedback/" + this.id,
          parameter
        )
        .then(response => {
          console.log(response.data)
          this.retrieveOvertime();
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
          "prp/overtime_request/feedback/" + this.id,
          parameter
        )
        .then(res => {
          this.retrieveOvertime();
          this.getAllFeedback();
        });
    },
    getAllFeedback() {
      this.$axios
        .get(
          "prp/overtime_request/feedbacked/" +
            this.user_id
        )
        .then(response => {
          this.feedbacks = response.data.feedbacked_overtime_requests;
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
      console.log(this.dates[0], this.dates[1])
      this.$refs.summary.show(this.dates[0], this.dates[1], item)
    }
  }
}
</script>