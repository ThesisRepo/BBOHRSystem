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
          <v-tab @click="(employees = false), (requests = true)">
            Employees Requests
          </v-tab>
          <v-tab @click="(requests = false), (employees = true)">
            My Requests
          </v-tab>
        </v-tabs>
      </template>
    </v-toolbar>
    <v-data-table
      v-if="employees"
      :headers="headers"
      :items="shifts"
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
                      <v-text-field
                        v-model="editedItem.reason"
                        label="reason"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.shift_date"
                        label="shift_date"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.shift_time"
                        label="shift_time"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.prp_assigned"
                        label="prp_assigned"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.status"
                        label="status"
                      ></v-text-field>
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
              <v-card-title class="headline"
                >Are you sure you want to delete this item?</v-card-title
              >
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="closeDelete"
                  >Cancel</v-btn
                >
                <v-btn color="blue darken-1" text @click="deleteItemConfirm"
                  >OK</v-btn
                >
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

    <!-- editModal -->
     <v-dialog v-model="dialog" max-width="500px">
      <v-card>
        <v-card-title>
          <span class="headline">Shift Change Request Form</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" md="12">
                <v-text-field
                  v-model="editedItem.reason"
                  label="Reason"
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
                    v-model="shift_date"
                    :allowed-dates="disabledDates"
                    no-title
                    scrollable
                    color="primary"
                  ></v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-select
                  :items="shiftTime"
                  label="Shift Time*"
                  item-text="time"
                  item-value="value"
                  v-model="shift_time"
                  required
                ></v-select>
              </v-col>
              <!-- <v-col cols="12" sm="6" md="6">
                <v-text-field
                  v-model="editedItem.prp_assigned_id"
                  label="Approver"
                ></v-text-field>
              </v-col> -->
              <!-- <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model="editedItem.status"
                  label="status"
                ></v-text-field>
              </v-col> -->
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
          >Are you sure you want to delete this item?</v-card-title
        >
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="closeDelete"
            >Cancel</v-btn
          >
          <v-btn color="blue darken-1" text @click="deleteItemConfirm"
            >OK</v-btn
          >
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
          <createShift></createShift>
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
import createShift from "./modals/create_shift.vue";
export default {
  data: () => ({
    user_type: localStorage.getItem("user_type"),
    user_id: localStorage.getItem("id"),
    employees: !localStorage.getItem("user_type").includes("finance mngr")
      ? false
      : true,
    requests: !localStorage.getItem("user_type").includes("finance mngr")
      ? true
      : false,
    dialog: false,
    dialogDelete: false,
    search: null,
    shift_date: null,
    reason: null,
    shift_time: null,
    headers: [
      {
        text: "REASON",
        align: "start",
        sortable: false,
        value: "reason",
      },
      { text: "SHIFT DATE", value: "shift_date" },
      { text: "SHIFT TIME", value: "shift_time_id" },
      { text: "APPROVER", value: "approver_role.role_name"},
      { text: "STATUS", value: "status_id" },
      { text: "ACTIONS", value: "actions", sortable: false },
    ],
    shifts: [],
    editedIndex: null,
    editedItem: {
      reason: "",
      shift_date: 0,
      shift_time: 0
    },
    defaultItem: {
      reason: "",
      shift_date: 0,
      shift_time: 0
    },
    start_date: null,
    month: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
    shiftTime: [{value:1, time:'8 - 5pm'}, 
    {value: 2, time:'9 - 6pm'}, 
    {value: 3, time:'2 - 11pm'}],
  }),
  components: {
    createShift,
  },
  mounted() {
    this.retrieve()
  },
  methods: {
    disabledDates(date) {
      return date > new Date().toISOString().substr(0, 10);
    },
    retrieve(){
      this.$axios.get("http://localhost:8000/shift_change_request/" + this.user_id).then(response => {
        this.shifts = response.data
        console.log('here na mi', this.shifts)
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
      this.dialog = true;
    },

    save() {
      let params = {
        id: this.editedItem.id,
        shift_time_id: this.editedItem.shift_time,
        shift_date: this.editedItem.shift_date,
        prp_assigned_id: 1
      }
      console.log('params', params, this.editedItem.id)      
      this.$axios.post('http://localhost:8000/shift_change_request/' + this.editedItem.id, params).then(response=>{
        this.retrieve()
      })
      this.dialog = false;
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
    }
  }
}
</script>