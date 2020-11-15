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
          <v-toolbar-title style="font-size: 16px">Make Request</v-toolbar-title>
        </v-btn>
      </template>
      <v-card>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat>
          <v-card-title>
            <span class="headline-bold">TRAVEL AUTHORIZATION REQUEST</span>
          </v-card-title>
        </v-toolbar>
        <v-card-text>
          <v-container>
            <span v-if="error" style="color: red; font-size: 15px">All data are required!</span>
            <v-row>
              <v-col cols="12" sm="6" md="6">
                <v-text-field
                  label="Destination*"
                  prepend-icon=" mdi-home-modern"
                  v-model="destination"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-select
                  :items="coDepartment"
                  label="Employee to Cover*"
                  v-model="employee_to_cover"
                  prepend-icon=" mdi-account-outline"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-menu
                  :close-on-content-click="true"
                  transition="scale-transition"
                  offset-y
                  min-width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="start_date"
                      label="Start Date"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                      prepend-icon=" mdi-calendar"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="start_date"
                    :allowed-dates="disabledDates"
                    no-title
                    scrollable
                    color="primary"
                    @change="changeDate()"
                  >
                    <v-spacer></v-spacer>
                    <v-btn text color="primary" @click="menu = false">Cancel</v-btn>
                    <v-btn text color="primary" @click="$refs.menu.save(date)">OK</v-btn>
                  </v-date-picker>
                </v-menu>
              </v-col>
              <v-spacer></v-spacer>
              <v-col cols="12" sm="6" md="6">
                <v-menu
                  :close-on-content-click="true"
                  transition="scale-transition"
                  offset-y
                  min-width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="end_date"
                      label="End Date"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                      :disabled="disable"
                      prepend-icon=" mdi-calendar"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="end_date"
                    :allowed-dates="disabledDates2"
                    no-title
                    color="primary"
                    scrollable
                    @change="changeDate()"
                  ></v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  label="Contact Person*"
                  prepend-icon=" mdi-account-outline"
                  v-model="emergency_contact"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-icon large color="blue darken-2">mdi-attachment</v-icon>
                <input accept="image/*" v-on:change="checkFile" type="file">
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red" dark @click="dialog = false">Close</v-btn>
          <v-btn color="success" @click="createTravel()">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
import moment from "moment";
export default {
  data: () => ({
    dialog: false,
    error: false,
    disable: false,
    focused: false,
    destination: null,
    substitute: null,
    start_date: null,
    end_date: null,
    emergency_contact: null,
    employee_to_cover: null,
    prp_assigned_id: null,
    details: null,
    files: [],
    user_id: localStorage.getItem("id"),
    val: [],
    coDepartment: [],
    selectedFile: null
  }),
  mounted() {
    this.getCoDepartment()
  },
  methods: {
    changeDate() {
      if (this.start_date !== null && this.start_date !== "") {
        let start = moment(String(this.start_date));
        let end = moment(String(this.end_date));
        this.disable = false;
      } else {
        this.disable = true;
      }
    },
    checkFile(e) {
      this.selectedFile = e.target.files[0];
      this.file_uri = URL.createObjectURL(e.target.files[0]);
    },
    // onButtonClick() {
    //     this.isSelecting = false;
    //     window.addEventListener(
    //         "focus",
    //         () => {
    //             this.isSelecting = false;
    //         },
    //         { once: true }
    //     );
    //     this.$refs.uploader.click();
    // },
    createTravel() {
      if (
        this.destination !== null &&
        this.start_date !== null &&
        this.end_date !== null &&
        this.emergency_contact !== null &&
        this.employee_to_cover !== null
        // this.img !== null
      ) {
        let obj = this;
        const config = {
          header: { "content-type": "multipart/form-data" }
        };
        let formData = new FormData();
        formData.append("file_uri", this.selectedFile);
        formData.append("user_id", this.user_id);
        formData.append("destination", this.destination);
        formData.append("start_date", this.start_date);
        formData.append("end_date", this.end_date);
        formData.append("emergency_contact", this.emergency_contact);
        formData.append("employee_to_cover", this.employee_to_cover);
        formData.append("prp_assigned_id", 1);
        this.$axios
          .post("travel_auth_request", formData, config)
          .then(res => {
            this.$parent.$parent.$parent.$parent.$parent.retrieve();
          });
        this.dialog = false;
        this.error = false;
        this.val = false;
      } else {
        this.error = true;
        this.dialog = true;
        this.val = true;
      }
    },
    disabledDates(date) {
      return date > new Date().toISOString().substr(0, 10);
    },
    disabledDates2(date) {
      return date > new Date(this.start_date).toISOString().substr(0, 10);
    },
    getCoDepartment(){
      this.$axios.get("departments/employees").then (response => {
        this.coDepartment = response.data
        console.log('coDepartment', response.data)
      })
    },
    removeData() {
      (this.destination = null),
        (this.employee_to_cover = null),
        (this.start_date = null),
        (this.end_date = null),
        (this.emergency_contact = null),
        (this.prp_assigned_id = null);
      this.changeDate();
    }
  }
};
</script>
