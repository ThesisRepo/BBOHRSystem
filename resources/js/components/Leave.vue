<template>
  <div>
    <v-toolbar flat>
      <template v-slot:extension>
        <v-tabs
          dark
          background-color="primary"
          fixed-tabs
          v-if="user_type.includes('hr mngr') || user_type.includes('prp emp') || user_type.includes('general mngr')"
        >
          <v-tabs-slider></v-tabs-slider>
          <v-tab @click="employees = false, requests = true">
            My Requests
          </v-tab>
          <v-tab @click="requests = false, employees = true">
            Employees Requests 
          </v-tab>
        </v-tabs>
      </template>
    </v-toolbar>
    <v-data-table v-if="employees" :headers="headers" :items="request" class="elevation-3">
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
            v-icon="mdi-magnify"
            label="Search"
            single-line
            hide-details
            class="mx-5"
          ></v-text-field>
          <v-dialog v-model="dialog">
            <v-card class="mt-5">
              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.selectedLeaveType" label="Type of Leave"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.total_days" label="Total of Day/s"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.start_date" label="Start Date"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.end_date" label="End Date"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.prp_assigned" label="Approver"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.status" label="Status"></v-text-field>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                <v-btn color="blue darken-1" text @click="save()">Save</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
          <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="headline">Are you sure you want to delete this item?</v-card-title>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
        <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
      </template>
      <!-- <template v-slot:no-data>
        <v-btn color="primary" @click="initialize">Reset</v-btn>
      </template> -->
    </v-data-table>

    <!-- Edit Modal -->
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card class="mt-5">
        <v-card-title>
          <span class="headline">Leave Request Form</span>
        </v-card-title>
        <v-card-text>
          <v-container>
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
                <v-text-field v-model="editedItem.total_days" label="Total Day/s"></v-text-field>
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
                      v-model="editedItem.start_date"
                      label="Start Date"
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="start_date"
                    :allowed-dates="disabledDates"
                    no-title
                    scrollable
                    color="primary"
                  ></v-date-picker>
                </v-menu>
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
                      v-model="editedItem.end_date"
                      label="End Date"
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="start_date"
                    :allowed-dates="disabledDates2"
                    no-title
                    scrollable
                    color="primary"
                  ></v-date-picker>
                </v-menu>
              </v-col>
              <!-- <v-col cols="12" sm="6" md="4">
                <v-text-field v-model="editedItem.prp_assigned" label="Approver "></v-text-field>
              </v-col> -->
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
    <v-dialog v-model="dialogDelete" max-width="500px">
      <v-card>
        <v-card-title class="headline">Are you sure you want to delete this item?</v-card-title>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
          <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
          <v-spacer></v-spacer>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-data-table v-if="requests && (!user_type.includes('hr mngr') || !user_type.includes('prp mngr') || !user_type.includes('prp emp'))" :headers="headers" :items="request" class="elevation-3">
      <template v-slot:top>
      <v-toolbar class="mb-2" color="blue darken-1" dark flat>
        <v-toolbar-title class="col pa-3 py-4 white--text"
          >LEAVE REQUEST</v-toolbar-title
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

        <createLeave></createLeave>

      </v-toolbar>
    </template>
      <template v-slot:item.actions="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
        <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
      </template>
    </v-data-table>
  </div>
</template>
<script>
import createLeave from "./modals/create_leave.vue";
export default {
  data: () => ({
    user_type: localStorage.getItem("user_type"),
    user_id: localStorage.getItem("id"),
    employees: !(localStorage.getItem('user_type')).includes('finance mngr') ? false : true,
    requests: !(localStorage.getItem('user_type')).includes('finance mngr') ? true : false,
    dialog: false,
    dialogDelete: false,
    start_date: null,
    search: null,
    headers: [
      {
        text: "TYPE OF LEAVE",
        align: "start",
        sortable: false,
        value: "leave_type.leave_name"
      },
      { text: "TOTAL DAY/S LEAVE", value: "number_of_days" },
      { text: "START DATE", value: "start_date" },
      { text: "END DATE", value: "end_date" },
      { text: "APPROVER", value: "approver_role.role_name" },
      { text: "STATUS", value: "status_id" },
      { text: "ACTIONS", value: "actions", sortable: false }
    ],
    request: [],
    editedIndex: -1,
    editedItem: {
      id: null,
      selectedLeaveType: 0,
      total_days: 0,
      start_date: 0,
      end_date: 0
    },
    defaultItem: {
      selectedLeaveType: 0,
      total_days: 0,
      start_date: 0,
      end_date: 0
    },
    month: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
    leaveType: [{value:1, name:'Sick Leave'}, 
      {value: 2, name:'Solo Parent Leave'}, 
      {value: 3, name:'Vacation Leave'}, 
      {value: 4, name:'Emergency Leave'}, 
      {value: 5, name:'Paternity Leave'},
      {value: 6, name:'Maternity Leave'}]
  }),
  components: {
    createLeave
  },
  mounted(){
    this.retrieve()
  },
  methods: {
    retrieve(){
      this.$axios.get("http://localhost:8000/leave_request/" + this.user_id).then(response => {
        this.request = response.data
        console.log('here na mi', this.request)
      })
      .catch(e => {
        console.log(e);
      })
    },
    editItem(item) {
      this.editedItem.id = item.id
      this.editedIndex = this.request.indexOf(item)
      this.editedItem.selectedLeaveType = item.leave_type_id
      this.editedItem.total_days = item.number_of_days
      this.editedItem.start_date = item.start_date
      this.editedItem.end_date = item.end_date
      this.dialog = true;
    },
    save() {
      let params = {
        id: this.editedItem.id,
        leave_type_id: this.editedItem.selectedLeaveType,
        number_of_days: this.editedItem.total_days,
        start_date: this.editedItem.start_date,
        end_date: this.editedItem.end_date,
        prp_assigned_id: 1
      }
      this.$axios.post('http://localhost:8000/leave_request/' + this.user_id, params).then(response=>{
        this.retrieve()
      })
      this.dialog = false;
    },
    disabledDates(date) {
      return date >  new Date().toISOString().substr(0, 10)
    },
    disabledDates2(date) {
      return date >  new Date(this.start_date).toISOString().substr(0, 10)
      this.differenceDates()
    },
    differenceDates() {
      let start = moment(String(this.start_date))
      let end = moment(String(this.end_date))
      let diff = (end.diff(start))
      let differenceInDay = ((((diff/1000)/60)/60)/24)
      console.log('-----------mini',  differenceInDay)
      this.differenceInDay = differenceInDay
    },
    deleteItem(item) {
      this.editedIndex = this.request.indexOf(item);
      this.dialogDelete = true;
    },
    deleteItemConfirm() {
      this.$axios.delete('http://localhost:8000/leave_request/' + this.user_id).then(response=>{
        console.log('successfully deleted')
        this.request.splice(this.editedIndex, 1);
        this.dialogDelete = false;
      })
    },
    close(){
      this.dialog = false
    },
    closeDelete(){
      this.dialogDelete = false
    }
  }
}
</script>
