<template>
    <v-row justify="center">
        <v-dialog v-model="dialogBusiness" persistent max-width="600px">
            <v-card>
                <v-toolbar class="mb-2" color="blue darken-1" dark flat>
                    <v-card-title>
                        <span class="headline-bold">Business Information</span>
                    </v-card-title>
                </v-toolbar>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12" md="4">
                                <v-text-field
                                    class="input-name"
                                    v-model="company_id"
                                    label="Company ID"
                                    prepend-icon="mdi-id-card"
                                    @keyup="validate('company_id')"
                                ></v-text-field>
                                <span
                                    v-if="errorMessage12 !== null"
                                     style="color: red; font-size: 13px"
                                    >{{ errorMessage12 }}</span
                                >
                                <span
                                    v-if="errorMessage13 !== null"
                                     style="color: red; font-size: 13px"
                                    >{{ errorMessage13 }}</span
                                >
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
                                    :items="['Probationary', 'OJT', 'Regular']"
                                    label="Company Status*"
                                    prepend-icon="mdi-account"
                                    v-model="company_status"
                                    @keyup="validate('company_status')"
                                    required
                                ></v-select>
                            </v-col>

                            <v-col cols="12" md="4">
                                <v-select
                                    :items="departmentItem"
                                    label="Department*"
                                    prepend-icon="mdi-account-group"
                                    :item-text="
                                        departmentItem =>
                                            departmentItem.department_name
                                    "
                                    item-value="id"
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
                                    <v-date-picker
                                        v-model="date_hired"
                                        no-title
                                        scrollable
                                        color="primary"
                                    ></v-date-picker>
                                </v-menu>
                            </v-col>
                            <v-col cols="12" md="6">
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
                            <v-col cols="12" md="6">
                                <v-select
                                    :items="prp"
                                    label="PRP Assign"
                                    :item-text="
                                        prp =>
                                            prp.first_name + ' ' + prp.last_name
                                    "
                                    item-value="id"
                                    v-model="selectPrp"
                                    @keyup="validate('prp_assign')"
                                    prepend-icon="mdi-account"
                                    required
                                ></v-select>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-select
                                    :items="[
                                        'Customer Support Leader',
                                        'PHP DEV',
                                        'Reseller Support',
                                        'MKTG. Assistant',
                                        'Apps Developer',
                                        'Sales & Support',
                                        'Online Sales Associate',
                                        'Android DEV',
                                        'HR',
                                        'Accounting',
                                        'Admin Assistant',
                                        'Accounting Assistant',
                                        'Utility',
                                        'Marketing Staff'
                                    ]"
                                    label="Company Position*"
                                    v-model="company_position"
                                    @keyup="validate('company_position')"
                                    prepend-icon="mdi-account"
                                    required
                                ></v-select>
                            </v-col>
                            <v-col cols="12" md="6">
                                <i>
                                    <span
                                        v-if="errorMessage14 !== null"
                                        class="text-danger text-center"
                                        >{{ errorMessage14 }}</span
                                    >
                                </i>
                                <i>
                                    <span
                                        v-if="errorMessage15 !== null"
                                        class="text-danger text-center"
                                        >{{ errorMessage15 }}</span
                                    >
                                </i>
                                <i>
                                    <span
                                        v-if="errorMessage16 !== null"
                                        class="text-danger text-center"
                                        >{{ errorMessage16 }}</span
                                    >
                                </i>
                                <v-text-field
                                    class="input-name"
                                    v-model="allowed_leave_number"
                                    label="Allowed Leave No."
                                    prepend-icon="mdi-calendar-check"
                                    type="number"
                                    @keyup="validate('allowed_leave_number')"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-btn
                        color="blue darken-1"
                        dark
                        style="float-left"
                        @click="dialogBusiness = false"
                    >
                        <v-icon>mdi-arrow-left-bold</v-icon>
                        Back
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" dark @click="otherSave()">
                        <v-icon> mdi-arrow-right-bold</v-icon>
                        Next
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <othersInfo ref="others"></othersInfo>
    </v-row>
</template>
<script>
import othersInfo from "./othersInfo.vue";
export default {
    data: () => ({
        dialogBusiness: false,
        company_id: null,
        regularization_date: null,
        department: null,
        shift_time: null,
        date_hired: null,
        finance_assigned: null,
        prp_assigned: null,
        company_position: null,
        allowed_leave_number: null,
        errorMessage12: null,
        errorMessage13: null
    }),
    mounted() {
        this.getAllPrp();
        this.getAllFinance();
        this.getShift();
        this.getAllDepartment();
    },
    components: {
        othersInfo
    },
    methods: {
        business() {
            this.dialogBusiness = true;
        },
        otherSave() {
            this.dialogBusiness = false;
            this.$refs.others.others();
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
