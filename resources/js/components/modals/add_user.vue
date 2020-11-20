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
          @click="removeData()"
        >
          <v-icon>mdi-plus</v-icon>
          <v-toolbar-title style="font-size: 16px">New User</v-toolbar-title>
        </v-btn>
      </template>
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="dialog = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title>New User</v-toolbar-title>
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
                  <i>
                    <span
                      v-if="errorMessage1 !== null"
                      class="text-danger text-center"
                    >{{ errorMessage1 }}</span>
                  </i>
                  <i>
                    <span
                      v-if="errorMessage2 !== null"
                      class="text-danger text-center"
                    >{{ errorMessage2 }}</span>
                  </i>
                  <v-text-field
                    class="input-name"
                    v-model="first_name"
                    label="Firstname"
                    @keyup="validate('firstname')"
                    type="text"
                    prepend-icon="mdi-account"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                  <i>
                    <span
                      v-if="errorMessage3 !== null"
                      class="text-danger text-center"
                    >{{ errorMessage3 }}</span>
                  </i>
                  <i>
                    <span
                      v-if="errorMessage4 !== null"
                      class="text-danger text-center"
                    >{{ errorMessage4 }}</span>
                  </i>
                  <v-text-field
                    class="input-name"
                    v-model="last_name"
                    label="Lastname"
                    @keyup="validate('lastname')"
                    prepend-icon="mdi-account"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                  <i>
                    <span
                      v-if="errorMessage5 !== null"
                      class="text-danger text-center"
                    >{{ errorMessage5 }}</span>
                  </i>
                  <i>
                    <span
                      v-if="errorMessage6 !== null"
                      class="text-danger text-center"
                    >{{ errorMessage6 }}</span>
                  </i>
                  <v-text-field
                    class="input-name"
                    v-model="contact_number"
                    label="Contact Number"
                    @keyup="validate('contact_number')"
                    prepend-icon="mdi-phone"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                  <i>
                    <span
                      v-if="errorMessage7 !== null"
                      class="text-danger text-center"
                    >{{ errorMessage7 }}</span>
                  </i>
                  <v-text-field
                    class="input-name"
                    v-model="address"
                    label="Address"
                    @keyup="validate('address')"
                    prepend-icon="mdi-home"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                  <v-select
                    :items="genderItem"
                    item-text="text"
                    item-value="value"
                    label="Gender*"
                    @keyup="validate('gender')"
                    v-model="gender"
                    prepend-icon="mdi-gender-male-female"
                    required
                  ></v-select>
                </v-col>
                <v-col cols="12" md="4">
                  <v-menu
                    ref="menu"
                    v-model="menu"
                    :close-on-content-click="false"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                        v-model="birthday"
                        label="Birthday Date"
                        prepend-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                      ></v-text-field>
                    </template>
                    <v-date-picker
                      ref="picker"
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
                  <i>
                    <span
                      v-if="errorMessage8 !== null"
                      class="text-danger text-center"
                    >{{ errorMessage8 }}</span>
                  </i>
                  <v-text-field
                    class="input-name"
                    v-model="email"
                    label="Email"
                    @keyup="validate('email')"
                    prepend-icon="mdi-account"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                  <span
                    v-if="successMessage !== null"
                    class="text-success text-center"
                  >{{ successMessage }}</span>
                  <i>
                    <span
                      v-if="errorMessage9 !== null"
                      class="text-danger text-center"
                    >{{ errorMessage9 }}</span>
                  </i>
                  <i>
                    <span
                      v-if="errorMessage10 !== null"
                      class="text-danger text-center"
                    >{{ errorMessage10 }}</span>
                  </i>
                  <v-text-field
                    class="input-name"
                    v-model="password"
                    type="password"
                    label="Password"
                    @keyup="validate('password')"
                    prepend-icon="mdi-key"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                  <span
