<template>
    <div>
        <v-toolbar flat>
            <template v-slot:extension>
                <v-tabs
                    dark
                    background-color="primary"
                    fixed-tabs
                    v-if="
                        user_type.includes('hr mngr') ||
                            user_type.includes('prp emp') ||
                            user_type.includes('general mngr')
                    "
                >
                    <v-tabs-slider></v-tabs-slider>
                    <v-tab @click="(employees = false), (requests = true)"
                        >Employees Requests</v-tab
                    >
                    <v-tab @click="(requests = false), (employees = true)"
                        >My Requests</v-tab
                    >
                </v-tabs>
            </template>
        </v-toolbar>
        <v-data-table
            v-if="employees"
            :headers="headers"
            :items="travel"
            :search="search"
            class="elevation-3"
        >
            <template v-slot:top>
                <v-toolbar class="mb-2" color="blue darken-1" dark flat>
                    <v-col class="mt-8">
                        <v-select
                            :items="month"
                            label="Month"
                        ></v-select> </v-col
                    >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <v-btn depressed color="primary">SUMMARY</v-btn>
                    <v-divider class="mx-4" vertical></v-divider>
                    <v-spacer></v-spacer>
                    <v-text-field
                        v-model="search"
                        v-icon="mdi - magnify"
                        label="Search"
                        single-line
                        hide-details
                        class="mx-5"
                    ></v-text-field>
                    <v-dialog v-model="dialog">
                        <v-card class="mt-5">
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="12" sm="6" md="4">
                                            <v-text-field
                                                v-model="editedItem.reason"
                                                label="Destination"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4">
                                            <v-text-field
                                                v-model="editedItem.shift_date"
                                                label="Start Date"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4">
                                            <v-text-field
                                                v-model="editedItem.shift_time"
                                                label="End_Date"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4">
                                            <v-text-field
                                                v-model="
                                                    editedItem.prp_assigned
                                                "
                                                label="Emergency Contact"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4">
                                            <v-text-field
                                                v-model="editedItem.status"
                                                label="Documents"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4">
                                            <v-text-field
                                                v-model="editedItem.status"
                                                label="Approver"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4">
                                            <v-text-field
                                                v-model="editedItem.status"
                                                label="Status"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="close"
                                    >Cancel</v-btn
                                >
                                <v-btn
                                    color="blue darken-1"
                                    text
                                    @click="save()"
                                    >Save</v-btn
                                >
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <!-- <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="headline">Are you sure you want to delete this item?</v-card-title>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="closeDelete()">Cancel</v-btn>
                <v-btn color="blue darken-1" text @click="deleteItemConfirm()">OK</v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog> -->
                </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-icon small class="mr-2" @click="editItem(item)"
                    >mdi-pencil</v-icon
                >
                <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
            </template>
            <template v-slot:no-data>
                <v-btn color="primary" @click="initialize">Reset</v-btn>
            </template>
        </v-data-table>

        <!-- ****************start************** -->
        <v-dialog v-model="dialog" max-width="500px">
            <v-card>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12" sm="6" md="6">
                                <v-text-field
                                    v-model="editedItem.destination"
                                    label="Destination"
                                    prepend-icon=" mdi-home-modern"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                <v-text-field
                                    v-model="editedItem.emergency_contact"
                                    label="Emergency Contact"
                                    prepend-icon="mdi-account-outline"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                <span
                                    v-if="error2"
                                    style="color: red; font-style: italic"
                                    >Start date must not be higher than End
                                    date!</span
                                >
                                <v-menu
                                    :close-on-content-click="true"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="290px"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                            v-model="editedItem.start_date"
                                            label="Start Date"
                                            readonly
                                            v-bind="attrs"
                                            v-on="on"
                                            prepend-icon=" mdi-calendar"
                                        ></v-text-field>
                                    </template>
                                    <v-date-picker
                                        v-model="editedItem.start_date"
                                        :allowed-dates="disabledDates"
                                        no-title
                                        scrollable
                                        color="primary"
                                        @change="changeDate()"
                                    ></v-date-picker>
                                </v-menu>
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                <span
                                    v-if="error1"
                                    style="color: red; font-style: italic"
                                    >End date must be higher than start
                                    date!</span
                                >
                                <v-menu
                                    :close-on-content-click="true"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="290px"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                            v-model="editedItem.end_date"
                                            label="End Date"
                                            readonly
                                            v-bind="attrs"
                                            v-on="on"
                                            :disabled="disable"
                                            prepend-icon=" mdi-calendar"
                                        ></v-text-field>
                                    </template>
                                    <v-date-picker
                                        v-model="editedItem.end_date"
                                        :allowed-dates="disabledDates2"
                                        no-title
                                        scrollable
                                        color="primary"
                                        @change="changeDate()"
                                    ></v-date-picker>
                                </v-menu>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="editedItem.employee_to_cover"
                                    label="Employee to Cover"
                                    prepend-icon=" mdi-account-outline"
                                ></v-text-field>
                            </v-col>
                            <!-- <v-col cols="12">
                                <v-file-input
                                    label="Documents"
                                    v-model="editedItem.file_uri"
                                ></v-file-input>
                            </v-col> -->
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="dialog = false"
                        >Cancel</v-btn
                    >
                    <v-btn color="blue darken-1" text @click="save">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!-- ************Delete Modal*************** -->
        <v-dialog v-model="deleteModal" max-width="500px">
            <v-card>
                <v-card-title class="headline"
                    >Are you sure you want to delete this item?</v-card-title
                >
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="deleteModal = false"
                        >Cancel</v-btn
                    >
                    <v-btn color="blue darken-1" text @click="deleteItemConfirm"
                        >OK</v-btn
                    >
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="fileDialog" width="700px">
            <v-card>
                <v-card-title>
                    <span class="headline">Attached File</span>
                </v-card-title>
                <v-divider></v-divider>
                <v-card class="mx-auto" max-width="344">
                    <v-img :src="file_uri" width="500"></v-img>
                </v-card>
                <br>
                <!-- <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="fileDialog = false"
                        >BACK</v-btn
                    >
                    <v-btn color="blue darken-1" text @click="submitFiles()"
                        >EDIT</v-btn
                    >
                    <v-spacer></v-spacer>
                </v-card-actions>  -->
            </v-card>
        </v-dialog>

        <v-data-table
            v-if="
                requests &&
                    (!user_type.includes('hr mngr') ||
                        !user_type.includes('prp mngr') ||
                        !user_type.includes('prp emp'))
            "
            :headers="headers"
            :items="travel"
            :search="search"
            class="elevation-3"
        >
            <template v-slot:top>
                <v-toolbar class="mb-2" color="blue darken-1" dark flat>
                    <v-toolbar-title
                        class="col pa-3 py-4 white--text"
                        style="font-size: 16px"
                        >TRAVEL REQUEST</v-toolbar-title
                    >
                    <v-text-field
                        v-model="search"
                        clearable
                        flat
                        solo-inverted
                        hide-details
                        prepend-inner-icon="mdi-magnify"
                        label="Search"
                    ></v-text-field>
                    <createTravel></createTravel>
                </v-toolbar>
            </template>

            <template v-slot:item.file_uri="{ item }">
                <v-btn color="primary" @click="fileDialog = true; file_uri = item.file_uri">File</v-btn>
            </template>

            <template v-slot:item.actions="{ item }">
                <v-icon small class="mr-2" @click="editItem(item)"
                    >mdi-pencil</v-icon
                >
                <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
            </template>
        </v-data-table>
    </div>
