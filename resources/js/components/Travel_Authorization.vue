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
            user_type.include('general mngr')
          "
        >
          <v-tabs-slider></v-tabs-slider>
          <v-tab @click="(employees = false), (requests = true)">Employees Requests</v-tab>
          <v-tab @click="(requests = false), (employees = true)">My Requests</v-tab>
        </v-tabs>
      </template>
    </v-toolbar>
    <v-data-table v-if="employees" :headers="headers" :items="travel" class="elevation-3">
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
            v-icon="mdi - magnify"
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
                      <v-text-field v-model="editedItem.reason" label="reason"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.shift_date" label="shift_date"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.shift_time" label="shift_time"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.prp_assigned" label="prp_assigned"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.status" label="status"></v-text-field>
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
      <template v-slot:no-data>
        <v-btn color="primary" @click="initialize">Reset</v-btn>
      </template>
    </v-data-table>

    <!-- ****************start************** -->
    <v-dialog v-model="dialog" max-width="500px">
      <v-card>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" md="4">
                <v-text-field v-model="editedItem.destination" label="Destination"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <span v-if="error2" style="color: red; font-style: italic">Start date must not be higher than End date!</span>
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
                <span v-if="error1" style="color: red; font-style: italic">End date must be higher than start date!</span>
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
              <v-col cols="12" sm="6" md="4">
                <v-text-field v-model="editedItem.emergency_contact" label="Emergency Contact"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field v-model="editedItem.employee_to_cover" label="Employee to Cover"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field v-model="editedItem.file_uri" label="Documents"></v-text-field>
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
    <!-- ************Delete Modal*************** -->
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

    <v-data-table
      v-if="
        requests &&
        (!user_type.includes('hr mngr') ||
          !user_type.includes('prp mngr') ||
          !user_type.includes('prp emp'))
      "
      :headers="headers"
      :items="travel"
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
      <template v-slot:item.actions="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
        <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
      </template>
    </v-data-table>
  </div>
</template>
<script>
import createTravel from "./modals/create_travel.vue";
export default {
  data: () => ({
    user_type: localStorage.getItem("user_type"),
    employees: !localStorage.getItem("user_type").includes("finance mngr")
      ? false
      : true,
    requests: !localStorage.getItem("user_type").includes("finance mngr")
      ? true
      : false,
    dialog: false,
    error: false,
    error1: false,
    error2: false,
    search: null,
    dialogDelete: false,
    headers: [
      {
        text: "DESTINATION",
        align: "start",
        sortable: false,
        value: "destination"
      },
      { text: "START DATE", value: "start_date" },
      { text: "END DATE", value: "end_date" },
      { text: "EMERGENCY CONTACT", value: "emergency_contact" },
      { text: "EMPLOYEE TO COVER", value: "employee_to_cover_id" },
      { text: "DOCUMENTS", value: "file_uri" },
      { text: "PRP IN CHARGE", value: "prp_assigned" },
      { text: "STATUS", value: "status" },
      { text: "ACTIONS", value: "actions", sortable: false }
    ],
    travel: [],
    editedIndex: 1,
    editedItem: {
      destination: null,
      start_date: null,
      end_date: null,
      emergency_contact: null,
      employee_to_cover: null,
      fire_uri: null
    },
    month: [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December"
    ]
  }),
  components: {
    createTravel
  },
  mounted() {
    this.retrieve()
  },
  methods: {
    changeDate(){
      console.log(this.editedItem.start_date)
      if(this.editedItem.start_date !== null && this.editedItem.start_date !== ''){
        let start = moment(String(this.editedItem.start_date))
        let end = moment(String(this.editedItem.end_date))
        // if(end >= start){
        //   let diff = (end.diff(start))
        //   let differenceInDay = ((((diff/1000)/60)/60)/24)
        //   this.editedItem.total_days = differenceInDay
        //   this.total_days_with_text = differenceInDay + ' days of leave'
        //   this.error1 = false
        //   this.error2 = false
        // }else{
        //   this.error1 = true
        //   this.error2 = true
        // }
        this.disable = false
      }else{
        this.disable = true
      }
    },
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
      this.editedItem.destination = item.destination
      this.editedItem.start_date = item.start_date
      this.editedItem.end_date = item.end_date
      this.editedItem.emergency_contact = item.emergency_contact
      this.editedItem.employee_to_cover = item.employee_to_cover_id
      this.editedItem.file_uri = item.file_uri
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
        console.log('params', params, this.editedItem.id)      
        this.$axios.post('http://localhost:8000/leave_request/' + this.editedItem.id, params).then(response=>{
          this.retrieve()
        })
        this.dialog = false
      }
    },
    disabledDates(date) {
      return date >  new Date().toISOString().substr(0, 10)
    },
    disabledDates2(date) {
      return date >  new Date(this.editedItem.start_date).toISOString().substr(0, 10)
      this.differenceDates();
    },

    deleteItem(item) {
      this.id = item.id
      this.dialogDelete = true;
    },
    deleteItemConfirm() {
      this.$axios.delete('http://localhost:8000/leave_request/' + this.id).then(response=>{
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
    }
  }
}
</script>