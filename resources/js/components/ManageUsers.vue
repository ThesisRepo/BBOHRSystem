<template>
    <v-row justify="center">
        <v-dialog
            v-model="dialogPersonal"
            show-overlay
            persistent
            max-width="600px"
        >
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
                                    v-model="editItem.first_name"
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
                                    v-model="editItem.last_name"
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
                                    v-model="editItem.gender"
                                    prepend-icon="mdi-gender-male-female"
                                    dense
                                    required
                                ></v-select>
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                <v-text-field
                                    label="Contact Number*"
                                    @keyup="validate('contact_number')"
                                    v-model="editItem.contact_number"
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
                                    v-model="editItem.civil_status"
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
                                            v-model="editItem.birthday"
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
                                    v-model="editItem.email"
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
                                    v-model="editItem.password"
                                    @keyup="validate('password')"
                                    prepend-icon="mdi-eye"
                                    dense
                                    required
                                ></v-text-field>
                                <span
                                    class="ml-8"
                                    v-if="successMessage !== null"
                                    style="color: green; font-size: 12px"
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
                                    v-model="editItem.confirm_password"
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
                                    v-model="editItem.address"
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
                                    v-model="editItem.company_number"
                                    label="Company ID"
                                    prepend-icon="mdi-id-card"
                                    @keyup="validate('company_number')"
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
                                            v-model="
                                                editItem.regularization_date
                                            "
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
                                    :items="comStatus"
                                    item-text="company_status_name"
                                    item-value="id"
                                    label="Company Status*"
                                    @keyup="validate('company_status')"
                                    v-model="editItem.company_status"
                                    prepend-icon="mdi-account"
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
                                    <v-date-picker
                                        v-model="editItem.date_hired"
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
                                    v-model="editItem.selectFinance"
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
                                    v-model="editItem.selectPrp"
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
                                    v-model="editItem.company_position"
                                    prepend-icon="mdi-account"
                                    required
                                ></v-select>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    class="input-name"
                                    v-model="editItem.allowed_leave_number"
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
                <!-- <template v-slot:item.status.status_name="{ item }"> <v-chip :color="getColor(item.status.status_name)" :text-color="getColor(item.status.status_name) != '#ffa500'? 'white': 'black'">{{item.status.status_name === 'pending' ? 'PENDING' : item.status.status_name === '"approved"' ? 'APPROVED' : item.status.status_name === 'disapproved' ? 'DISAPPROVED' : ''}}</v-chip> </template> -->
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
                                    v-model="editItem.pag_ibig_number"
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
                                    v-model="editItem.sss_number"
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
                                    v-model="editItem.tin_number"
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
                                    v-model="editItem.philhealth_number"
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
                    <v-btn color="red" dark @click="dialogOthers = false">
                        Cancel
                    </v-btn>
                    <v-btn
                        color="blue darken-1"
                        dark@click="update(), (dialog = false)"
                    >
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!-- <businessInfo ref="businesss"></businessInfo> -->
        <v-data-table
            :headers="headers"
            :items="user"
            :search="search"
            class="elevation-1"
        >
            <template v-slot:top>
                <v-toolbar class="mb-2" color="blue darken-1" dark flat>
                    <v-toolbar-title
                        class="col pa-3 py-4 white--text"
                        style="font-size:16px "
                        >MANAGE USER</v-toolbar-title
                    >
                    <v-text-field
                        v-model="search"
                        class="mr-15"
                        clearable
                        flat
                        solo-inverted
                        hide-details
                        prepend-inner-icon="mdi-magnify"
                        label="Search"
                    ></v-text-field>

                    <v-dialog v-model="dialog" max-width="500px">
                        <template v-slot:activator="{ on, attrs }">
                            <createUser @create="add($event)"></createUser>
                        </template>
                    </v-dialog>

                    <!-- Delete Modal -->
                    <ConfirmationDel
                        ref="confirmDel"
                        @onConfirm="confirmDel($event)"
                    ></ConfirmationDel>
                </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
                <!-- <v-icon small class="mr-2" @click="seeItem(item)">mdi-eye</v-icon> -->
                <v-icon small class="mr-2" @click="editedItem(item)"
                    >mdi-pencil</v-icon
                >
                <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
            </template>
        </v-data-table>
    </v-row>
</template>

