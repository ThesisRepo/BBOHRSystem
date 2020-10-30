<template>
  <div>
    <v-toolbar flat>
      <template v-slot:extension>
        <v-tabs
          dark
          background-color="primary"
          fixed-tabs
          v-if="user_type.includes('hr mngr') || user_type.includes('prp emp') || user_type.includes  ( 'general mngr')"
        >
          <v-tabs-slider></v-tabs-slider>
          <v-tab @click="employees = false, requests = true">
            Employees Requests
          </v-tab>
          <v-tab @click="requests = false, employees = true">
            My Requests
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
                      <v-text-field v-model="editedItem.reason" label="Reason"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.overtime_date" label="Overtime Date"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.start_time" label="Start Time"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.end_time" label="End Time"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.prp_assigned_id" label="Approver"></v-text-field>
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
    </v-data-table>

    <!-- EditModal -->
      <v-dialog v-model="dialog" max-width="500px">
        <v-card>
          <v-card-title>
            <span class="headline">Overtime Request Form</span>
          </v-card-title>
          <v-card-text>
            <v-container>
            <span v-if="error" style="color: red; font-style: italic">All data are required!</span>
              <v-row>
                <v-col cols="12" sm="6" md="6">
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
                    label="Start Time"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  <v-text-field
                    v-model="editedItem.end_time"
                    type="time"
                    label="End Time"
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="close"> Cancel </v-btn>
            <v-btn color="blue darken-1" text @click="save"> Save </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

        <!-- //Delete Modal -->
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
            
    <v-data-table v-if="requests && (!user_type.includes('hr mngr') || !user_type.includes('prp emp') || !user_type.includes ('prp emp'))" :headers="headers" :items="overtime" class="elevation-3">
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

        <h4 v-if="prp_assigned_id === 'No Prp assign'">bolbol</h4>

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
import createOvertime from "./modals/create_overtime.vue";
export default {
  data: () => ({
    user_type: localStorage.getItem("user_type"),
    user_id: localStorage.getItem("id"),
    prp_assigned_id: localStorage.getItem("assigned_prp_id"),
    employees: !localStorage.getItem("user_type").includes("finance mngr")
        ? false
        : true,
      requests: !localStorage.getItem("user_type").includes("finance mngr")
        ? true
        : false,
      dialog: false,
      error: false,
      search: null,
      overtime_date: null,
      dialogDelete: false,
    headers: [
      {
        text: "REASON",
        align: "start",
        value: "reason"
      },
      { text: "OVERTIME DATE", value: "date" },
      { text: "START TIME", value: "start_time" },
      { text: "END TIME", value: "end_time" },
      { text: "APPROVER", value: "approver_role.role_name"},
      { text: "STATUS", value: "status.status_name" },
      { text: "ACTIONS", value: "actions", sortable: false }
    ],
    overtime: [],
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
    month: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]
  }),
  components: {
    createOvertime
  },
  mounted(){
    this.retrieve()
  },
  methods: {
    disabledDates(date) {
      return date >  new Date().toISOString().substr(0, 10)
    },
    retrieve(){
      this.$axios.get("http://localhost:8000/overtime_request/" + this.user_id).then(response => {
        this.overtime = response.data
      })
      .catch(e => {
        console.log(e);
      })
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
          prp_assigned_id: 1
        }
        console.log('params', params, this.editedItem.id)      
        this.$axios.post('http://localhost:8000/overtime_request/' + this.editedItem.id, params).then(response=>{
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
      this.$axios.delete('http://localhost:8000/overtime_request/' + this.id).then(response=>{
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