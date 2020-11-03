<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="light blue darken-2"
          rounded
          outlined
          dark
          v-bind="attrs"
          v-on="on"
          @click="removeData()"
        >
          <v-icon>mdi-plus</v-icon>
          <v-toolbar-title style="font-size: 16px">Add New User</v-toolbar-title>
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">New User</span>
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" md="3">
                <v-text-field label="Firstname*" v-model="first_name" required></v-text-field>
              </v-col>
              <v-col cols="12" md="3">
                <v-text-field label="Lastname*" v-model="last_name" required></v-text-field>
              </v-col>
              <v-col cols="12" md="3">
                <v-text-field label="Email*" v-model="email" type="email" required></v-text-field>
              </v-col>
              <v-col cols="12" md="3">
                <v-text-field label="Password*" v-model="password" type="password" required></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field label="Confirm Password*" v-model="confirm_password" type="password" required></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field label="Address*" v-model="address" required></v-text-field>
              </v-col>
              <v-col cols="12" md="3">
                <v-select
                  :items="['Female', 'Male']"
                  label="Department*"
                  v-model="department"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" md="3">
                <v-menu
                    ref="menu"
                    v-model="menu"
                    :close-on-content-click="true"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                >
                    <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                        v-model="birthday"
                        label="Birthday"
                        prepend-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                    ></v-text-field>
                    </template>
                    <v-date-picker
                    v-model="birthday"
                    :max="new Date().toISOString().substr(0, 10)"
                    min="1950-01-01"
                    @change="save"
                    ></v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="12" md="3">
                <v-menu
                  :close-on-content-click="true"
                  transition="scale-transition"
                  offset-y
                  min-width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="date_hired"
                      label="Date Hired"
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="date_hired"
                    no-title
                    scrollable
                    color="primary"
                  ></v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="12" md="3">
                <v-text-field label="Company Number*" v-model="company_number" required></v-text-field>
              </v-col>
              <v-col cols="12" md="3">
                <v-text-field label="Contact No.*" v-model="contact_number" type="number" required></v-text-field>
              </v-col>
              <v-col cols="12" md="3">
                <v-select
                  :items="['Female', 'Male']"
                  label="Gender*"
                  v-model="gender"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" md="3">
                <v-select
                  :items="['single', 'Married', 'Widowed', 'Single-Parent']"
                  label="Shift Time*"
                  v-model="shift_time"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" md="3">
                <v-select
                  :items="['Female', 'Male']"
                  label="Company Position*"
                  v-model="company_position"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" md="3">
                <v-select
                  :items="['single', 'Married', 'Widowed', 'Single-Parent']"
                  label="Prp Assign*"
                  v-model="prp_assigned"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" md="3">
                <v-select
                  :items="['single', 'Married', 'Widowed', 'Single-Parent']"
                  label="Finance Assign*"
                  v-model="finance_assigned"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" md="3">
                <v-select
                  :items="['single', 'Married', 'Widowed', 'Single-Parent']"
                  label="Civil Status*"
                  v-model="civil_status"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" md="3">
                <v-select
                  :items="['Probationary', 'Regular', 'OJT']"
                  label="Company Status*"
                  v-model="company_status"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" md="3">
                <v-text-field label="PagIbig No.*" v-model="pag_ibig_number" required></v-text-field>
              </v-col>
              <v-col cols="12" md="3">
                <v-text-field label="SSS No.*" v-model="sss_number" required></v-text-field>
              </v-col>
              <v-col cols="12" md="3">
                <v-text-field label="Tin No.*" v-model="tin_number" required></v-text-field>
              </v-col>
              <v-col cols="12" md="3">
                <v-text-field label="PhilHealth No.*" v-model="philhealth_number" required></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
          <v-btn color="blue darken-1" text @click="addNew(), dialog = false">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
export default {
  data: () => ({
    dialog: false,
    address: null,
    civil_status: null,
    contact_number: null,
    pag_ibig_number: null,
    sss_number: null,
    tin_number: null,
    philhealth_number: null,
    prp_assigned: null,
    finance_assigned: null,
    first_name: null,
    last_name: null,
    email: null,
    password: null,
    department: null,
    shift_time: null,
    gender: null,
    company_position: null,
    date_hired: null,
    company_status: null,
    birthday: null,
    company_number: null,
    confirm_password: null,
    menu: false,
    }),
  // watch: {
  //   menu (val) {
  //   val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
  //   },
  // },
  methods: {
    save (date) {
    this.$refs.menu.save(date)
    },
    addNew() {
      // if (
      //   this.datas.address === null &&
      //   this.datas.civil_status === null &&
      //   this.datas.contact_number === null &&
      //   this.datas.pag_ibig_number === null &&
      //   this.datas.sss_number === null &&
      //   this.datas.tin_number === null &&
      //   this.datas.philhealth_number === null
      // ) {
      //   e.preventDefault();
      // }
      let params = {
        address: this.address,
        civil_status: this.civil_status,
        contact_number: this.contact_number,
        pag_ibig_number: this.pag_ibig_number,
        sss_number: this.sss_number,
        tin_number: this.tin_number,
        philhealth_number: this.philhealth_number,
        prp_assigned: this.prp_assigned,
        finance_assigned: this.finance_assigned,
        first_name: this.first_name,
        last_name: this.last_name,
        email: this.email,
        password: this.password,
        password_confirmation: this.confirm_password,
        department: this.department,
        shift_time: this.shift_time,
        gender: this.gender,
        company_position: this.company_position,
        date_hired: this.date_hired,
        company_status: this.company_status,
        birthday: this.birthday,
        company_number: this.company_number,

      };
      this.$axios
        .post(
          "http://localhost:8000/hr/manage/user",
          params
        )
        .then(response => {
          console.log(response.data)
        });
      // .catch(error => {
      //   this.dialog = false;
      // });
    },
    removeData(){
      this.address = null,
      this.civil_status =  null,
      this.contact_number = null,
      this.pag_ibig_number = null,
      this.sss_number = null,
      this.tin_number = null,
      this.philhealth_number = null,
      this.prp_assigned = null,
      this.finance_assigned = null,
      this.first_name = null,
      this.last_name = null,
      this.email = null,
      this.password = null,
      this.department = null,
      this.shift_time = null,
      this.gender = null,
      this.company_position = null,
      this.date_hired = null,
      this.company_status = null,
      this.birthday = null,
      this.company_number = null,
      this.confirm_password = null
    }
  }
};
</script>
