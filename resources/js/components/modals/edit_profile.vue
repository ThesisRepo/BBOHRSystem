<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="primary" rounded large outlined dark v-bind="attrs" v-on="on">
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
            <v-row>
              <v-col cols="12" sm="6" md="12">
                <v-text-field
                  class="input-name"
                  label="Address*"
                  v-model="datas.address"
                  @keyup="validate('datas.address')"
                  required
                ></v-text-field>
                <span
                  class="ml-2"
                  v-if="errorMessage1 !== null"
                  style="color: red; font-size: 12px"
                >{{ errorMessage1 }}</span>
              </v-col>
              <v-col cols="12" sm="6" md="12">
                <v-text-field
                  label="Contact No.*"
                  type="number"
                  v-model="datas.contact_number"
                  @keyup="validate('datas.contact_number')"
                  required
                ></v-text-field>
                <span
                  v-if="errorMessage2 !== null"
                  style="color: red; font-size: 12px"
                >{{ errorMessage2 }}</span>
                <span
                  v-if="errorMessage3 !== null"
                  style="color: red; font-size: 12px"
                >{{ errorMessage3 }}</span>
              </v-col>
              <!-- <div>Manage Password</div> -->
              <v-col cols="6">
                <v-text-field
                  v-model="datas.password"
                  prepend-icon="mdi-lock"
                  label="New Password*"
                  :append-icon="
                                        value ? 'mdi-eye' : 'mdi-eye-off'
                                    "
                  :type="value ? 'password' : 'text'"
                  @keyup="validate('datas.password')"
                  dense
                  required
                  @click:append="() => (value = !value)"
                ></v-text-field>
                <span
                  class="ml-8"
                  v-if="successMessage !== null"
                  style="color: green; font-size: 12px"
                >{{ successMessage }}</span>
                <span
                  class="ml-8"
                  v-if="errorMessage4 !== null"
                  style="color: red; font-size: 12px"
                >{{ errorMessage4 }}</span>
                <span
                  class="ml-8"
                  v-if="errorMessage5 !== null"
                  style="color: red; font-size: 12px"
                >{{ errorMessage5 }}</span>
              </v-col>
              <v-col cols="6">
                <v-text-field
                  label="Confirm Password"
                  :append-icon="
                                        valuePass ? 'mdi-eye' : 'mdi-eye-off'
                                    "
                  @click:append="
                                        () => (valuePass = !valuePass)
                                    "
                  :type="valuePass ? 'password' : 'text'"
                  @keyup="validate('datas.confirm_password')"
                  name="password"
                  prepend-icon="mdi-lock"
                  v-model="datas.confirm_password"
                  dense
                  required
                ></v-text-field>
                <span
                  class="ml-8"
                  v-if="errorMessage6 !== null"
                  style="color: red; font-size: 12px"
                >{{ errorMessage6 }}</span>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red" dark @click="dialog = false">Cancel</v-btn>
          <v-btn color="success" dark @click="update(), (dialog = false)">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
