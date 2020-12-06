<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="primary" rounded large outlined dark v-bind="attrs" @click="clearError()" v-on="on">
          <v-icon left>mdi-pencil</v-icon>Edit Profile
        </v-btn>
      </template>
      <v-card>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat>
          <v-card-title>
            <span class="headline">EDIT PROFILE</span>
          </v-card-title>
        </v-toolbar>
        <v-card-text>
          <v-container>
            <span v-if="error" style="color: red; font-style: italic">All data are required!</span>
            <v-row>
              <v-col cols="12" md="6">
                <v-text-field
                  class="input-name"
                  label="First Name*"
                  v-model="datum.first_name"
                  @keyup="validate('first_name')"
                  required
                ></v-text-field>
                <span
                  class="ml-2"
                  v-if="errorMessage1 !== null"
                  style="color: red; font-size: 12px"
                >{{ errorMessage1 }}</span>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field
                  class="input-name"
                  label="Last Name*"
                  v-model="datum.last_name"
                  @keyup="validate('last_name')"
                  required
                ></v-text-field>
                <span
                  class="ml-2"
                  v-if="errorMessage2 !== null"
                  style="color: red; font-size: 12px"
                >{{ errorMessage2 }}</span>
              </v-col>
              <v-col cols="12" md="6">
                <v-select
                    :items="civilItem"
                    item-text="text"
                    item-value="value"
                    label="Civil Status*"
                    @keyup="validate('civil_status')"
                    v-model="datas.civil_status_id"
                    required
                ></v-select>
                <span
                  v-if="errorMessage3 !== null"
                  style="color: red; font-size: 12px"
                >{{ errorMessage3 }}</span>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field
                  label="Contact No.*"
                  type="number"
                  v-model="datas.contact_number"
                  @keyup="validate('contact_number')"
                  required
                ></v-text-field>
                <span
                  v-if="errorMessage5 !== null"
                  style="color: red; font-size: 12px"
                >{{ errorMessage5 }}</span>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  class="input-name"
                  label="Address*"
                  v-model="datas.address"
                  @keyup="validate('address')"
                  required
                ></v-text-field>
                <span
                  class="ml-2"
                  v-if="errorMessage4 !== null"
                  style="color: red; font-size: 12px"
                >{{ errorMessage4 }}</span>
              </v-col>
              <v-divider></v-divider>
              <div><v-btn depressed color="primary" @click="showP()" v-if="showPass === true">Manage Password</v-btn></div>
              <v-row v-if="seen === false">
                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="datas.password"
                    prepend-icon="mdi-lock"
                    label="New Password*"
                    :append-icon="
                      value ? 'mdi-eye' : 'mdi-eye-off'
                    "
                    :type="value ? 'password' : 'text'"
                    @keyup="validate('password')"
                    dense
                    required
                    @click:append="() => (value = !value)"
                  ></v-text-field>
                  <span
                    class="ml-8"
                    v-if="errorMessage6 !== null"
                    style="color: red; font-size: 12px"
                  >{{ errorMessage6 }}</span>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field
                    label="Confirm Password"
                    :append-icon="
                      valuePass ? 'mdi-eye' : 'mdi-eye-off'
                    "
                    @click:append="
                      () => (valuePass = !valuePass)
                    "
                    :type="valuePass ? 'password' : 'text'"
                    @keyup="validate('confirm_password')"
                    name="password"
                    prepend-icon="mdi-lock"
                    v-model="datas.confirm_password"
                    dense
                    required
                  ></v-text-field>
                  <span
                    class="ml-8"
                    v-if="errorMessage7 !== null"
                    style="color: red; font-size: 12px"
                  >{{ errorMessage7 }}</span>
                </v-col>
              </v-row>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red" dark @click="dialog = false">Cancel</v-btn>
          <v-btn color="success" dark @click="confirm()">Update</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <Confirmation
      ref="confirm"
      :title="'Confirmation'"
      :message="'Are you sure you want to update ?'"
      @onConfirm="update($event)"
    ></Confirmation>
  </v-row>
