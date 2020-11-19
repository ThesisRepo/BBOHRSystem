<template>
  <div justify="center">
    <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="light blue darken-2"
          rounded
          outlined
          dark
          v-bind="attrs"
          v-on="on"
        >
          <v-icon>mdi-plus</v-icon>
          <v-toolbar-title style="font-size: 16px">View User</v-toolbar-title>
        </v-btn>
      </template>
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="dialog = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title>View User</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>
        <br>
        <br>
        <v-container class="primary fill-height">
              <v-card class="mx-auto" max-width="1200">
                <v-card-text class="display-1.8 text--primary" style="padding:5px!important; margin-left: 5%;">
                  <b>Personal Information:</b>
                </v-card-text>
                <v-divider></v-divider>
                <div style="margin-left: 10%; margin-right: 10%">
                  <v-row>
                    <v-col cols="12" md="4">
                      <v-text-field
                        class="input-name"
                        v-model="first_name"
                        label="Firstname"
                        prepend-icon="mdi-account"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                      <v-text-field
                        class="input-name"
                        v-model="last_name"
                        label="Lastname"
                        prepend-icon="mdi-account"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                      <v-text-field
                        class="input-name"
                        v-model="contact_number"
                        label="Contact Number"
                        prepend-icon="mdi-phone"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                      <v-text-field
                        class="input-name"
                        v-model="address"
                        label="Address"
                        prepend-icon="mdi-home"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                      <v-select
                        :items="['Female', 'Male']"
                        label="Gender*"
                        v-model="gender"
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
                        v-model="email"
                        label="Email"
                        prepend-icon="mdi-account"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="3">
                      <v-text-field
                        class="input-name"
                        v-model="password"
                        type="password"
                        label="Password"
                        prepend-icon="mdi-key"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="3">
                      <v-text-field
                        class="input-name"
                        v-model="confirm_password"
                        type="password"
                        label="Confirm Password"
                        prepend-icon="mdi-key"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="3">
                      <v-text-field
                        class="input-name"
                        v-model="company_number"
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
                            v-model="regularization_date"
                            label="Regularization Date"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker v-model="regularization_date" no-title scrollable color="primary"></v-date-picker>
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
                        v-model="company_status"
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
                        v-model="company_position"
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
                        v-model="selectPrp"
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
                        v-model="selectFinance"
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
                        v-model="department"
                        required
                        ></v-select>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-select
                        :items="sTime"
                        label="Shift Time*"
                        item-text="shift_time_name"
                        item-value="id"
                        v-model="shift_time"
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
                            v-model="date_hired"
                            label="Date Hired"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker v-model="date_hired" no-title scrollable color="primary"></v-date-picker>
                        </v-menu>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field
                        class="input-name"
                        v-model="allowed_leave_number"
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
                        v-model="pag_ibig_number"
                        label="Pag-ibig No."
                        prepend-icon="mdi-credit-card"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="3">
                        <v-text-field
                        class="input-name"
                        v-model="sss_number"
                        label="SSS No."
                        prepend-icon="mdi-credit-card"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="3">
                        <v-text-field
                        class="input-name"
                        v-model="tin_number"
                        label="TIN"
                        prepend-icon="mdi-credit-card"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="3">
                        <v-text-field
                        class="input-name"
                        v-model="philhealth_number"
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
  </div>
</template>
<script>
export default {
  data: () => ({
    dialog: false,
    selectPrp: null,
    prp: null,
    finance: null,
    selectFinance: null,
    sTime: null,
    //end
    error: false,
    address: null,
    civil_status: null,
    contact_number: null,
    pag_ibig_number: null,
    regularization_date: null,
    sss_number: null,
    tin_number: null,
    philhealth_number: null,
    prp_assigned: null,
    finance_assigned: null,
    first_name: null,
    last_name: null,
    email: null,
    allowed_leave_number: null,
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
    menu: false
  }),
  mounted() {
    // this.getAllPrp()
    this.getAllFinance();
  },
  methods: {
    getAllPrp() {
      this.$axios
        .get("prp/" + this.user_id)
        .then(response => {
          console.log(response.data);
          this.prp = response.data;
        });
    },
    getAllFinance() {
      this.$axios
        .get("finance/" + this.user_id)
        .then(response => {
          this.finance = response.data;
        });
    },
    getShift() {
      this.$axios.get("shift_time").then(response => {
        console.log("hi", response);
        this.sTime = response.data;
      });
    },
    //end
    save(date) {
      this.$refs.menu.save(date);
    },
    editItem(item){
    },
    update() {
      // if (
      //   this.address === null &&
      //   this.civil_status === null &&
      //   this.contact_number === null &&
      //   this.pag_ibig_number === null &&
      //   this.sss_number === null &&
      //   this.tin_number === null &&
      //   this.philhealth_number === null &&
      //   this.prp_assigned === null &&
      //   this.finance_assigned === null &&
      //   this.first_name === null &&
      //   this.last_name === null &&
      //   this.email === null &&
      //   this.password === null &&
      //   this.department === null &&
      //   this.shift_time === null &&
      //   this.allowed_leave_number === null &&
      //   this.gender === null &&
      //   this.company_position === null &&
      //   this.date_hired === null &&
      //   this.company_status === null &&
      //   this.birthday === null &&
      //   this.company_number === null &&
      //   this.confirm_password === null
      // ){
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
        regularization_date: this.regularization_date,
        password_confirmation: this.confirm_password,
        department: this.department,
        shift_time: this.shift_time,
        gender: this.gender,
        allowed_leave_number: this.allowed_leave_number,
        company_position: this.company_position,
        date_hired: this.date_hired,
        company_status: this.company_status,
        birthday: this.birthday,
        company_number: this.company_number
      };
      this.$axios
        .post("hr/manage/user", params)
        .then(response => {
          this.$parent.$parent.$parent.$parent.$parent.$parent.retrieve()
        });
    }
  }
};
</script>
