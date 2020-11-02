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
          <v-tab @click="(employees = false), (requests = true)">Employees Requests</v-tab>
          <v-tab @click="(requests = false), (employees = true)">My Requests</v-tab>
        </v-tabs>
      </template>
    </v-toolbar>
    <v-data-table v-if="employees" :headers="headers" :items="budget" :search="search" class="elevation-3">
      <template v-slot:top>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat>
          <v-col class="mt-8">
            <v-select :items="items" label="Month"></v-select>
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

          <v-dialog v-model="dialog">
            <v-card class="mt-5">
              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.description" label="Purpose"></v-text-field>
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
                      <v-text-field v-model="editedItem.total_amount" type="number" label="Total Amount"></v-text-field>
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
      <template v-slot:item.status.status_name="{ item }">
        <v-chip :color="getColor(item.status.status_name)">{{item.status.status_name}}</v-chip>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
        <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
      </template>
    </v-data-table>

    <!-- ******************start********************** -->
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card class="mt-5">
        <v-card-title>
          <span class="headline">Budget Request Form</span>
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text>
          <v-container>
            <span v-if="error" style="color: red; font-style: italic">All data are required!</span>
            <v-row>
              <v-col cols="12" sm="6" md="12">
                <v-text-field v-model="editedItem.description_need" label="Purpose"></v-text-field>
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
                      v-model="editedItem.date"
                      label="Date"
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="editedItem.date"
                    :allowed-dates="disabledDates"
                    no-title
                    scrollable
                    color="primary"
                  ></v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field v-model="editedItem.total_amount" type="number" label="Total Amount" prepend-icon=" mdi-calculator"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="12">
                <v-text-field v-model="editedItem.details" label="Details" prepend-icon=" mdi-file-document"></v-text-field>
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

    <v-data-table
      v-if="requests && (!user_type.includes('hr mngr') || !user_type.includes('prp emp') || user_type.includes('prp emp'))"
      :headers="headers"
      :items="budget"
      :search="search"
      class="elevation-3"
    >
      <template v-slot:top>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat>
          <v-toolbar-title class="col pa-3 py-4 white--text" style="font-size: 16px">BUDGET REQUEST</v-toolbar-title>
          <v-text-field
            v-model="search"
            clearable
            flat
            solo-inverted
            hide-details
            prepend-inner-icon="mdi-magnify"
            label="Search"
          ></v-text-field>

          <createBudget
          v-if="user_finance !== 'No Finance assign'"
          ></createBudget>

        <h4 v-if="user_finance === 'No Finance assign'">bolbol</h4>

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
import createBudget from "./modals/create_budget.vue";
export default {
  data: () => ({
    user_type: localStorage.getItem("user_type"),
    user_department: localStorage.getItem("user_department"),
    user_finance: localStorage.getItem('user_finance'),
    user_id: localStorage.getItem("id"),
    employees: !localStorage.getItem("user_type").includes("finance mngr")
      ? false
      : true,
    requests: !localStorage.getItem("user_type").includes("finance mngr")
      ? true
      : false,
    dialog: false,
    error: false,
    dialogDelete: false,
    search: "",
    headers: [
      {
        text: "DESCRIPTION",
        align: "start",
        sortable: false,
        value: "description_need"
      },
      { text: "DATE", value: "date" },
      { text: "DEPARTMENT", value: "department.department_name" },
      { text: "TOTAL AMOUNT", value: "total_amount" },
      { text: "DETAILS", value: "details" },
      { text: "APPROVER", value: "approver_role.role_name" },
      { text: "STATUS", value: "status.status_name" },
      { text: "ACTIONS", value: "actions", sortable: false }
    ],
    budget: [],
    editedIndex: 1,
    editedItem: {
      description_need: null,
      date_needed: null,
      amount: null,
      details: null,
      status: null
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
    createBudget
  },
  mounted() {
    this.retrieve()
  },
  methods: {
    disabledDates(date) {
      return date > new Date().toISOString().substr(0, 10);
    },
    retrieve() {
      this.$axios
        .get("http://localhost:8000/budget_request/" + this.user_id)
        .then(response => {
          this.budget = response.data;
        })
        .catch(e => {
          console.log(e);
        });
    },

    editItem(item) {
      this.editedItem.id = item.id;
      this.editedIndex = this.budget.indexOf(item);
      this.editedItem.description_need = item.description_need;
      this.editedItem.date = item.date;
      this.editedItem.total_amount = item.total_amount;
      this.editedItem.details = item.details;
      this.dialog = true;
    },

    save() {
      if (
        this.editedItem.date !== null &&
        this.editedItem.description_need !== null &&
        this.editedItem.total_amount !== null &&
        this.editedItem.date !== '' &&
        this.editedItem.description_need !== '' &&
        this.editedItem.total_amount !== '' &&
        this.editedItem.details !== '' &&
        this.editedItem.details !== null
      ) {
        let params = {
          id: this.editedItem.id,
          description_need: this.editedItem.description_need,
          date: this.editedItem.date,
          department: this.user_department,
          details: this.editedItem.details,
          total_amount: this.editedItem.total_amount,
          finance_mngr_assigned: user_finance
        };
        console.log("here", params);
        this.$axios
          .post(
            "http://localhost:8000/budget_request/" + this.editedItem.id,
            params
          )
          .then(response => {
            this.retrieve();
          });
        this.dialog = false;
      } else {
        this.error = true;
      }
    },

    deleteItem(item) {
      this.id = item.id;
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      this.$axios
        .delete("http://localhost:8000/budget_request/" + this.id)
        .then(response => {
          console.log("Successfully deleted");
          this.retrieve();
          this.dialogDelete = false;
        });
    },
    close() {
      this.dialog = false;
    },
    closeDelete() {
      this.dialogDelete = false;
    },
    getColor(status) {
      if (status === 'pending') return '#ffa500'
      else if (status === 'approved') return 'green'
      else return 'red'
    }
  }
};
</script>