</template>
<script>
import Confirmation from "../modals/confirmation/confirmation.vue";
export default {
  data: () => ({
    dialog: false,
    error: false,
    errorMessage: null,
    errorMessage1: null,
    errorMessage2: null,
    errorMessage3: null,
    errorMessage4: null,
    errorMessage5: null,
    errorMessage6: null,
    errorMessage7: null,
    successMessage: null,
    valuePass: false,
    showPass: true,
    seen: true,
    value: true,
    civil_status: null,
    user_id: localStorage.getItem("id"),
    civilItem: [
      { text: "Single", value: 0 },
      { text: "Married", value: 1 },
      { text: "Widow", value: 2 }
    ]
  }),
  props: ["datas", "datum"],
  components: {
    Confirmation
  },
  methods: {
    confirm(){
      // if(this.datas.address != null &&
      //   this.datas.civil_status != null &&
      //   this.datas.contact_number != null &&
      //   this.datas.first_name != null &&
      //   this.datas.last_name != null &&
      //   this.errorMessage1 === null &&
      //   this.errorMessage2 === null &&
      //   this.errorMessage3 === null &&
      //   this.errorMessage4 === null &&
      //   this.errorMessage5 === null &&
      //   this.errorMessage6 === null &&
      //   this.errorMessage7 === null){
          this.$refs.confirm.show()
        // }else{
          // this.error = true
          // this.dialog = true
        // }
    },
    clearError(){
      this.errorMessage =  null
      this.errorMessage1 =  null
      this.errorMessage2 =  null
      this.errorMessage3 =  null
      this.errorMessage4 =  null
      this.errorMessage5 =  null
      this.errorMessage6 =  null
      this.errorMessage7 =  null
      this.successMessage = null
    },
    showP(){
      this.seen = false
    },
    validate(input) {
      let reqWhiteSpace = /\d/;
      let specialChar = /^[A-Za-z0-9 ]+$/;
      let numberExclude = /^[0-9 ]+$/;
      if (input === "first_name") {
        this.errorMessage1 = null;
        if (this.datum.first_name === "") {
          this.errorMessage1 = "First name is Required";
        } else {
          this.errorMessage1 = null;
        }
      }else if (input === "last_name") {
        this.errorMessage2 = null;
        if (this.datum.last_name === "") {
          this.errorMessage2 = "Last name is Required";
        } else {
          this.errorMessage2 = null;
        }
      }else if (input === "civil_status") {
        this.errorMessage3 = null;
        if (this.datas.civil_status_id === "" || this.datas.civil_status_id === null) {
          this.errorMessage3 = "Last name is Required";
        } else {
          this.errorMessage3 = null;
        }
      }else if (input === "address") {
        this.errorMessage4 = null;
        if (this.datas.address === "") {
          this.errorMessage4 = "Address is Required";
        } else {
          this.errorMessage4 = null;
        }
      }
      if (input === "contact_number") {
        this.errorMessage5 = null;
        if(this.datas.contact_number === '' || this.datas.contact_number === null){
          this.errorMessage5 = "Contact number is required";
        }else if (this.datas.contact_number.length > 11) {
          this.errorMessage5 = "Contact Number is exceed 11 numbers";
        } else if (this.datas.contact_number.length === 0) {
          this.errorMessage5 = "Contact number is required";
        } else if (this.datas.contact_number.slice(0, 2) != "09") {
          this.errorMessage5 = "Contact number must start with 09";
        } else if (this.datas.contact_number.length <= 10) {
          this.errorMessage5 = "Contact number is invalid";
        } else {
          this.errorMessage5 = null;
        }
      }
      if (input === "password") {
        this.errorMessage6 = null;
        if(this.datas.password === '' || this.datas.password === null){
          this.errorMessage6 = "Password is required";
        }else if (this.datas.password.length < 8) {
          this.errorMessage6 = "Password must be atleast 8 characters.";
        } else if (
          /^.*(?=.{8,})((?=.*[!@#$%^&*()\-_=+{};:,<.>]){1})(?=.*\d)((?=.*[a-z]){1})((?=.*[A-Z]){1}).*$/.test(
            this.datas.password
          )
        ) {
          this.successMessage = "Strong password";
          this.errorMessage6 = null;
        } else {
          this.errorMessage6 =
            "Password must be alphanumeric characters. It should contain 1 number, 1 special character and 1 capital letter";
        }
      } else if (input === "confirm_password") {
        this.errorMessage7 = null;
        if(this.datas.confirm_password === '' || this.datas.confirm_password === null){
          this.errorMessage6 = "Confirm password is required";
        }else if (this.datas.password.localeCompare(this.datas.confirm_password) !== 0) {
          this.errorMessage7 = "Password did not match";
        } else {
          this.errorMessage7 = null;
        }
      }
    },
    update() {
      this.validate("address");
      this.validate("contact_number");
      this.validate("first_name");
      this.validate("last_name");
      this.validate("civil_status");
      if (
        this.datas.address != null &&
        this.datas.civil_status != null &&
        this.datas.contact_number != null &&
        this.datas.first_name != null &&
        this.datas.last_name != null &&
        this.errorMessage1 === null &&
        this.errorMessage2 === null &&
        this.errorMessage3 === null &&
        this.errorMessage4 === null &&
        this.errorMessage5 === null &&
        this.errorMessage6 === null &&
        this.errorMessage7 === null
      ) {
        this.dialog = true;
        e.preventDefault();
        let params = {
          address: this.datas.address,
          civil_status: this.datas.civil_status,
          contact_number: this.datas.contact_number,
          pag_ibig_number: this.datas.first_name,
          sss_number: this.datas.last_name
        };
        this.$axios.post("user_info/" + this.user_id, params).then(response => {
          if (response.data === 1) {
            this.$parent.$parent.getInfo();
          } else {
            this.$parent.$parent.getInfo();
          }
        });
        this.dialog = false;
      }else{
        this.error = true
        this.dialog = true
      }
    }
  }
};
</script>