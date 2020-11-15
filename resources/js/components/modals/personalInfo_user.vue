<template>
    <v-row justify="center">
        <v-dialog
            v-model="dialogPersonal"
            show-overlay
            persistent
            max-width="600px"
        >
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
                    <v-toolbar-title style="font-size: 16px"
                        >New User</v-toolbar-title
                    >
                </v-btn>
            </template>
            <v-card>
                <v-toolbar class="mb-2" color="blue darken-1" dark flat>
                    <v-card-title>
                        <span class="headline-bold">Personal Information</span>
                    </v-card-title>
                </v-toolbar>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12" sm="6" md="6">
                                <v-text-field
                                    label="Firstname*"
                                    @keyup="validate('firstname')"
                                    v-model="first_name"
                                    prepend-icon="mdi-account-tie"
                                    dense
                                    required
                                >
                                </v-text-field>
                                <span
                                    v-if="errorMessage1 !== null"
                                    style="color: red; font-size: 13px"
                                    >{{ errorMessage1 }}</span
                                >
                                <span
                                    v-if="errorMessage2 !== null"
                                    class="text-danger text-center"
                                    >{{ errorMessage2 }}</span
                                >
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                <v-text-field
                                    label="Lastname*"
                                    @keyup="validate('lastname')"
                                    v-model="last_name"
                                    prepend-icon="mdi-account-tie"
                                    dense
                                    required
                                ></v-text-field>
                                <span
                                    v-if="errorMessage3 !== null"
                                    style="color: red; font-size: 13px"
                                    >{{ errorMessage3 }}</span
                                >
                                <span
                                    v-if="errorMessage4 !== null"
                                    style="color: red; font-size: 13px"
                                    >{{ errorMessage4 }}</span
                                >
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                <v-text-field
                                    label="Contact Number*"
                                    @keyup="validate('contact_number')"
                                    v-model="contact_number"
                                    prepend-icon="mdi-contacts"
                                    dense
                                    required
                                ></v-text-field>
                                <span
                                    v-if="errorMessage5 !== null"
                                    style="color: red; font-size: 13px"
                                    >{{ errorMessage5 }}</span
                                >
                                <span
                                    v-if="errorMessage6 !== null"
                                    style="color: red; font-size: 13px"
                                    >{{ errorMessage6 }}</span
                                >
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                <v-select
                                    :items="genderItem"
                                    item-text="text"
                                    item-value="value"
                                    label="Gender*"
                                    @keyup="validate('gender')"
                                    v-model="gender"
                                    prepend-icon="mdi-gender-male-female"
                                    dense
                                    required
                                ></v-select>
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
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
                                            prepend-icon="mdi-calendar"
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
                            <v-col cols="12" sm="6" md="6">
                                <v-text-field
                                    label="Email*"
                                    type="email"
                                    v-model="email"
                                    prepend-icon="mdi-email"
                                    dense
                                    required
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                <v-text-field
                                    label="Password*"
                                    type="password"
                                    v-model="password"
                                    prepend-icon="mdi-eye"
                                    dense
                                    required
                                ></v-text-field>
                                <span
                                    v-if="successMessage !== null"
                                    style="color: red; font-size: 13px"
                                    >{{ successMessage }}</span
                                >
                                <span
                                    v-if="errorMessage9 !== null"
                                    style="color: red; font-size: 13px"
                                    >{{ errorMessage9 }}</span
                                >
                                <span
                                    v-if="errorMessage10 !== null"
                                    style="color: red; font-size: 13px"
                                    >{{ errorMessage10 }}</span
                                >
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                <v-text-field
                                    label="Confirm Password*"
                                    type="password"
                                    v-model="confirm_password"
                                    prepend-icon="mdi-eye"
                                    dense
                                    required
                                ></v-text-field>
                                <span
                                    v-if="successMessage !== null"
                                    style="color: red; font-size: 13px"
                                    >{{ successMessage }}</span
                                >
                                <span
                                    v-if="errorMessage11 !== null"
                                    style="color: red; font-size: 13px"
                                    >{{ errorMessage11 }}</span
                                >
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    label="Address*"
                                    v-model="address"
                                    prepend-icon="mdi-map-marker"
                                    dense
                                    required
                                ></v-text-field>
                                <span
                                    v-if="errorMessage7 !== null"
                                    style="color: red; font-size: 13px"
                                    >{{ errorMessage7 }}</span
                                >
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red" dark @click="dialogPersonal = false"
                        >Cancel</v-btn
                    >
                    <v-btn color="blue darken-1" dark @click="next()"
                        >Next</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>

        <businessInfo ref="businesss"></businessInfo>
    </v-row>
