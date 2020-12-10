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
                  @keyup="validate('destination')"
                  required
                ></v-text-field>
                <span
                  class="ml-8"
                  v-if="errorMessage1 !== null"
                  style="color: red; font-size: 12px"
                  >{{ errorMessage1 }}</span
                >
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-select
                  :items="coDepartment"
                  :item-text="coDepartment => coDepartment.first_name + ' ' + coDepartment.last_name"
                  item-value="id"
                  label="Employee to Cover*"
                  v-model="employee_to_cover"
                  @change="validate('cover')"
                  prepend-icon=" mdi-account-outline"
                  required
                ></v-select>
                <span
                  class="ml-8"
                  v-if="errorMessage2 !== null"
                  style="color: red; font-size: 12px"
                  >{{ errorMessage2 }}</span
                >
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
                      @change="validate('date')"
                      prepend-icon=" mdi-calendar"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="start_date"
                    :allowed-dates="disabledDates"
                    no-title
                    scrollable
                    color="primary"
                    @change="changeDate(), validate('date')"
                  >
                    <v-spacer></v-spacer>
                    <v-btn text color="primary" @click="menu = false">Cancel</v-btn>
                    <v-btn text color="primary" @click="$refs.menu.save(date)">OK</v-btn>
                  </v-date-picker>
                </v-menu>
                <span
                  class="ml-8"
                  v-if="errorMessage3 !== null"
                  style="color: red; font-size: 12px"
                  >{{ errorMessage3 }}</span
                >
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
                      @change="validate('endDate')"
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
                    @change="changeDate(), validate('endDate')"
                  ></v-date-picker>
                </v-menu>
                <span
                  class="ml-8"
                  v-if="errorMessage4 !== null"
                  style="color: red; font-size: 12px"
                  >{{ errorMessage4 }}</span
                >
              </v-col>
              <v-col cols="6">
                <v-text-field
                  label="Contact Person*"
                  prepend-icon=" mdi-account-outline"
                  v-model="emergency_contact"
                  @keyup="validate('contactPerson')"
                  required
                ></v-text-field>
                <span
                  class="ml-8"
                  v-if="errorMessage6 !== null"
                  style="color: red; font-size: 12px"
                  >{{ errorMessage6 }}</span
                >
              </v-col>
              <v-col cols="6">
                <v-text-field
                  type="number"
                  label="Contact Person's Number*"
                  prepend-icon=" mdi-account-outline"
                  v-model="contact_number"
                  @keyup="validate('contactNumber')"
                  required
                ></v-text-field>
                <span
                  class="ml-8"
                  v-if="errorMessage5 !== null"
                  style="color: red; font-size: 12px"
                  >{{ errorMessage5 }}</span
                >
              </v-col>
              <v-col cols="12">
                <v-icon large color="blue darken-2">mdi-attachment</v-icon>
                <input accept="image/*" v-on:change="checkFile" type="file"><br>
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
          <v-btn color="red" dark @click="dialog = false">Cancel</v-btn>
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
    errorMessage1: null,
    errorMessage2: null,
    errorMessage3: null,
    errorMessage4: null,
    errorMessage5: null,
    errorMessage6: null,
    errorMessage7: null,
    disable: false,
    focused: false,
    destination: '',
    contact_number: '',
    start_date: '',
    end_date: '',
    emergency_contact: '',
    employee_to_cover: '',
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
        let start = moment(String(this.start_date))
        let end = moment(String(this.end_date))
        this.disable = false
      } else {
        this.disable = true
      }
    },
    checkFile(e) {
      this.selectedFile = e.target.files[0];
      if(this.selectedFile !== null){
        this.errorMessage7 = null
      }
      this.file_uri = URL.createObjectURL(e.target.files[0]);
    },
    validate(input) {
      let reqWhiteSpace = /\d/;
      if (input === "destination") {
        this.errorMessage1 = null;
        if (this.destination === "" || this.destination === null) {
          this.errorMessage1 = "Destination is Required";
        } else {
          this.errorMessage1 = null;
        }
      }else if (input === "cover") {
        this.errorMessage2 = null;
        if (this.employee_to_cover === "" || this.employee_to_cover === null) {
          this.errorMessage2 = "Employee to cover is Required";
        } else {
          this.errorMessage2 = null;
        }
      }else if (input === "date") {
        this.errorMessage3 = null;
        if (this.start_date === "" || this.start_date === null) {
          this.errorMessage3 = "Start date is Required";
        } else {
          this.errorMessage3 = null;
        }
      }else if (input === "endDate") {
        this.errorMessage4 = null;
        if (this.end_date === "" || this.end_date === null) {
          this.errorMessage4 = "End date is Required";
        } else {
          this.errorMessage4 = null;
        }
      } else if (input === "contactNumber") {
        this.errorMessage5 = null;
        if(this.contact_number === '' || this.contact_number === null){
          this.errorMessage5 = "Contact number is required";
        }else if (this.contact_number.length > 11) {
          this.errorMessage5 = "Contact Number is exceed 11 numbers";
        } else if (this.contact_number.length === 0) {
          this.errorMessage5 = "Contact number is required";
        } else if (this.contact_number.slice(0, 2) != "09") {
          this.errorMessage5 = "Contact number must start with 09";
        } else if (this.contact_number.length <= 10) {
          this.errorMessage5 = "Contact number is invalid";
        } else {
          this.errorMessage5 = null;
        }
      } else if(input === 'contactPerson'){
        this.errorMessage6 = null;
        if(this.emergency_contact === '' || this.emergency_contact === null){
          this.errorMessage6 = 'Contact person is required'
        } else if (reqWhiteSpace.test(this.emergency_contact)){
          this.errorMessage6 = 'Contact person must not include digits'
        } else {
          this.errorMessage6 = null
        }
      }
    },
    createTravel() {
      this.validate('destination')
      this.validate('cover')
      this.validate('date')
      this.validate('endDate')
      this.validate('contactNumber')
      this.validate('contactPerson')
      if(this.selectedFile === null){
        this.errorMessage7 = 'Image is required'
      }
      if (
        this.errorMessage1 === null &&
        this.errorMessage2 === null &&
        this.errorMessage3 === null &&
        this.errorMessage4 === null &&
        this.errorMessage5 === null &&
        this.errorMessage6 === null &&
        this.errorMessage7 === null
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
        formData.append("contact_number", this.contact_number);
        formData.append("prp_assigned_id", 1);
        this.$axios
          .post("travel_auth_request", formData, config)
          .then(res => {
            this.$parent.$parent.$parent.$parent.$parent.retrieve();
          });
        this.dialog = false;
        this.error = false;
        this.val = false;
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
          response.data.forEach(element => {
            this.coDepartment.push(element)
          })
      })
    },
    removeData() {
      this.destination = '',
      this.employee_to_cover = '',
      this.start_date = null,
      this.end_date = null,
      this.emergency_contact = '',
      this.prp_assigned_id = null;
      this.selectedFile = null
      this.contact_number = ''
      this.errorMessage1 = null
      this.errorMessage2 = null
      this.errorMessage3 = null
      this.errorMessage4 = null
      this.errorMessage5 = null
      this.errorMessage6 = null
      this.errorMessage7 = null
      this.changeDate();
    }
  }
};
</script>