<<<<<<< HEAD
                    v-if="errorMessage6 !== null"
                    class="text-danger text-center"
                  >{{ errorMessage6 }}</span>
                </i>
                <v-text-field label="Contact Number*" @keyup="validate('contact_number')" v-model="contact_number" dense required></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="3">
                <v-select
                  :items="genderItem"
                  item-text="text"
                  item-value="value"
                  label="Gender*"
                  @keyup="validate('gender')"
                  v-model="gender"
                  dense
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" sm="6" md="3">
                <v-menu
                  ref="menu"
                  v-model="menu"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  min-width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="birthday"
                      label="Birthday*"
                      readonly
                      dense
                      v-bind="attrs"
                      v-on="on"
                      required
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    ref="picker"
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
              <!-- Firstname, Lastname, Contact Number, Address, Gender, Birthday, Email, Password, Confirm -->
              <v-col cols="12" sm="6" md="6">
                <v-text-field label="Address*" v-model="address" dense required></v-text-field>
              </v-col>
              <!-- End --------------------------------------------------->
              <v-col cols="12" sm="6" md="4">
                <v-text-field label="Email*" type="email" v-model="email" dense required></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field label="Password*" type="password" v-model="password" dense required></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  label="Confirm Password*"
                  type="password"
                  v-model="confirm_password"
                  dense
                  required
                ></v-text-field>
              </v-col>
              <!-- <v-col cols="12" sm="6">
                <v-autocomplete
                  :items="['Skiing', 'Ice hockey', 'Soccer', 'Basketball', 'Hockey', 'Reading', 'Writing', 'Coding', 'Basejump']"
                  label="Interests"
                  multiple
                ></v-autocomplete>
              </v-col>-->
            </v-row>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">Cancel</v-btn>
          <v-btn color="blue darken-1" text @click="addNew()">Save</v-btn>
        </v-card-actions>
=======
                    v-if="successMessage !== null"
                    class="text-success text-center"
                  >{{ successMessage }}</span>
                  <i>
                    <span
                      v-if="errorMessage11 !== null"
                      class="text-danger text-center"
                    >{{ errorMessage11 }}</span>
                  </i>
                  <v-text-field
                    class="input-name"
                    v-model="confirm_password"
                    type="password"
                    @keyup="validate('confirm_password')"
                    label="Confirm Password"
                    prepend-icon="mdi-key"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                  <i>
                    <span
                      v-if="errorMessage12 !== null"
                      class="text-danger text-center"
                    >{{ errorMessage12 }}</span>
                  </i>
                  <i>
                    <span
                      v-if="errorMessage13 !== null"
                      class="text-danger text-center"
                    >{{ errorMessage13 }}</span>
                  </i>
                  <v-text-field
                    class="input-name"
                    v-model="company_id"
                    label="Company ID"
                    @keyup="validate('company_id')"
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
                    <v-date-picker
                      v-model="regularization_date"
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
                    v-model="company_status"
                    @keyup="validate('company_status')"
                    required
                  ></v-select>
                </v-col>
                <v-col cols="12" md="4">
                  <v-select
                    :items="position"
                    item-text="position_name"
                    item-value="id"
                    label="Company Position*"
                    v-model="company_position"
                    @keyup="validate('company_position')"
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
                    @keyup="validate('prp_assign')"
                    prepend-icon="mdi-account"
                    required
                  ></v-select>
                </v-col>
                <v-col cols="12" md="4">
                  <v-select
                    :items="finance"
                    label="Finance Assign"
                    prepend-icon="mdi-account"
                    @keyup="validate('finance_assign')"
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
                <!-- *****************Start -->
                <v-col cols="12" md="4">
                  <v-select
                    :items="departmentItem"
                    item-text="department_name"
                    item-value="id"
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
                  <i>
                    <span
                      v-if="errorMessage14 !== null"
                      class="text-danger text-center"
                    >{{ errorMessage14 }}</span>
                  </i>
                  <i>
                    <span
                      v-if="errorMessage15 !== null"
                      class="text-danger text-center"
                    >{{ errorMessage15 }}</span>
                  </i>
                  <i>
                    <span
                      v-if="errorMessage16 !== null"
                      class="text-danger text-center"
                    >{{ errorMessage16 }}</span>
                  </i>
                  <v-text-field
                    class="input-name"
                    v-model="allowed_leave_number"
                    label="Allowed Leave No."
                    prepend-icon="mdi-number"
                    type="number"
                    @keyup="validate('allowed_leave_number')"
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
                  <v-btn color="primary" @click="addNew(), (dialog = false)">Save</v-btn>
                </v-col>
              </v-row>
            </div>
          </v-card>
        </v-container>