</template>

<script>
import businessInfo from "./businessInfo_user.vue";
export default {
    data: () => ({
        // business: false,
        departmentItem: null,
        birthday: null,
        menu: false,
        dialogPersonal: false,
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
        first_name: "",
        last_name: "",
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
        // hideDialogue: false,
        genderItem: [
            { text: "Female", value: 0 },
            { text: "Male", value: 1 }
        ],
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
        email: ""
    }),
    mounted() {
        this.getAllPrp();
        this.getAllFinance();
        this.getShift();
        this.getAllDepartment();
    },
    watch: {
        menu(val) {
            val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
        }
    },
    components: {
        businessInfo
    },
    methods: {
        next() {
         
            this.dialogPersonal = false;
            this.$refs.businesss.business();
        },
        getAllPrp() {
            this.$axios.get("prp").then(response => {
                this.prp = response.data;
            });
        },
        getAllFinance() {
            this.$axios.get("finance").then(response => {
                this.finance = response.data;
            });
        },
        getAllDepartment() {
            this.$axios.get("departments").then(response => {
                console.log("department", response.data);
                this.departmentItem = response.data;
            });
        },
        getShift() {
            this.$axios.get("shift_time").then(response => {
                this.sTime = response.data;
            });
        },
        //end
        save(birthday) {
            this.$refs.menu.save(birthday);
        },

        validate(input) {
            this.successMessage = null;
            let reqWhiteSpace = /\d/;
            let specialChar = /^[A-Za-z0-9 ]+$/;
            let numberExclude = /^[0-9 ]+$/;
            if (input === "firstname" || input === "lastname") {
                // this.errorMessage1 = null;
                if (
                    reqWhiteSpace.test(this.first_name) ||
                    reqWhiteSpace.test(this.last_name)
                ) {
                    if (input === "firstname") {
                        this.errorMessage1 =
                            "firstname should not contain a number.";
                    } else {
                        this.errorMessage3 =
                            "lastname should not contain a number.";
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
                if (!numberExclude.test(this.contact_number)) {
                    this.errorMessage5 = "Should not contain characters";
                } else if (this.contact_number.length > 11) {
                    this.errorMessage5 =
                        "Contact number must not exceed 11 numbers";
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
                    this.errorMessage8 =
                        "You have entered an invalid email address.";
                } else {
                    this.errorMessage8 = null;
                }
            } else if (input === "password") {
                console.log("password");
                this.errorMessage9 = null;
                if (this.password.length < 8) {
                    this.errorMessage9 =
                        " Password must be atleast 8 characters.";
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
            } else if (input === "company_id") {
                this.errorMessage12 = null;
                this.errorMessage13 = null;
                if (this.company_id.length < 8) {
                    this.errorMessage12 = "ID number is invalid.";
                } else {
                    this.errorMessage13 =
                        "ID number must be 8 numbers or 2 letters followed by 6 numbers";
                }
            } else if (input === "allowed_leave_number") {
                if (this.allowed_leave_number > 7) {
                    this.errorMessage14 =
                        "Leave Request must not exceed to 7 days";
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
            console.log("sdfasdf", this.first_name);
            this.validate("lastname");
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
            // this.$axios
            //   .post("hr/manage/user", params)
            //   .then(response => {
            //     this.$parent.$parent.$parent.$parent.$parent.$parent.retrieve();
            //   });
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
                (this.first_name = ""),
                (this.last_name = ""),
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
