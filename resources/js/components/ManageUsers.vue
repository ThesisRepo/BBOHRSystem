<template>
  <div>
    <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="dialog = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title>Edit User</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>
        <br>
        <br>
        <v-container class="primary fill-height">
          <v-card class="mx-auto" max-width="1200">
            <v-card-text
              class="display-1.8 text--primary"
              style="padding:5px!important; margin-left: 5%;"
            >
              <b>Personal Information:</b>
            </v-card-text>
            <v-divider></v-divider>
            <div style="margin-left: 10%; margin-right: 10%">
              <v-row>
                <v-col cols="12" md="4">
                  <v-text-field
                    class="input-name"
                    v-model="editItem.first_name"
                    label="Firstname"
                    prepend-icon="mdi-account"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                  <v-text-field
                    class="input-name"
                    v-model="editItem.last_name"
                    label="Lastname"
                    prepend-icon="mdi-account"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                  <v-text-field
                    class="input-name"
                    v-model="editItem.contact_number"
                    label="Contact Number"
                    prepend-icon="mdi-phone"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                  <v-text-field
                    class="input-name"
                    v-model="editItem.address"
                    label="Address"
                    prepend-icon="mdi-home"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                  <v-select
                    :items="['Female', 'Male']"
                    label="Gender*"
                    v-model="editItem.gender"
                    prepend-icon="mdi-gender-male-female"
                    required
                  ></v-select>
                </v-col>
                <v-col cols="12" md="4">
                  <v-menu
                    ref="menu"
                    v-model="menu"
                    :close-on-content-click="true"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template
                      v-slot:activator="{
                            on,
                            attrs
                        }"
                    >
                      <v-text-field
                        v-model="editItem.birthday"
                        label="Birthday"
                        prepend-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                      ></v-text-field>
                    </template>
                    <v-date-picker
                      v-model="editItem.birthday"
                      :max="
                            new Date()
                                .toISOString()
                                .substr(0, 10)
                            "
                      min="1950-01-01"
                      @change="save"
                    ></v-date-picker>
                  </v-menu>
                </v-col>
              </v-row>
            </div>
            <v-card-text class="display-1.5 text--primary" style="margin-left: 5%;">
              <b>Business Information:</b>
            </v-card-text>
            <v-divider></v-divider>
            <div style="margin-left: 10%; margin-right: 10%">
              <v-row>
                <v-col cols="12" md="3">
                  <v-text-field
                    class="input-name"
                    v-model="editItem.email"
                    label="Email"
                    prepend-icon="mdi-account"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                  <v-text-field
                    class="input-name"
                    v-model="editItem.password"
                    type="password"
                    label="Password"
                    prepend-icon="mdi-key"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                  <v-text-field
                    class="input-name"
                    v-model="editItem.confirm_password"
                    type="password"
                    label="Confirm Password"
                    prepend-icon="mdi-key"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                  <v-text-field
                    class="input-name"
                    v-model="editItem.company_number"
                    label="Company Number"
                    prepend-icon="mdi-phone"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                  <v-menu
                    :close-on-content-click="true"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                        v-model="editItem.regularization_date"
                        label="Regularization Date"
                        prepend-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                      ></v-text-field>
                    </template>
                    <v-date-picker
                      v-model="editItem.regularization_date"
                      no-title
                      scrollable
                      color="primary"
                    ></v-date-picker>
                  </v-menu>
                </v-col>
                <v-col cols="12" md="4">
                  <v-select
                    :items="[
                            'Probationary',
                            'OJT',
                            'Regular'
                        ]"
                    label="Company Status*"
                    v-model="editItem.company_status"
                    required
                  ></v-select>
                </v-col>
                <v-col cols="12" md="4">
                  <v-select
                    :items="[
                            'Employee',
                            'HR',
                            'Finance'
                        ]"
                    label="Company Position*"
                    v-model="editItem.company_position"
                    prepend-icon="mdi-account"
                    required
                  ></v-select>
                </v-col>
              </v-row>
            </div>
            <v-card-text class="display-1.5 text--primary" style="margin-left: 5%;">
              <b>Business Assign:</b>
            </v-card-text>
            <v-divider></v-divider>
            <div style="margin-left: 10%; margin-right: 10%">
              <v-row>
                <v-col cols="12" md="4">
                  <v-select
                    :items="prp"
                    label="PRP Assign"
                    :item-text="
                        prp =>
                            prp.first_name +
                            ' ' +
                            prp.last_name
                        "
                    item-value="id"
                    v-model="editItem.selectPrp"
                    prepend-icon="mdi-account"
                    required
                  ></v-select>
                </v-col>
                <v-col cols="12" md="4">
                  <v-select
                    :items="finance"
                    label="Finance Assign"
                    prepend-icon="mdi-account"
                    :item-text="
                            finance =>
                                finance.first_name +
                                ' ' +
                                finance.last_name
                            "
                    item-value="id"
                    v-model="editItem.selectFinance"
                    required
                  ></v-select>
                </v-col>
                <v-col cols="12" md="4">
                  <v-select
                    :items="[
                            'Finance',
                            'Marketing',
                            'HR'
                        ]"
                    label="Department*"
                    v-model="editItem.department"
                    required
                  ></v-select>
                </v-col>
                <v-col cols="12" md="4">
                  <v-select
                    :items="sTime"
                    label="Shift Time*"
                    item-text="shift_time_name"
                    item-value="id"
                    v-model="editItem.shift_time"
                    prepend-icon="mdi-timelapse"
                    required
                  ></v-select>
                </v-col>
                <v-col cols="12" md="4">
                  <v-menu
                    :close-on-content-click="true"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                        v-model="editItem.date_hired"
                        label="Date Hired"
                        prepend-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                      ></v-text-field>
                    </template>
                    <v-date-picker v-model="editItem.date_hired" no-title scrollable color="primary"></v-date-picker>
                  </v-menu>
                </v-col>
                <v-col cols="12" md="4">
                  <v-text-field
                    class="input-name"
                    v-model="editItem.allowed_leave_number"
                    type="number"
                    label="Allowed Leave No."
                    prepend-icon="mdi-phone"
                  ></v-text-field>
                </v-col>
              </v-row>
            </div>
            <v-card-text class="display-1.5 text--primary" style="margin-left: 5%;">
              <b>Other Information:</b>
            </v-card-text>
            <v-divider></v-divider>
            <div style="margin-left: 10%; margin-right: 10%">
              <v-row>
                <v-col cols="12" md="3">
                  <v-text-field
                    class="input-name"
                    v-model="editItem.pag_ibig_number"
                    label="Pag-ibig No."
                    prepend-icon="mdi-credit-card"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                  <v-text-field
                    class="input-name"
                    v-model="editItem.sss_number"
                    label="SSS No."
                    prepend-icon="mdi-credit-card"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                  <v-text-field
                    class="input-name"
                    v-model="editItem.tin_number"
                    label="TIN"
                    prepend-icon="mdi-credit-card"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                  <v-text-field
                    class="input-name"
                    v-model="editItem.philhealth_number"
                    label="PhilHealth No."
                    prepend-icon="mdi-credit-card"
                  ></v-text-field>
                  <br>
                  <v-btn color="primary" @click="update(), (dialog = false)">Save</v-btn>
                </v-col>
              </v-row>
            </div>
          </v-card>
        </v-container>
      </v-card>
    </v-dialog>

    <v-data-table :headers="headers" :items="user" class="elevation-1">
      <template v-slot:top>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat>
          <v-toolbar-title class="col pa-3 py-4 white--text" style="font-size:16px ">MANAGE USER</v-toolbar-title>
          <v-text-field
            v-model="search"
            clearable
            flat
            solo-inverted
            hide-details
            prepend-inner-icon="mdi-magnify"
            label="Search"
          ></v-text-field>

          <v-dialog v-model="dialog" max-width="500px">
            <template v-slot:activator="{ on, attrs }">
              <createUser></createUser>
            </template>
          </v-dialog>

          <!-- Delete Modal -->
          <ConfirmationDel ref="confirmDel" @onConfirm="confirmDel($event)"></ConfirmationDel>

        </v-toolbar>
      </template>
      <template v-slot:item.actions="{ item }">
        <!-- <v-icon small class="mr-2" @click="seeItem(item)">mdi-eye</v-icon> -->
        <v-icon small class="mr-2" @click="editedItem(item)">mdi-pencil</v-icon>
        <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
      </template>
    </v-data-table>
  </div>