export default {
  data: () => ({
    dialog: false,
    errorMessage1: null,
    errorMessage2: null,
    errorMessage3: null,
    errorMessage4: null,
    errorMessage5: null,
    errorMessage6: null,
    successMessage: null,
    valuePass: true,
    value: true,
    user_id: localStorage.getItem("id"),
    civilItem: [
      { text: "Single", value: 0 },
      { text: "Married", value: 1 },
      { text: "Widow", value: 2 }
    ]
  }),
  props: ["datas"],

  methods: {
    validate(input) {
      let reqWhiteSpace = /\d/;
      let specialChar = /^[A-Za-z0-9 ]+$/;
      let numberExclude = /^[0-9 ]+$/;

      if (input === "datas.address") {
        this.errorMessage1 = null;
        if (this.datas.address === "") {
          this.errorMessage1 = "Address is Required";
        } else {
          this.errorMessage1 = null;
        }
      }

      if (input === "datas.contact_number") {
        this.errorMessage2 = null;
        this.errorMessage3 = null;
        if (this.datas.contact_number.length > 11) {
          this.errorMessage2 = "Contact Number is exceed 11 numbers";
        } else if (this.datas.contact_number.length === 0) {
          this.errorMessage2 = "Contact number is required";
        } else if (this.datas.contact_number.slice(0, 2) != "09") {
          this.errorMessage3 = "Contact number must start with 09";
        } else if (this.datas.contact_number.length <= 10) {
          this.errorMessage3 = "Contact number is invalid";
        } else {
          this.errorMessage2 = null;
          this.errorMessage3 = null;
        }
      }
      if (input === "datas.password") {
        this.errorMessage4 = null;
        this.errorMessage5 = null;
        if (this.datas.password.length < 8) {
          this.errorMessage4 = "Password must be atleast 8 characters.";
        } else if (
          /^.*(?=.{8,})((?=.*[!@#$%^&*()\-_=+{};:,<.>]){1})(?=.*\d)((?=.*[a-z]){1})((?=.*[A-Z]){1}).*$/.test(
            this.datas.password
          )
        ) {
          this.successMessage = "Strong password";
          this.errorMessage4 = null;
          this.errorMessage5 = null;
        } else {
          this.errorMessage5 =
            "Password must be alphanumeric characters. It should contain 1 number, 1 special character and 1 capital letter";
        }
      } else if (input === "datas.confirm_password") {
        this.errorMessage6 = null;
        this.successMessage = null;
        if (this.password.localeCompare(this.confirm_password) !== 0) {
          this.errorMessage6 = "Password did not match";
        } else {
          this.errorMessage6 = null;
          this.successMessage = null;
        }
      }
    },

    //     if (input === "datas.pag_ibig_number") {
    //         this.errorMessage4 = null;
    //         this.errorMessage5 = null;
    //         if (this.datas.pag_ibig_number.length > 12) {
    //             this.errorMessage4 =
    //                 "Pag-IBIG number must be 12 digit number";
    //         } else if (this.datas.pag_ibig_number.length === 0) {
    //             this.errorMessage4 = "Pag-IBIG number is required";
    //         } else if (this.datas.pag_ibig_number.length < 12) {
    //             this.errorMessage5 = "Pag-IBIG number is invalid ";
    //         } else {
    //             this.errorMessage4 = null;
    //             this.errorMessage5 = null;
    //         }
    //     }

    //     if (input === "datas.sss_number") {
    //         this.errorMessage6 = null;
    //         this.errorMessage7 = null;
    //         if (this.datas.sss_number.length > 10) {
    //             this.errorMessage6 = "SSS number must be 10 digit number";
    //         } else if (this.datas.sss_number.length === 0) {
    //             this.errorMessage6 = "SSS number is required";
    //         } else if (this.datas.sss_number.length < 10) {
    //             this.errorMessage7 = "SSS number is invalid ";
    //         } else {
    //             this.errorMessage6 = null;
    //             this.errorMessage7 = null;
    //         }
    //     }
    //     if (input === "datas.tin_number") {
    //         this.errorMessage8 = null;
    //         this.errorMessage9 = null;
    //         if (
    //             this.datas.tin_number.length > 9 &&
    //             this.datas.tin_number.length < 13
    //         ) {
    //             if (this.datas.tin_number[9] !== "0") {
    //                 this.errorMessage8 = "TIN 10th number must be 0";
    //             } else if (this.datas.tin_number[10] !== "0") {
    //                 this.errorMessage8 = "TIN 11th number must be 0";
    //             } else if (this.datas.tin_number[11] !== "0") {
    //                 this.errorMessage8 = "TIN 12th number must be 0";
    //                 console.log(this.datas.tin_number.toString().length);
    //             }
    //         } else if (
    //             this.datas.tin_number.toString().length > 12 ||
    //             this.datas.tin_number.toString().length < 12
    //         ) {
    //             this.errorMessage8 = "TIN number must be 12 digit number";
    //         } else if (this.datas.tin_number.toString().length === 0) {
    //             this.errorMessage9 = "TIN number is required";
    //         } else {
    //             this.errorMessage8 = null;
    //             this.errorMessage9 = null;
    //         }
    //     } else if (input === "datas.philhealth_number") {
    //         this.errorMessage10 = null;
    //         this.errorMessage11 = null;
    //     }
    //     if (this.datas.philhealth_number.length > 12) {
    //         this.errorMessage10 =
    //             "PhilHealth number must be 12 digit numbers";
    //     } else if (this.datas.philhealth_number.length === 0) {
    //         this.errorMessage10 = "PhilHealth is required";
    //     } else if (this.datas.philhealth_number.length < 12) {
    //         this.errorMessage11 = "PhilHealth number is invalid";
    //     } else {
    //         this.errorMessage10 = null;
    //         this.errorMessage11 = null;
    //     }
    // },
    update() {
      this.validate("datas.address");
      this.validate("datas.contact_number");
      this.validate("datas.pag_ibig_number");
      this.validate("datas.sss_number");
      this.validate("datas.tin_number");
      this.validate("datas.tin_number");
      if (
        this.datas.address != null &&
        this.datas.civil_status != null &&
        this.datas.contact_number != null &&
        this.datas.pag_ibig_number != null &&
        this.datas.sss_number != null &&
        this.datas.tin_number != null &&
        this.datas.philhealth_number != null &&
        this.errorMessage1 === null &&
        this.errorMessage2 === null &&
        this.errorMessage3 === null &&
        this.errorMessage4 === null &&
        this.errorMessage5 === null &&
        this.errorMessage6 === null &&
        this.errorMessage7 === null &&
        this.errorMessage8 === null &&
        this.errorMessage9 === null &&
        this.errorMessage10 === null &&
        this.errorMessage11 === null
      ) {
        this.dialog = true;
        e.preventDefault();
      }
      let params = {
        address: this.datas.address,
        civil_status: this.datas.civil_status,
        contact_number: this.datas.contact_number,
        pag_ibig_number: this.datas.pag_ibig_number,
        sss_number: this.datas.sss_number,
        tin_number: this.datas.tin_number,
        philhealth_number: this.datas.philhealth_number
      };
      this.$axios.post("user_info/" + this.user_id, params).then(response => {
        if (response.data === 1) {
          this.$parent.$parent.getInfo();
          this.dialog = false;
        } else {
          this.$parent.$parent.getInfo();
        }
      });
    }
  }
};
</script>