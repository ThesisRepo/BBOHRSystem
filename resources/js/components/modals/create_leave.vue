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
            <span class="headline-bold">LEAVE REQUEST FORM</span>
          </v-card-title>
        </v-toolbar>
        <v-card-text>
          <v-container>
            <span v-if="error" style="color: red; font-size: 13px">All data are required</span>
            <span v-if="errorMessage1" style="color: red; font-size: 13px">{{ errorMessage1 }}</span>
            <v-tabs
            dark
            background-color="primary"
            fixed-tabs
            >
                <v-tabs-slider></v-tabs-slider>
                <v-tab @click="half = false, whole = true">Whole Day</v-tab>
                <v-tab @click="whole = false, half = true">Half Day</v-tab>
            </v-tabs>
            <v-row v-if="whole">
              <v-col cols="12">
                <v-select
                  :items="leaveType"
                  label="Reason*"
                  v-model="selectedLeaveType"
                  item-text="name"
                  item-value="value"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" sm="4">
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
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="start_date"
                    :allowed-dates="disabledDates"
                    no-title
                    scrollable
                    color="primary"
                    @change="changeDate()"
                  ></v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="12" sm="4">
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
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                      :disabled="disable"
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
                <span
                  v-if="error1"
                  class="ml-7"
                  style="color: red; font-size: 13px"
                >Higher the End Date</span>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  label="Total Day/s of Leave*"
                  type="text"
                  v-model="total_days_with_text"
                  disabled
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row v-if="half">
              <v-col cols="12">
                <v-select
                  :items="leaveType"
                  label="Reason*"
                  v-model="selectedLeaveType"
                  item-text="name"
                  item-value="value"
                  required
                ></v-select>
              </v-col>
              <v-col cols="6">
                <v-select
                  :items="halfSched"
                  label="Time*"
                  v-model="selectedLeaveType"
                  item-text="name"
                  item-value="value"
                  required
                ></v-select>
              </v-col>
              <v-col cols="6">
                <v-text-field
                  label="Total Day/s of Leave*"
                  type="text"
                  v-model="half_days_with_text"
                  disabled
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red" dark @click="hideModal()">Cancel</v-btn>
          <v-btn color="success" @click="createRequest()">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
import moment from "moment";
export default {
  data() {
    return {
      whole: true,
      half: false,
      selectedLeaveType: null,
      error: false,
      prp_assigned_id: localStorage.getItem("assigned_prp_id"),
      error1: false,
      disable: true,
      errorMessage1: null,
      leaveType: [
        { value: 1, name: "Sick Leave" },
        { value: 2, name: "Solo Parent Leave" },
        { value: 3, name: "Vacation Leave" },
        { value: 4, name: "Emergency Leave" },
        { value: 5, name: "Paternity Leave" },
        { value: 6, name: "Maternity Leave" }
      ],
      halfSched: [
        {value: 1, name: "10am-2pm"}, 
        {value: 2, name: "2am-7pm"}
      ],
      dialog: false,
      reason: null,
      total_days: null,
      total_days_with_text: null,
      half_days_with_text: 0.5 + ' ' + 'days of leave',
      start_date: null,
      end_date: null,
      differenceInDay: null,
      user_id: localStorage.getItem("id")
    };
  },
  mounted() {},
  methods: {
    changeDate() {
      if (this.start_date !== null && this.start_date !== "") {
        let start = moment(String(this.start_date));
        let end = moment(String(this.end_date));
        if (end >= start) {
          let diff = end.diff(start);
          let differenceInDay = diff / 1000 / 60 / 60 / 24;
          this.total_days = differenceInDay;
          this.total_days_with_text = differenceInDay + " days of leave";
          this.error1 = false;
          if (diff == 0) {
            this.error1 = true;
          }
        } else {
          this.error1 = true;
        }
        this.disable = false;
      } else {
        this.disable = true;
      }
    },
    hideModal() {
      this.dialog = false;
      this.error = false;
    },
    disabledDates(date) {
      return date > new Date().toISOString().substr(0, 10);
    },
    disabledDates2(date) {
      return date > new Date(this.start_date).toISOString().substr(0, 10);
      this.differenceDates();
    },
    differenceDates() {
      let start = moment(String(this.start_date));
      let end = moment(String(this.end_date));
      let diff = end.diff(start);
      let differenceInDay = diff / 1000 / 60 / 60 / 24;
      this.differenceInDay = differenceInDay;
    },
    createRequest() {
      if (
        this.selectedLeaveType !== null &&
        this.total_days !== null &&
        this.start_date !== null &&
        this.end_date !== null &&
        this.error1 === false
      ) {
        let params = {
          user_id: this.user_id,
          leave_type_id: this.selectedLeaveType,
          start_date: this.start_date,
          end_date: this.end_date,
          number_of_days: this.total_days,
          prp_assigned_id: this.prp_assigned_id
        };
        this.$axios.post("leave_request", params).then(res => {
          // console.log("Successfully Added");
          this.$parent.$parent.$parent.$parent.$parent.retrieve();
          // this.error = false;
          this.dialog = false;
        });
      } else if (
        this.selectedLeaveType === null ||
        this.total_days === null ||
        this.start_date === null ||
        this.end_date === null
      ) {
        this.error = true;
      } else {
        this.errorMessage1 = "Please fill valid information";
      }
    },
    removeData() {
      (this.selectedLeaveType = null),
        (this.total_days = null),
        (this.total_days_with_text = null),
        (this.start_date = null),
        (this.end_date = null),
        (this.error = null),
        (this.errorMessage1 = null);
    }
  }
};
</script>