<script>
import createUser from "./modals/personalInfo_user.vue";
import ConfirmationDel from "./modals/confirmation/delete.vue";
export default {
    data: () => ({
        showModal: false,
        dialogPersonal: false,
        dialogBusiness: false,
        dialogOthers: false,
        menu: false,
        prp: null,
        finance: null,
        sTime: null,
        search: "",
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
        errorMessage25: null,
        comStatus: [],
        position: [],
        civilItem: [
            { text: "Single", value: 0 },
            { text: "Married", value: 1 },
            { text: "Widow", value: 2 }
        ],
        genderItem: [
            { text: "Female", value: 0 },
            { text: "Male", value: 1 }
        ],
        headers: [
            {
                text: "NAME",
                align: "start",
                sortable: false,
                value: "first_name"
            },
            { text: "ID NO.", value: "user_information.company_number" },
            { text: "COMPANY EMAIL", value: "email" },
            {
                text: "DEPARTMENT",
                value: "user_information.department.department_name"
            },
            { text: "PRP IN CHARGE", value: "assigned_prp.first_name" },
            { text: "STATUS", value: "user_information.company_status_id" },
            { text: "ACTIONS", value: "actions", sortable: false }
        ],
        user: [],
        dialog: false,
        birthday: null,
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
            prp_assigned: null,
            prp: null,
            finance: null,
            selectFinance: null,
            password_confirmation: null,
            department: null,
            shift_time: null,
            gender: null,
            allowed_leave_number: null,
            company_position: null,
            date_hired: null,
            company_status: null,
            birthday: null,
            company_number: null
        },
        user_id: localStorage.getItem("id"),
        genderItem: [
            { text: "Female", value: 0 },
            { text: "Male", value: 1 }
        ],
        comStatus: [],
        position: [],
        departmentItem: []
    }),
    components: {
        ConfirmationDel,
        createUser
    },
    mounted() {
        this.retrieve();
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
    methods: {
        add(data) {
            console.log("data", data);
            this.user.push(data);
        },
        retrieve() {
            this.$axios.get("hr/manage/user").then(response => {
                this.user = response.data;
                console.log("user", this.user);
            });
        },
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
                this.company_number !== null &&
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
            } else if (input === "company_number") {
                this.errorMessage12 = null;
                this.errorMessage13 = null;
                if (this.company_number.length > 12) {
                    this.errorMessage12 = "Company ID must have 12 characters ";
                } else if (this.company_number.length == 0) {
                    this.errorMessage13 = "Company ID is required";
                } else if (this.company_number.length < 12) {
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
                } else if (this.pag_ibig_number.length === 0) {
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
                } else if (this.sss_number.length === 0) {
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
                if (this.tin_number.length > 9 && this.tin_number.length < 13) {
                    if (this.tin_number[9] !== "0") {
                        this.errorMessage23 = "TIN 10th number must be 0";
                    } else if (this.tin_number[10] !== "0") {
                        this.errorMessage23 = "TIN 11th number must be 0";
                    } else if (this.tin_number[11] !== "0") {
                        this.errorMessage23 = "TIN 12th number must be 0";
                    }
                } else if (this.tin_number.length > 12) {
                    this.errorMessage22 = "TIN number must be 12 digit number";
                } else if (this.tin_number.length === 0) {
                    this.errorMessage23 = "TIN number is required";
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
                } else if (this.philhealth_number.length === 0) {
                    this.errorMessage25 = "PhilHealth is required";
                } else if (this.philhealth_number.length < 12) {
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
        backPersonal() {
            this.dialogPersonal = true;
            this.dialogBusiness = false;
        },

        backBusiness() {
            this.dialogOthers = false;
            this.dialogBusiness = true;
        },
        editedItem(item) {
            console.log("lbolbol", item);
            this.editItem.id = item.id;
            this.editItem.address = item.user_information.address;
            this.editItem.civil_status = item.civil_status;
            this.editItem.contact_number = item.user_information.contact_number;
            this.editItem.pag_ibig_number =
                item.user_information.pag_ibig_number;
            this.editItem.sss_number = item.user_information.sss_number;
            this.editItem.tin_number = item.user_information.tin_number;
            this.editItem.philhealth_number =
                item.user_information.philhealth_number;
            this.editItem.selectPrp = item.assigned_prp.id;
            this.editItem.selectFinance = item.assigned_finance.id;
            this.editItem.first_name = item.first_name;
            this.editItem.last_name = item.last_name;
            this.editItem.email = item.email;
            this.editItem.password = item.password;
            this.editItem.regularization_date =
                item.user_information.regularization_date;
            this.editItem.password_confirmation = item.confirm_password;
            this.editItem.department =
                item.user_information.department.department_name;
            this.editItem.shift_time = item.user_information.shift_time_id;
            this.editItem.gender = parseInt(item.user_information.gender);
            this.editItem.allowed_leave_number =
                item.user_information.allowed_leave_number;
            this.editItem.company_position =
                item.user_information.company_position;
            this.editItem.date_hired = item.user_information.date_hired;
            this.editItem.company_status = item.user_information.company_status;
            this.editItem.birthday = item.user_information.birthday;
            this.editItem.company_number = item.user_information.company_number;
            this.dialogOthers = false;
            this.dialogPersonal = false;
            this.dialogBusiness = false;
            console.log(
                this.editItem.shift_time,
                this.editItem.department,
                this.editItem.selectFinance,
                this.editItem.selectPrp
            );
        },
        getPrp() {
            console.log(this.editItem.selectPrp);
        },

        getCompanyStatus() {
            this.$axios.get("hr/department_status").then(response => {
                response.data.forEach(element => {
                    this.comStatus.push(element);
                });
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
            this.$axios
                .get("http://localhost:8000/departments")
                .then(response => {
                    response.data.forEach(element => {
                        this.departmentItem.push(element);
                    });
                });
        },
        update() {
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
                .post("hr/manage/user/" + this.editItem.id, params)
                .then(response => {
                    this.retrieve();
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
            this.$axios.delete("hr/manage/user/" + this.id).then(response => {
                this.retrieve();
            });
        },
        getAllPrp() {
            this.$axios.get("prp/").then(response => {
                console.log(response.data);
                this.prp = response.data;
            });
        },
        getAllFinance() {
            this.$axios.get("finance").then(response => {
                console.log(response.data);
                this.finance = response.data;
            });
        },
        getShift() {
            this.$axios.get("shift_time").then(response => {
                this.sTime = response.data;
            });
        },
        save(birthday) {
            this.$refs.menu.save(birthday);
        }
    }
};
</script>
