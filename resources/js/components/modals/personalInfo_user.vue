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
                        <span
                            v-if="errorMessage17 !== null"
                            style="color: red; font-size: 14px"
                            >{{ errorMessage17 }}</span
                        >
                        <v-row>
                            <v-col cols="12" sm="6" md="4">
                                <v-text-field
                                    label="Firstname*"
                                    @keyup="validate('firstname')"
                                    v-model="first_name"
                                    prepend-icon="mdi-account-tie"
                                    dense
                                    required
                                ></v-text-field>
                                <span
                                    v-if="errorMessage1 !== null"
                                    style="color: red; font-size: 12px"
                                    >{{ errorMessage1 }}</span
                                >
                                <span
                                    v-if="errorMessage2 !== null"
                                    style="color: red; font-size: 12px"
                                    >{{ errorMessage2 }}</span
                                >
                            </v-col>
                            <v-col cols="12" sm="6" md="4">
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
                                    style="color: red; font-size: 12px"
                                    >{{ errorMessage3 }}</span
                                >
                                <span
                                    v-if="errorMessage4 !== null"
                                    style="color: red; font-size: 12px"
                                    >{{ errorMessage4 }}</span
                                >
                            </v-col>
                            <v-col cols="12" sm="6" md="4">
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
                                <v-text-field
                                    label="Contact Number*"
                                    @keyup="validate('contact_number')"
                                    v-model="contact_number"
                                    prepend-icon="mdi-contacts"
                                    type="number"
                                    dense
                                    required
                                ></v-text-field>
                                <span
                                    class="ml-8"
                                    v-if="errorMessage5 !== null"
                                    style="color: red; font-size: 12px"
                                    >{{ errorMessage5 }}</span
                                >
                                <span
                                    class="ml-8"
                                    v-if="errorMessage6 !== null"
                                    style="color: red; font-size: 12px"
                                    >{{ errorMessage6 }}</span
                                >
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                <v-select
                                    :items="civilItem"
                                    item-text="text"
                                    item-value="value"
                                    label="Civil Status*"
                                    @keyup="validate('civil_status')"
                                    v-model="civil_status"
                                    prepend-icon="mdi-account"
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
                                    @keyup="validate('email')"
                                    prepend-icon="mdi-email"
                                    dense
                                    required
                                ></v-text-field>
                                <span
                                    v-if="errorMessage8 !== null"
                                    style="color: red; font-size: 12px"
                                    >{{ errorMessage8 }}</span
                                >
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                <v-text-field
                                    label="Password*"
                                    type="password"
                                    v-model="password"
                                    @keyup="validate('password')"
                                    prepend-icon="mdi-eye"
                                    dense
                                    required
                                ></v-text-field>
                                <span
                                    class="ml-8"
                                    v-if="successMessage !== null"
                                    style="color: red; font-size: 12px"
                                    >{{ successMessage }}</span
                                >
                                <span
                                    class="ml-8"
                                    v-if="errorMessage9 !== null"
                                    style="color: red; font-size: 12px"
                                    >{{ errorMessage9 }}</span
                                >
                                <span
                                    class="ml-8"
                                    v-if="errorMessage10 !== null"
                                    style="color: red; font-size: 12px"
                                    >{{ errorMessage10 }}</span
                                >
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                <v-text-field
                                    label="Confirm Password*"
                                    type="password"
                                    v-model="confirm_password"
                                    @keyup="validate('confirm_password')"
                                    prepend-icon="mdi-eye"
                                    dense
                                    required
                                ></v-text-field>
                                <span
                                    class="ml-8"
                                    v-if="errorMessage11 !== null"
                                    style="color: red; font-size: 12px"
                                    >{{ errorMessage11 }}</span
                                >
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    label="Address*"
                                    v-model="address"
                                    @keyup="validate('address')"
                                    prepend-icon="mdi-map-marker"
                                    dense
                                    required
                                ></v-text-field>
                                <span
                                    class="ml-8"
                                    v-if="errorMessage7 !== null"
                                    style="color: red; font-size: 12px"
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
        <!-- End of Personal******************************************************************* -->
        <v-dialog v-model="dialogBusiness" persistent max-width="600px">
            <v-card>
                <v-toolbar class="mb-2" color="blue darken-1" dark flat>
                    <v-card-title>
                        <span class="headline-bold">Business Information</span>
                    </v-card-title>
                </v-toolbar>
                <v-card-text>
                    <v-container>
                        <span
                            v-if="errorMessage17 !== null"
                            style="color: red; font-size: 14px"
                            >{{ errorMessage17 }}</span
                        >
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
                                    style="color: red; font-size: 12px"
                                    >{{ errorMessage12 }}</span
                                >
                                <span
                                    v-if="errorMessage13 !== null"
                                    style="color: red; font-size: 12px"
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
                                    :items="comStatus"
                                    item-text="company_status_name"
                                    item-value="id"
                                    label="Company Status*"
                                    @keyup="validate('company_status')"
                                    v-model="company_status"
                                    prepend-icon="mdi-account"
                                    dense
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
                                :items="position"
                                item-text="position_name"
                                item-value="id"
                                label="Company Position*"
                                v-model="company_position"
                                prepend-icon="mdi-account"
                                required
                                ></v-select>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    class="input-name"
                                    v-model="allowed_leave_number"
                                    label="Allowed Leave No."
                                    prepend-icon="mdi-calendar-check"
                                    type="number"
                                    @keyup="validate('allowed_leave_number')"
                                ></v-text-field>
                                <span
                                    class="ml-8"
                                    v-if="errorMessage14 !== null"
                                    style="color: red; font-size: 12px"
                                    >{{ errorMessage14 }}</span
                                >

                                <span
                                    v-if="errorMessage15 !== null"
                                    style="color: red; font-size: 13px"
                                    >{{ errorMessage15 }}</span
                                >

                                <span
                                    class="ml-8"
                                    v-if="errorMessage16 !== null"
                                    style="color: red; font-size: 12px"
                                    >{{ errorMessage16 }}</span
                                >
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-btn
                        color="blue darken-1"
                        dark
                        style="float-left"
                        @click="backPersonal()"
                    >
                        <v-icon>mdi-arrow-left-bold</v-icon>
                        Back
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" dark @click="next1()">
                        <v-icon> mdi-arrow-right-bold</v-icon>
                        Next
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!-- ******************End of Business Info********************* -->
        <v-dialog v-model="dialogOthers" persistent max-width="600px">
            <v-card>
                <v-toolbar class="mb-2" color="blue darken-1" dark flat>
                    <v-card-title>
                        <span class="headline-bold">Other Information</span>
                    </v-card-title>
                </v-toolbar>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    class="input-name"
                                    v-model="pag_ibig_number"
                                    label="Pag-IBIG No."
                                    @keyup="validate('pag_ibig_number')"
                                    prepend-icon="mdi-credit-card"
                                    type="number"
                                ></v-text-field>
                                <span
                                    class="ml-8"
                                    v-if="errorMessage18 !== null"
                                    style="color: red; font-size: 12px"
                                    >{{ errorMessage18 }}</span
                                >
                                <span
                                    class="ml-8"
                                    v-if="errorMessage19 !== null"
                                    style="color: red; font-size: 12px"
                                    >{{ errorMessage19 }}</span
                                >
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    class="input-name"
                                    v-model="sss_number"
                                    label="SSS No."
                                    @keyup="validate('sss_number')"
                                    prepend-icon="mdi-credit-card"
                                    type="number"
                                ></v-text-field>
                                <span
                                    class="ml-8"
                                    v-if="errorMessage20 !== null"
                                    style="color: red; font-size: 12px"
                                    >{{ errorMessage20 }}</span
                                >
                                <span
                                    class="ml-8"
                                    v-if="errorMessage21 !== null"
                                    style="color: red; font-size: 12px"
                                    >{{ errorMessage21 }}</span
                                >
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    class="input-name"
                                    v-model="tin_number"
                                    label="TIN"
                                    @keyup="validate('tin_number')"
                                    prepend-icon="mdi-credit-card"
                                    type="number"
                                ></v-text-field>
                                <span
                                    class="ml-8"
                                    v-if="errorMessage22 !== null"
                                    style="color: red; font-size: 12px"
                                    >{{ errorMessage22 }}</span
                                >
                                <span
                                    class="ml-8"
                                    v-if="errorMessage23 !== null"
                                    style="color: red; font-size: 12px"
                                    >{{ errorMessage23 }}</span
                                >
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    class="input-name"
                                    v-model="philhealth_number"
                                    label="PhilHealth No."
                                    @keyup="validate('philhealth_number')"
                                    prepend-icon="mdi-credit-card"
                                    type="number"
                                ></v-text-field>
                                <span
                                    class="ml-8"
                                    v-if="errorMessage24 !== null"
                                    style="color: red; font-size: 12px"
                                    >{{ errorMessage24 }}</span
                                >
                                <span
                                    class="ml-8"
                                    v-if="errorMessage25 !== null"
                                    style="color: red; font-size: 12px"
                                    >{{ errorMessage25 }}</span
                                >
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-btn
                        color="blue darken-1"
                        dark
                        style="float-left"
                        @click="backBusiness()"
                    >
                        <v-icon>mdi-arrow-left-bold</v-icon>
                        Back
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" dark @click="addNew()">
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!-- <businessInfo ref="businesss"></businessInfo> -->
    </v-row>