</template>
<script>
import createUser from "./modals/add_user.vue";
import ConfirmationDel from "./modals/confirmation/delete.vue";
export default {
  data: () => ({
    showModal: false,
    dialog: false,
    menu: false,
    prp: null,
    finance: null,
    sTime: null,
    search: "",
    headers: [
      { text: "NAME", align: "start", sortable: false, value: "first_name" },
      { text: "ID NO.", value: "user_information.company_number" },
      { text: "COMPANY EMAIL", value: "email" },
      { text: "DEPARTMENT", value: "user_information.department_id" },
      { text: "PRP IN CHARGE", value: "prp_assigned" },
      { text: "STATUS", value: "user_information.company_status" },
      { text: "ACTIONS", value: "actions", sortable: false }
    ],
    user: [],
    editedIndex: null,
    editItem: {
      id: null,
      address: null,
      civil_status: null,
      contact_number: null,
      pag_ibig_number: null,
      sss_number: null,
      tin_number: null,
      philhealth_number: null,
      selectPrp: null,
      selectFinance: null,
      first_name: null,
      last_name: null,
      email: null,
      password: null,
      regularization_date: null,
      password_confirmation: null,
      department: null,
      shift_time: null,
      gender: null,
      allowed_leave_number: null,
      company_position: null,
      date_hired: null,
      company_status: null,
      birthday: null,
      company_number: null,
    },
    user_id: localStorage.getItem("id")
  }),
  components: {
    ConfirmationDel,
    createUser
  },
  mounted() {
    this.retrieve();
  },
  methods: {
    retrieve() {
      this.$axios.get("http://localhost:8000/hr/manage/user").then(response => {
        this.user = response.data;
      });
    },
    editedItem(item) {
      this.editItem.id = item.id
      this.editItem.address = item.address
      this.editItem.civil_status = item.civil_status
      this.editItem.contact_number = item.contact_number
      this.editItem.pag_ibig_number = item.pag_ibig_number
      this.editItem.sss_number = item.sss_number
      this.editItem.tin_number = item.tin_number
      this.editItem.philhealth_number = item.philhealth_number
      this.editItem.selectPrp = item.prp_assigned
      this.editItem.selectFinance = item.finance_assigned
      this.editItem.first_name = item.first_name
      this.editItem.last_name = item.last_name
      this.editItem.email = item.email
      this.editItem.password = item.password
      this.editItem.regularization_date = item.regularization_date
      this.editItem.password_confirmation = item.confirm_password
      this.editItem.department = item.department
      this.editItem.shift_time = item.shift_time
      this.editItem.gender = item.gender
      this.editItem.allowed_leave_number = item.allowed_leave_number
      this.editItem.company_position = item.company_position
      this.editItem.date_hired = item.date_hired
      this.editItem.company_status = item.company_status
      this.editItem.birthday = item.birthday
      this.editItem.company_number = item.company_number
      this.dialog = true
    },
    update(){
      let params = {
        id: this.editItem.id,
        address: this.editItem.address,
        civil_status: this.editItem.civil_status,
        contact_number: this.editItem.contact_number,
        pag_ibig_number: this.editItem.pag_ibig_number,
        sss_number: this.editItem.sss_number,
        tin_number: this.editItem.tin_number,
        philhealth_number: this.editItem.philhealth_number,
        prp_assigned: this.editItem.selectPrp,
        finance_assigned: this.editItem.selectFinance,
        first_name: this.editItem.first_name,
        last_name: this.editItem.last_name,
        email: this.editItem.email,
        password: this.editItem.password,
        regularization_date: this.editItem.regularization_date,
        password_confirmation: this.editItem.confirm_password,
        department: this.editItem.department,
        shift_time: this.editItem.shift_time,
        gender: this.editItem.gender,
        allowed_leave_number: this.editItem.allowed_leave_number,
        company_position: this.editItem.company_position,
        date_hired: this.editItem.date_hired,
        company_status: this.editItem.company_status,
        birthday: this.editItem.birthday,
        company_number: this.editItem.company_number
      };
      this.$axios
        .post("http://localhost:8000/hr/manage/user/" + this.editItem.id, params)
        .then(response => {
          this.retrieve()
        });
      this.dialog = false;
    },
    close() {
      this.dialog = false;
    },
    deleteItem(item) {
      this.id = item.id;
      this.$refs.confirmDel.show(item);
    },
    confirmDel() {
      this.$axios
        .delete("http://localhost:8000/hr/manage/user/" + this.id)
        .then(response => {
          this.retrieve();
        });
    },
    save(date) {
      this.$refs.menu.save(date);
    }
    //End
    // seeItem(item) {
    //   this.showModal = true;
    // }
  }
};
</script>