</template>

<script>
import createTravel from "./modals/create_travel.vue";
import moment from "moment";
export default {
    data: () => ({
        file_uri:'',
        user_type: localStorage.getItem("user_type"),
        user_id: localStorage.getItem("id"),
        employees: !localStorage.getItem("user_type").includes("finance mngr")
            ? false
            : true,
        requests: !localStorage.getItem("user_type").includes("finance mngr")
            ? true
            : false,
        dialog: false,
        error: false,
        error1: false,
        fileDialog: false,
        files: "",
        uploadPercentage: 0,
        disable: false,
        end_date: null,
        error2: false,
        search: "",
        deleteModal: false,
        dialogDelete: false,
        headers: [
            {
                text: "DESTINATION",
                align: "start",
                sortable: false,
                value: "destination"
            },
            { text: "START DATE", value: "start_date" },
            { text: "END DATE", value: "end_date" },
            { text: "EMERGENCY CONTACT", value: "emergency_contact" },
            { text: "EMPLOYEE TO COVER", value: "employee_to_cover" },
            { text: "DOCUMENTS", value: "file_uri", sortable: false },
            { text: "APPROVER", value: "approver_role.role_name" },
            { text: "STATUS", value: "status.status_name" },
            { text: "ACTIONS", value: "actions", sortable: false }
        ],
        travel: [],
        id: null,
        editedIndex: null,
        editedItem: {
            destination: null,
            substitute: null,
            start_date: null,
            end_date: null,
            emergency_contact: null,
            employee_cover: null,
            prp_assigned_id: null,
            details: null
        },
        month: [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ],
        user_id: localStorage.getItem("id")
    }),
    components: {
        createTravel
    },
    mounted() {
        this.retrieve();
    },
    methods: {
        changeDate() {
            console.log("sulod " + this.editedItem.start_date);
            if (
                this.editedItem.start_date !== null &&
                this.editedItem.start_date !== ""
            ) {
                let start = moment(String(this.editedItem.start_date));
                let end = moment(String(this.editedItem.end_date));
                // if(end >= start){
                //   let diff = (end.diff(start))
                //   let differenceInDay = ((((diff/1000)/60)/60)/24)
                //   this.editedItem.total_days = differenceInDay
                //   this.total_days_with_text = differenceInDay + ' days of leave'
                //   this.error1 = false
                //   this.error2 = false
                // }else{
                //   this.error1 = true
                //   this.error2 = true
                // }
                this.disable = false;
            } else {
                this.disable = true;
            }
        },
        getAllPrp() {
            this.$axios.get("http://localhost:8000/prp").then(response => {
                this.prp = response.data;
                console.log(this.prp);
            });
        },
        retrieve() {
            this.$axios
                .get(
                    "http://localhost:8000/travel_auth_request/" + this.user_id
                )
                .then(response => {
                    this.travel = response.data;
                    console.log(response.data);
                })
                .catch(e => {
                    console.log(e);
                });
        },
        editItem(item) {
            this.editedItem.id = item.id;
            this.editedIndex = this.travel.indexOf(item);
            this.editedItem.destination = item.destination;
            this.editedItem.start_date = item.start_date;
            this.editedItem.end_date = item.end_date;
            this.editedItem.emergency_contact = item.emergency_contact;
            // this.editedItem.file_uri = item.file_uri;
            this.editedItem.employee_to_cover = item.employee_to_cover;
            this.dialog = true;
        },
        remove(index) {
            this.files.splice(index, 1);
        },
        handleFilesUpload() {
            // console.log(this.files);
            this.file = this.$refs.file.files[0];
        },
        // submitFiles() {
        //     let formData = new formData();
        //     for (var i = 0; i < this.files.length; i++) {
        //         let file = this.files[i];
        //         formData.append("files[" + i + "]", file);
        //     }
        //     // $axios.post('/multiple-files', formData)
        // },
        save() {
            if (
                this.editedItem.destination !== null &&
                this.editedItem.start_date !== null &&
                this.editedItem.end_date !== null &&
                this.editedItem.emergency_contact !== null &&
                this.editedItem.employee_to_cover !== null &&
                this.editedItem.emergency_contact !== "" &&
                this.editedItem.employee_to_cover !== "" &&
                this.editedItem.start_date !== "" &&
                this.editedItem.end_date !== "" &&
                this.error2 === false
            ) {
                let params = {
                    destination: this.editedItem.destination,
                    start_date: this.editedItem.start_date,
                    end_date: this.editedItem.end_date,
                    emergency_contact: this.editedItem.emergency_contact,
                    employee_to_cover: this.editedItem.employee_to_cover,
                    file_uri: "test"
                };
                console.log("params", params, this.editedItem.id);
                this.$axios
                    .post(
                        "http://localhost:8000/travel_auth_request/" +
                            this.editedItem.id,
                        params
                    )
                    .then(response => {
                        this.retrieve();
                    });
                this.dialog = false;
            } else {
                this.error = true;
            }
        },
        deleteItem(item) {
            this.deleteModal = true;
            this.id = item.id;
        },
        deleteItemConfirm() {
            this.$axios
                .delete("http://localhost:8000/travel_auth_request/" + this.id)
                .then(response => {
                    this.retrieve();
                    this.deleteModal = false;
                });
        },
        disabledDates(date) {
            return date > new Date().toISOString().substr(0, 10);
        },
        disabledDates2(date) {
            return (
                date >
                new Date(this.editedItem.start_date).toISOString().substr(0, 10)
            );
            this.differenceDates();
        },
        close() {
            this.dialog = false;
        },
        closeDelete() {
            this.dialogDelete = false;
        }
    }
};
</script>