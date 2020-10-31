<template>
  <div>
    <v-toolbar flat>
      <template v-slot:extension>
        <v-tabs
          dark
          background-color="primary"
          fixed-tabs
          v-if="
            user_type.includes('hr mngr') ||
            user_type.includes('prp emp') ||
            user_type.includes('general mngr')
          "
        >
          <v-tabs-slider></v-tabs-slider>
          <v-tab @click="employees = false, requests = true, feedback = false">
            My Requests
          </v-tab>
          <v-tab @click="requests = false, employees = true, feedback = false">
            Employees Requests
          </v-tab>
          <v-tab @click="requests = false, employees = false, feedback = true">
            Feedback 
          </v-tab>
        </v-tabs>
      </template>
    </v-toolbar>
    <!-- Feedback -->
    <v-data-table v-if="feedback" :headers="headersFeed" :items="feedbacks" class="elevation-3">
      <template v-slot:top>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat>
          <v-col class="mt-8">
            <v-select :items="month" label="Month"></v-select>
          </v-col>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <v-btn depressed color="primary">SUMMARY</v-btn>
          <v-divider class="mx-4" vertical></v-divider>
          <v-spacer></v-spacer>
          <v-text-field
            v-model="search"
            label="Search"
            single-line
            hide-details
            class="mx-5"
          ></v-text-field>
        </v-toolbar>
      </template>
      <template v-slot:item.status.status_name="{ item }">
        <v-chip :color="getColor(item.status.status_name)">{{item.status.status_name}}</v-chip>
      </template>
    </v-data-table>

    <!-- Shift -->
    <v-data-table
      v-if="employees"
      :headers="headersEmp"
      :items="shiftPending"
      class="elevation-3"
    >
      <template v-slot:top>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat>
          <v-col class="mt-8">
            <v-select :items="month" label="Month"></v-select> </v-col
          >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <v-btn depressed color="primary">SUMMARY</v-btn>
          <v-divider class="mx-4" vertical></v-divider>
          <v-spacer></v-spacer>
          <v-text-field
            v-model="search"
            label="Search"
            single-line
            hide-details
            class="mx-5"
          ></v-text-field>
        </v-toolbar>
      </template>
      <template v-slot:item.status.status_name="{ item }">
        <v-chip :color="getColor(item.status.status_name)">{{item.status.status_name}}</v-chip>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon small class="mr-2" @click="approveModal(item)">mdi-check-decagram</v-icon>
        <v-icon small @click="disapproveModal(item)">mdi-close-circle</v-icon>
      </template>
    </v-data-table>

    <v-dialog v-model="dialogConfirm" max-width="500px">
      <v-card>
        <v-card-title class="headline">Are you sure you want to approve?</v-card-title>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="closeApprove">Cancel</v-btn>
          <v-btn color="blue darken-1" text @click="approve">OK</v-btn>
          <v-spacer></v-spacer>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="dialogDisapprove" max-width="500px">
      <v-card>
        <v-card-title class="headline">Are you sure you want to reject?</v-card-title>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="closeReject">Cancel</v-btn>
          <v-btn color="blue darken-1" text @click="disapprove">OK</v-btn>
          <v-spacer></v-spacer>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- editModal -->
     <v-dialog v-model="dialog" max-width="500px">
      <v-card>
        <v-card-title>
          <span class="headline">Shift Change Request Form</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <span v-if="error" style="color: red; font-style: italic">All data are required!</span>
            <v-row>
              <v-col cols="12" sm="6" md="12">
                <v-text-field
                  v-model="editedItem.reason"
                  label="Reason"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-menu
                  :close-on-content-click="true"
                  transition="scale-transition"
                  offset-y
                  min-width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="editedItem.shift_date"
                      label="Shift Date"
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                      color="primary"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="editedItem.shift_date"
                    :allowed-dates="disabledDates"
                    no-title
                    scrollable
                    color="primary"
                  ></v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-select
                  :items="sTime"
                  label="Shift Time*"
                  item-text="shift_time_name"
                  item-value="id"
                  v-model="editedItem.shift_time"
                  required
                ></v-select>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="close">
            Cancel
          </v-btn>
          <v-btn color="blue darken-1" text @click="save"> Save </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- DeleteModal -->
    <v-dialog v-model="dialogDelete" max-width="500px">
      <v-card>
        <v-card-title class="headline"
          >Are you sure you want to delete this item?</v-card-title>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
          <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
          <v-spacer></v-spacer>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-data-table
      v-if="
        requests &&
        (!user_type.includes('hr mngr') ||
          !user_type.includes('prp mngr') ||
          !user_type.includes('prp emp'))
      "
      :headers="headers"
      :items="shifts"
      class="elevation-3"
    >
      <template v-slot:top>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat>
          <v-toolbar-title
            class="col pa-3 py-4 white--text"
            style="font-size: 16px"
            >SHIFT REQUEST</v-toolbar-title
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

          <createShift
          v-if="prp_assigned_id !== 'No Prp assign'"
          ></createShift>
          
          <h4 v-if="prp_assigned_id === 'No Prp assign'">bolbol</h4>

        </v-toolbar>
      </template>
      
      <template v-slot:item.status.status_name="{ item }">
        <v-chip :color="getColor(item.status.status_name)">{{item.status.status_name}}</v-chip>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
        <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
      </template>
    </v-data-table>
  </div>