</template>

<script>
// import businessInfo from "./businessInfo_user.vue";
export default {
    data: () => ({
        //String
        address: "",
        contact_number: "",
        pag_ibig_number: "",
        sss_number: "",
        tin_number: "",
        philhealth_number: "",
        first_name: "",
        last_name: "",
        password: "",
        confirm_password: "",
        email: "",
        // business: false,
        // Boolean
        dialogPersonal: false,
        dialogBusiness: false,
        dialogOthers: false,
        departmentItem: null,
        birthday: null,
        menu: false,
        selectPrp: null,
        prp: null,
        finance: null,
        selectFinance: null,
        sTime: null,
        error: false,
        civil_status: null,
        regularization_date: null,
        prp_assigned: null,
        finance_assigned: null,
        allowed_leave_number: null,
        department: null,
        shift_time: null,
        gender: null,
        company_position: null,
        date_hired: null,
        company_status: null,
        company_id: null,

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
        civilItem: [
            { text: "Single", value: 0 },
            { text: "Married", value: 1 },
            { text: "Widow", value: 2 }
        ],
        comStatus: [],
        position: [],
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
        errorMessage17: null,
        errorMessage18: null,
        errorMessage19: null,
        errorMessage20: null,
        errorMessage21: null,
        errorMessage22: null,
        errorMessage23: null,
        errorMessage24: null,
        errorMessage25: null
    }),
    mounted() {
        this.getAllPrp();
        this.getAllFinance();
        this.getShift();
        this.getPosition();
        this.getAllDepartment();
        this.getCompanyStatus();
    },
    watch: {
        menu(val) {
            val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
        }
    },
    //   components: {
    //     businessInfo
    //   },
    methods: {
        next() {
            if (
                this.first_name != null &&
                this.last_name != null &&
                this.gender != null &&
                this.contact_number != null &&
                this.civil_status != null &&
                this.birthday != null &&
                this.email != null &&
                this.password != null &&
                this.confirm_password != null &&
                this.address != null &&
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
                this.dialogPersonal = false;
                this.dialogBusiness = true;
                this.dialogOthers = false;
            } else {
                this.errorMessage17 = "Please fill up all fields";
            }
        },
        next1() {
            if (
                this.errorMessage12 === null &&
                this.errorMessage13 === null &&
                this.errorMessage14 === null &&
                this.errorMessage15 === null &&
                this.company_id !== null &&
                this.regularization_date !== null &&
                this.company_status !== null &&
                this.department !== null &&
                this.shift_time !== null &&
                this.date_hired !== null &&
                this.selectFinance !== null &&
                this.selectPrp !== null &&
                this.company_position !== null &&
                this.allowed_leave_number !== null
            ) {
                this.dialogBusiness = false;
                this.dialogOthers = true;
                this.dialogPersonal = false;
            } else {
                this.errorMessage17 = "Please fill up all fields";
            }
        },
        getCompanyStatus() {
            this.$axios.get("hr/department").then(response => {
                console.log("company status", response.data);
                response.data.forEach(element => {
                    this.comStatus.push(element);
                });
            });
        },
        backPersonal() {
            this.dialogPersonal = true;
            this.dialogBusiness = false;
        },

        backBusiness() {
            this.dialogOthers = false;
            this.dialogBusiness = true;
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
        getPosition() {
            this.$axios
                .get("http://localhost:8000/hr/company_position")
                .then(response => {
                    response.data.forEach(el => {
                        this.position.push(el);
                    });
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
            // this.errorMessage1 = "";
            // this.errorMessage2 = "";
            // this.errorMessage3 = "";
            // this.errorMessage4 = "";
            // this.errorMessage5 = "";
            // this.errorMessage6 = "";
            // this.errorMessage7 = "";
            // this.errorMessage8 = "";
            // this.errorMessage9 = "";
            // this.errorMessage10 = "";
            // this.errorMessage11 = "";
            // this.errorMessage12 = "";
            // this.errorMessage13 = "";
            // this.errorMessage14 = "";
            // this.errorMessage15 = "";
            // this.errorMessage16 = "";
            // this.errorMessage17 = "";
            // this.errorMessage18 = "";
            // this.errorMessage19 = "";

            if (input === "firstname") {
                this.errorMessage1 = null;
                this.errorMessage2 = null;
                if (reqWhiteSpace.test(this.first_name)) {
                    this.errorMessage1 =
                        "Firstname should not contain a number.";
                } else if (this.first_name === "") {
                    this.errorMessage2 = "Firstname is required.";
                } else if (!specialChar.test(this.first_name)) {
                    this.errorMessage2 =
                        "Firstname should not contain a special character.";
                } else {
                    this.errorMessage1 = null;
                    this.errorMessage2 = null;
                }
            } else if (input === "lastname") {
                this.errorMessage3 = null;
                this.errorMessage4 = null;
                if (reqWhiteSpace.test(this.last_name)) {
                    this.errorMessage3 =
                        "lastname should not contain a number.";
                } else if (this.last_name === "") {
                    this.errorMessage4 = "lastname is required.";
                } else if (!specialChar.test(this.last_name)) {
                    this.errorMessage4 =
                        "lastname should not contain a special character.";
                } else {
                    this.errorMessage3 = null;
                    this.errorMessage4 = null;
                }
            } else if (input === "contact_number") {
                this.errorMessage5 = null;
                this.successMessage6 = null;
                if (this.contact_number.length > 11) {
                    this.errorMessage5 =
                        "Contact number must not exceed 11 numbers";
                } else if (this.contact_number.length == 0) {
                    this.errorMessage6 = "Contact number is required";
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
                } else if (this.validateEmail(this.email) === "") {
                    this.errorMessage8 = "Email is required";
                } else {
                    this.errorMessage8 = null;
                }
            } else if (input === "password") {
                console.log("password");
                this.errorMessage9 = null;
                this.errorMessage10 = null;
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
                    this.successMessage = null;
                }
            } else if (input === "company_id") {
                this.errorMessage12 = null;
                this.errorMessage13 = null;
                if (this.company_id.slice > 12) {
                    this.errorMessage12 =
                        "Company ID must have 2 letter and 9 digit numbers.";
                } else if (this.company_id.length == 0) {
                    this.errorMessage13 = "Company ID is required";
                } else if (this.company_id.length < 9) {
                    this.errorMessage13 = "Company ID is invalid";
                } else {
                    this.errorMessage12 = null;
                    this.errorMessage13 = null;
                }
            } else if (input === "allowed_leave_number") {
                this.errorMessage14 = null;
                this.errorMessage15 = null;
                if (this.allowed_leave_number > 7) {
                    this.errorMessage14 =
                        "Leave Request must not exceed to 7 days";
                } else if (this.allowed_leave_number <= 0) {
                    this.errorMessage15 = "Leave number is required";
                } else {
                    this.errorMessage14 = null;
                    this.errorMessage15 = null;
                }
            } else if (input === "pag_ibig_number") {
                this.errorMessage18 = null;
                this.errorMessage19 = null;
                if (this.pag_ibig_number.length > 12) {
                    this.errorMessage18 =
                        "Pag-IBIG number must be 12 digit number";
                } else if (this.pag_ibig_number.length == 0) {
                    this.errorMessage19 = "Pag-IBIG number is required";
                } else if (this.pag_ibig_number.length < 12) {
                    this.errorMessage19 = "Pag-IBIG number is invalid";
                } else {
                    this.errorMessage18 = null;
                    this.errorMessage19 = null;
                }
            } else if (input === "sss_number") {
                this.errorMessage20 = null;
                this.errorMessage21 = null;
                if (this.sss_number.length > 10) {
                    this.errorMessage20 = "SSS number must be 10 digit number";
                } else if (this.sss_number.length == 0) {
                    this.errorMessage21 = "SSS number is required";
                } else if (this.sss_number.length < 10) {
                    this.errorMessage21 = "SSS number is invalid";
                } else {
                    this.errorMessage20 = null;
                    this.errorMessage21 = null;
                }
            } else if (input === "tin_number") {
                this.errorMessage22 = null;
                this.errorMessage23 = null;
                if (this.tin_number.length > 12) {
                    this.errorMessage22 = "TIN number must be 12 digit number";
                } else if (this.tin_number.length == 0) {
                    this.errorMessage23 = "TIN number is required";
                    // } else if (this.tin_number.slice(9,12) != "000") {

                    //     this.errorMessage23 = "TIN number must end with the digit 000";
                } else {
                    this.errorMessage22 = null;
                    this.errorMessage23 = null;
                }
            } else if (input === "philhealth_number") {
                this.errorMessage24 = null;
                this.errorMessage25 = null;
                if (this.philhealth_number.length > 12) {
                    this.errorMessage24 =
                        "PhilHealth number must be 12 digit numbers";
                } else if (this.philhealth_number == 0) {
                    this.errorMessage25 = "PhilHealth is required";
                } else if (this.tin_number.length < 12) {
                    this.errorMessage25 = "PhilHealth number is invalid";
                } else {
                    this.errorMessage24 = null;
                    this.errorMessage25 = null;
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
            console.log("hoi");
            this.validate("lastname");
            this.validate("firstname");
            this.validate("contact_number");
            this.validate("email");
            this.validate("password");
            this.validate("confirm_password");
            this.validate("address");
            this.validate("company_id");
            this.validate("allowed_leave_number");
            this.validate("sss_number");
            this.validate("tin_number");
            this.validate("philhealth_number");
            this.validate("pag_ibig_number");
            if (
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
                this.errorMessage11 === null &&
                this.errorMessage12 === null &&
                this.errorMessage13 === null &&
                this.errorMessage14 === null &&
                this.errorMessage15 === null &&
                this.errorMessage16 === null &&
                this.errorMessage17 === null &&
                this.errorMessage18 === null &&
                this.errorMessage19 === null &&
                this.errorMessage20 === null &&
                this.errorMessage21 === null &&
                this.errorMessage22 === null &&
                this.errorMessage23 === null &&
                this.errorMessage24 === null &&
                this.errorMessage25 === null
            ) {
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
                console.log("params here", params);
                this.$axios.post("hr/manage/user", params).then(response => {
                    console.log("here", response.data);
                    this.$parent.$parent.$parent.$parent.$parent.$parent.retrieve();
                });
            } else {
                this.errorMessage17 = "Please put valid information";
            }
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
                (this.confirm_password = null),
                (this.errorMessage1 = null),
                (this.errorMessage2 = null),
                (this.errorMessage3 = null),
                (this.errorMessage4 = null),
                (this.errorMessage5 = null),
                (this.errorMessage6 = null),
                (this.errorMessage7 = null),
                (this.errorMessage8 = null),
                (this.errorMessage9 = null),
                (this.errorMessage10 = null),
                (this.errorMessage11 = null),
                (this.errorMessage12 = null),
                (this.errorMessage13 = null),
                (this.errorMessage14 = null),
                (this.errorMessage15 = null),
                (this.errorMessage16 = null),
                (this.errorMessage17 = null);
        }
    }
};
</script>