>>>>>>> 2d2bf85d36163fcfe2fd12430a05530d3214e892
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
export default {
  data: () => ({
    departmentItem: [],
    birthday: null,
    menu: false,
    dialog: false,
    selectPrp: null,
    prp: null,
    finance: null,
    selectFinance: null,
    sTime: null,
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
    allowed_leave_number: null,
    department: null,
    shift_time: null,
    gender: null,
    company_position: null,
    date_hired: null,
    company_status: null,
    company_id: null,
    password: "",
    confirm_password: "",
    rules: {
      required: value => !!value || "Required",
      min: v => v.length >= 8 || "Minumum of 8 characters",
      emailMatch: () => "The email and password you entered don't match"
    },

    genderItem: [{ text: "Female", value: 0 }, { text: "Male", value: 1 }],
    successMessage: null,
    errorMessage1: null,
    errorMessage2: null,
    errorMessage3: null,
    errorMessage4: null,
    errorMessage5: null,
    errorMessage6: null,
    errorMessage7: null,
    errorMessage8: null,
    errorMessage9: null,
    errorMessage10: null,
    errorMessage11: null,
    errorMessage12: null,
    errorMessage13: null,
    errorMessage14: null,
    errorMessage15: null,
    errorMessage16: null,
    email: "",
    position: []
  }),
  mounted() {
    this.getAllPrp();
    this.getAllFinance();
    this.getShift();
    this.getAllDepartment()
    this.getPosition()
  },
  watch: {
    menu(val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
    }
  },
  methods: {
    getAllPrp() {
      this.$axios.get("http://localhost:8000/prp").then(response => {
        this.prp = response.data;
      });
    },
    getAllFinance() {
      this.$axios.get("http://localhost:8000/finance").then(response => {
        this.finance = response.data;
      });
    },
    getAllDepartment() {
      this.$axios.get("http://localhost:8000/departments").then(response => {
        response.data.forEach(element => {
          this.departmentItem.push(element)
        })
      });
    },
    getShift() {
      this.$axios.get("http://localhost:8000/shift_time").then(response => {
        this.sTime = response.data;
      });
    },

    getPosition(){
      this.$axios.get("http://localhost:8000/hr/company_position").then(response => {
        response.data.forEach(el => {
          this.position.push(el)
        })
      })
    },
    //end
    save(birthday) {
      this.$refs.menu.save(birthday);
    },

    validate(input) {
      this.successMessage = null;
      let reqWhiteSpace = /\d/;
      let specialChar = /^[A-Za-z0-9 ]+$/;
      if (input === "firstname" || input === "lastname") {
        // this.errorMessage1 = null;
        if (
          reqWhiteSpace.test(this.first_name) ||
          reqWhiteSpace.test(this.last_name)
        ) {
          if (input === "firstname") {
            this.errorMessage1 = "firstname should not contain a number.";
          } else {
            this.errorMessage3 = "lastname should not contain a number.";
          }
        } else if (this.first_name === "") {
          if (input === "firstname") {
            this.errorMessage2 = "firstname is required.";
          } else {
            this.errorMessage4 = "lastname is required.";
          }
        } else if (
          !specialChar.test(this.first_name) ||
          !specialChar.test(this.last_name)
        ) {
          if (input === "firstname") {
            this.errorMessage2 =
              "firstname should not contain a special character.";
          } else {
            this.errorMessage4 =
              "lastname should not contain a special character.";
          }
        } else {
          this.errorMessage1 = null;
          this.errorMessage2 = null;
          this.errorMessage3 = null;
          this.errorMessage4 = null;
        }
      } else if (input === "contact_number") {
        this.errorMessage5 = null;
        this.successMessage6 = null;
        if (this.contact_number.length > 11) {
          this.errorMessage5 = "Contact number must not exceed 11 numbers";
        } else if (this.contact_number.slice(0, 2) != "09") {
          this.errorMessage6 = "Contact number must start with 09";
        } else {
          this.errorMessage5 = null;
          this.errorMessage6 = null;
        }
      } else if (input === "address") {
        this.errorMessage7 = null;
        if (this.address === "") {
          this.errorMessage7 = "Address is required";
        } else {
          this.errorMessage7 = null;
        }
      } else if (input === "email") {
        this.errorMessage8 = null;
        if (this.validateEmail(this.email) === false) {
          this.errorMessage8 = "You have entered an invalid email address.";
        } else {
          this.errorMessage8 = null;
        }
      } else if (input === "password") {
        console.log("password");
        this.errorMessage9 = null;
        if (this.password.length < 8) {
          this.errorMessage9 = " Password must be atleast 8 characters.";
        } else if (
          /^.*(?=.{8,})((?=.*[!@#$%^&*()\-_=+{};:,<.>]){1})(?=.*\d)((?=.*[a-z]){1})((?=.*[A-Z]){1}).*$/.test(
            this.password
          )
        ) {
          this.successMessage = "Strong password";
          this.errorMessage9 = null;
          this.errorMessage10 = null;
        } else {
          this.errorMessage10 =
            "Password must be alphanumeric characters. It should contain 1 number, 1 special character and 1 capital letter";
        }
      } else if (input === "confirm_password") {
        this.errorMessage11 = null;
        this.successMessage = null;
        if (this.password.localeCompare(this.confirm_password) !== 0) {
          this.errorMessage11 = "Password did not match";
        } else {
          this.errorMessage11 = null;
        }
      // } else if (input === "company_id") {
      //   this.errorMessage12 = null;
      //   this.errorMessage13 = null;
      //   if (this.company_id.length < 8) {
      //     this.errorMessage12 = "ID number is invalid.";
      //   } else {
      //     this.errorMessage13 =
      //       "ID number must be 8 numbers or 2 letters followed by 6 numbers";
      //   }
      } else if (input === "allowed_leave_number") {
        if (this.allowed_leave_number > 7) {
          this.errorMessage14 = "Leave Request must not exceed to 7 days";
        } else if (this.allowed_leave_number <= 0) {
          this.errorMessage15 = "Invalid number of leave";
        } else {
          this.errorMessage14 = null;
          this.errorMessage15 = null;
          this.errorMessage16 = null;
        }
      }
    },
    validateEmail(email) {
      let reg = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)+.[a-zA-Z0-9]*$/;
      if (reg.test(email) === false) {
        return false;
      } else {
        return true;
      }
    },

    addNew() {
      console.log("sdfasdf", this.gender);
      this.validate("firstname");
      // if(
      //   this.errorMessage1 === null &&
      //   this.errorMessage2 === null
      // )
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
        .post("http://localhost:8000/hr/manage/user", params)
        .then(response => {
          console.log(response.data)
          this.$parent.$parent.$parent.$parent.$parent.$parent.retrieve();
        });
    },

    removeData() {
      (this.address = null),
        (this.civil_status = null),
        (this.contact_number = null),
        (this.pag_ibig_number = null),
        (this.sss_number = null),
        (this.tin_number = null),
        (this.philhealth_number = null),
        (this.prp_assigned = null),
        (this.finance_assigned = null),
        (this.first_name = null),
        (this.last_name = null),
        (this.email = null),
        (this.password = null),
        (this.department = null),
        (this.shift_time = null),
        (this.regularization_date = null),
        (this.allowed_leave_number = null),
        (this.gender = null),
        (this.company_position = null),
        (this.date_hired = null),
        (this.company_status = null),
        (this.birthday = null),
        (this.company_number = null),
        (this.confirm_password = null);
    }
  }
};
</script>