</template>
<script>
import createShift from "./modals/create_shift.vue";
export default {
  data: () => ({
    user_type: localStorage.getItem("user_type"),
    user_id: localStorage.getItem("id"),
    prp_assigned_id: localStorage.getItem("assigned_prp_id"),
    employees: !localStorage.getItem("user_type").includes("finance mngr") ? false : true,
    requests: !localStorage.getItem("user_type").includes("finance mngr") ? true : false,
    feedback: !localStorage.getItem("user_type").includes("finance mngr") ? false : true,
    dialog: false,
    dialogDelete: false,
    dialogConfirm: false,
    dialogDisapprove: false,
    search: null,
    sTime: null,
    error: false,
    shift_date: null,
    reason: null,
    shift_time: null,
    headers: [
      {
        text: "REASON",
        align: "start",
        value: "reason",
      },
      { text: "SHIFT DATE", value: "shift_date" },
      { text: "SHIFT TIME", value: "shift_time.shift_time_name" },
      { text: "APPROVER", value: "approver_role.role_name"},
      { text: "STATUS", value: "status.status_name" },
      { text: "ACTIONS", value: "actions", sortable: false },
    ],
    headersEmp: [
      { text: "REQUESTER", align: "start", value: "user.first_name" },
      { text: "SHIFT DATE", value: "shift_date" },
      { text: "SHIFT TIME", value: "shift_time.shift_time_name" },
      { text: "APPROVER", value: "approver_role.role_name"},
      { text: "STATUS", value: "status.status_name" },
      { text: "ACTIONS", value: "actions", sortable: false },
    ],
    headersFeed: [
      { text: "REQUESTER", align: "start", value: "user.first_name" },
      { text: "SHIFT DATE", value: "shift_date" },
      { text: "SHIFT TIME", value: "shift_time.shift_time_name" },
      { text: "APPROVER", value: "approver_role.role_name"},
      { text: "STATUS", value: "status.status_name" },
    ],
    shifts: [],
    shiftPending: [],
    feedbacks: [],
    editedIndex: null,
    editedItem: {
      reason: null,
      shift_date: null,
      shift_time: null
    },
    start_date: null,
    month: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
    // shiftTime: [{value:1, time:'8 - 5pm'}, 
    // {value: 2, time:'9 - 6pm'}, 
    // {value: 3, time:'2 - 11pm'}],pt
  }),
  components: {
    createShift,
  },
  mounted() {
    if(this.user_type.includes('hr mngr') || this.user_type.includes('prp emp') || this.user_type.includes('general mngr')){
      this.retrieveShift()
      this.getAllFeedback()
      this.retrieve()
    }else{
      this.retrieve()
    }
  },
  methods: {
    disabledDates(date) {
      return date > new Date().toISOString().substr(0, 10);
    },
    retrieve(){
      this.$axios.get("http://localhost:8000/shift_change_request/" + this.user_id).then(response => {
        this.shifts = response.data
      })
      .catch(e => {
        console.log(e);
      })
    },
    retrieveShift(){
      this.$axios.get("http://localhost:8000/prp/shift_change_request/pending/" + this.user_id).then(response => {
        console.log('hello', response.data)
        this.shiftPending = response.data
      })
      .catch(e => {
        console.log(e);
      })
    },

    editItem(item) {
      this.editedItem.id = item.id
      this.editedIndex = this.shifts.indexOf(item)
      this.editedItem.shift_time = item.shift_time_id
      this.editedItem.shift_date = item.shift_date
      this.editedItem.reason = item.reason
      this.dialog = true;
    },

    save() {
      if(this.editedItem.shift_time !== null && this.editedItem.shift_time !== '' && this.editedItem.shift_date !== null && this.shift_date !== '' &&
      this.editedItem.reason !== null && this.editedItem.reason !== ''){
        let params = {
          user_id: this.user_id,
          shift_time_id: this.editedItem.shift_time,
          shift_date: this.editedItem.shift_date,
          reason: this.editedItem.reason,
          prp_assigned_id: 1
        }   
        this.$axios.post('http://localhost:8000/shift_change_request/' + this.editedItem.id, params).then(response=>{
          this.retrieve()
        })
        this.dialog = false;
      }else{
        this.error = true;
      }
    },

    deleteItem(item) {
      this.id = item.id
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      this.$axios.delete('http://localhost:8000/shift_change_request/' + this.id).then(response=>{
        console.log('Successfully deleted')
        this.retrieve()
        this.dialogDelete = false
      })
    },
    close(){
      this.dialog = false
    },
    closeDelete(){
      this.dialogDelete = false
    },
    getShift(){
      this.$axios.get("http://localhost:8000/shift_time").then(response => {
        this.sTime = response.data
      })
    },
    getColor(status) {
      if (status === 'pending') return '#ffa500'
      else if (status === 'approved') return 'green'
      else return 'red'
    },
    approveModal(item){
      this.id = item.id
      this.dialogConfirm = true
    },
    disapproveModal(item){
      this.id = item.id
      this.dialogDisapprove  = true
    },
    closeApprove(){
      this.dialogConfirm = false
    },
    closeReject(){
      this.dialogDisapprove = false
    },
    approve(){
      let parameter = {
        user_id: this.user_id,
        status_id: 1
      }
      this.$axios.post('http://localhost:8000/prp/shift_change_request/feedback/' + this.id, parameter).then(response =>{
        console.log('Approve', response.data)
        this.retrieveShift()
        this.getAllFeedback()
        this.closeApprove()
      })
    },
    disapprove(){
      let parameter = {
        user_id: this.user_id,
        status_id: 3
      }
      this.$axios.post('http://localhost:8000/prp/shift_change_request/feedback/' + this.id, parameter).then(res =>{
        console.log('Disapprovve', res.data)
        this.retrieveShift()
        this.getAllFeedback()
        this.closeReject()
      })
    },
    getAllFeedback(){
      this.$axios.get('http://localhost:8000/prp/shift_change_request/feedbacked/' + this.user_id).then(response => {
        console.log('Retrieve', response.data)
        if(response.data > 0){
          this.feedbacks = response.data
        }else{
          response.data = null
        }
      })
    }
  }
}
</script>