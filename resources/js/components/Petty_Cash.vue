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
            Employees Requests
          </v-tab>
          <v-tab @click="requests = false, employees = true">
            My Requests
          </v-tab>
        </v-tabs>
      </template>
    </v-toolbar>
    <v-data-table v-if="employees" :headers="headers" :items="petty" class="elevation-3">
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
                      <v-text-field v-model="editedItem.description" label="Description"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.details" label="Details"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.date" label="Date"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.department" label="Department"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.total_amount" label="Total Amount"></v-text-field>
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
    
    <!-- Employee Edit Modal -->
    <v-dialog v-model="dialog" max-width="500px">
        <v-card>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model="editedItem.description_need"
                  label="Description of Need"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model="editedItem.date"
                  label="Date"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model="editedItem.details"
                  label="Details"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model="editedItem.department"
                  label="department"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model="editedItem.total_amount"
                  label="Total Amount"
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

    <!-- Employee DeleteModal -->
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

    <!-- MyRequests -->
    <v-data-table v-if="requests && (!user_type.includes('hr mngr') || !user_type.includes('prp emp') || user_type.includes('prp emp'))" :headers="headers" :items="petty" class="elevation-3">
      <template v-slot:top>
      <v-toolbar class="mb-2" color="blue darken-1" dark flat>
        <v-toolbar-title class="col pa-3 py-4 white--text"  style="font-size:16px "
          >PETTY REQUEST</v-toolbar-title
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
         <createPetty></createPetty>

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
import createPetty from "./modals/create_petty.vue";
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
    dialogDelete: false,
    headers: [
      {
        text: "DESCRIPTION",
        align: "start",
        sortable: false,
        value: "description_need"
      },
      { text: "DETAILS", value: "details" },
      { text: "DATE", value: "date_needed" },
      { text: "DEPARTMENT", value: "department" },
      { text: "TOTAL AMOUNT", value: "total_amount" },
      { text: "APPROVER", value: "approver_role.role_name" },
      { text: "STATUS", value: "status_id" },
      { text: "ACTIONS", value: "actions", sortable: false }
    ],
    petty: [],
    search: null,
    editedIndex: 1,
    editedItem: {
      description_need: "",
      date: 0,
      department: 0,
      total_amount: 0,
      details: "",
      prp_assigned_id: "",
      status: ""
    },
    defaultItem: {
      description_need: "",
      date: 0,
      department: 0,
      total_amount: 0,
      details: "",
      prp_assigned_id: "",
      status: ""
    },
    month: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]
  }),
  components: {
    createPetty
  },
  mounted(){
    console.log('----------testing------------', this.user_type, this.requests, this.employees)
    this.retrieve()
  },
  methods: {
    disabledDates(date) {
      return date >  new Date().toISOString().substr(0, 10)
    },
    retrieve(){
      this.$axios.get("http://localhost:8000/petty_cash_request/" + this.user_id).then(response => {
        this.petty = response.data
        console.log('here na mi', this.petty)
      })
      .catch(e => {
        console.log(e);
      })
    },

    editItem(item) {
      this.editedItem.id = item.id
      this.editedIndex = this.overtime.indexOf(item)
      this.editedItem.description_need = item.description_need
      this.editedItem.date = item.date
      this.editedItem.department_id = item.department
      this.editedItem.total_amount = item.total_amount
      this.dialog = true;
    },

    save() {
      let params = {
        id: this.editedItem.id,
        date: this.editedItem.date,
        department: this.editedItem.department_id,
        total_amount: this.editedItem.total_amount,
        prp_assigned_id: 1
      }
      console.log('params', params, this.editedItem.id)      
      this.$axios.post('http://localhost:8000/petty_cash_request/' + this.editedItem.id, params).then(response=>{
        this.retrieve()
      })
      this.dialog = false;
    },

    deleteItem(item) {
      this.id = item.id
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      this.$axios.delete('http://localhost:8000/petty_cash_request/' + this.id).then(response=>{
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
};
</script>
