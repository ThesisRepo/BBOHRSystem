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
            <v-row>
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

              <!-- <v-col cols="12" sm="4">
                <v-text-field label="Start Date" type="datetime-local" v-model="start_date" :allowed-dates="disabledDates" @change="changeDate()" color="primary"></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field label="End Date" type="datetime-local" :allowed-dates="disabledDates2" v-model="end_date" @change="changeDate()" color="primary"></v-text-field>
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
              </v-col> -->
              <v-col cols="12" >
                <v-text-field label="Start Date" type="datetime-local" v-model="start_date" :allowed-dates="disabledDates" @change="changeDate()" color="primary"></v-text-field>
              </v-col>
              <v-col cols="12" >
                <v-text-field label="End Date" type="datetime-local" :allowed-dates="disabledDates2" v-model="end_date" @change="changeDate()" color="primary"></v-text-field>
                <span
                  v-if="error1"
                  class="ml-7"
                  style="color: red; font-size: 13px"
                >Higher the End Date</span>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  label="Total duration of Leave*"
                  type="text"
                  v-model="total_days_with_text"
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
      selectedLeaveType: null,
      start_time: null,
      end_time: null,
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
      dialog: false,
      reason: null,
      total_days: null,
      total_days: null,
      total_days_with_text: null,
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
          // let differenceInDay = Math.floor(diff / 1000 / 60 / 60 / 24) + ((diff / 1000 / 60 / 60 % 24) * 60);
          // alert(differenceInDay * 24 );
          // alert(  differenceInDay * 24- Math.trunc(differenceInDay * 24) );
          this.total_days = differenceInDay
          // console.log(this.total_days)
          // this.total_days_with_text = differenceInDay.toFixed(2) < 0.5 ? ((differenceInDay.toFixed(2))*24) + " hours of leave" : differenceInDay.toFixed(1) + "days of leave";
          // this.total_days_with_text = differenceInDay.toFixed(2) < 0.5 ? ((differenceInDay.toFixed(2))*24) + " hours of leave" : differenceInDay.toFixed(1) + "days of leave";
          this.total_days_with_text = this.displayTimeLengthInText(differenceInDay);
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

    displayTimeLengthInText(num) {
          var item= {
            number_of_days: num
          }
          return item.number_of_days >= 1 ? 

          // true

          Math.floor(item.number_of_days) == item.number_of_days ? 
            Math.floor(item.number_of_days) > 1 ? 
            // true
              Math.floor(item.number_of_days) + ' ' + 'days' 
            : 
              Math.floor(item.number_of_days) + ' ' + 'day' 

            : 
            // false
              Math.floor(item.number_of_days) > 1 ?

                Math.round(item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 )) >= 1 ? 
                  Math.round(item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 )) > 1 ? 
                    Math.round((item.number_of_days  * 24- Math.trunc(item.number_of_days  * 24 )) * 60) > 1 ? 
                    // hours and minute/s
                
                      Math.floor(item.number_of_days) + ' ' + 'days' + ', ' + Math.round(item.number_of_days  * 24- Math.trunc(item.number_of_days  * 24 )) + ' hours and ' + Math.round((item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 ) ) * 60) + ' ' + 'mins' 
                    : 
                      Math.floor(item.number_of_days) + ' ' + 'days' + ', ' + Math.round(item.number_of_days  * 24- Math.trunc(item.number_of_days  * 24 )) + ' hours and ' + Math.round((item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 ) ) * 60) + ' ' + 'min' 
                  :
                  // hour and minute/s
                      Math.round((item.number_of_days  * 24- Math.trunc(item.number_of_days  * 24 )) * 60) > 1 ? 
                       Math.floor(item.number_of_days) + ' ' + 'days' + ', ' + Math.round(item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 )) + ' hour and ' + Math.round((item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 ) ) * 60) + ' ' + 'mins' 
                    : 
                      Math.floor(item.number_of_days) + ' ' + 'days' + ', ' +  Math.round(item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 )) + ' hour and ' + Math.round((item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 ) ) * 60) + ' ' + 'min' 
                      
                :
                  // minutes
                  Math.round((item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 )) * 60) > 1 ? 
                    Math.floor(item.number_of_days) + ' ' + 'days' + ' and ' + Math.round((item.number_of_days  * 24- Math.trunc(item.number_of_days  * 24 )) * 60) + ' ' + 'mins' 
                  : 
                    Math.floor(item.number_of_days) + ' ' + 'days' + ' and ' + Math.round((item.number_of_days  * 24- Math.trunc(item.number_of_days  * 24 )) * 60) + ' ' + 'min' 
              : 

                Math.round(item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 )) >= 1 ? 
                  Math.round(item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 )) > 1 ? 
                    Math.round((item.number_of_days  * 24- Math.trunc(item.number_of_days  * 24 )) * 60) > 1 ? 
                    // hours and minute/s
                
                      Math.floor(item.number_of_days) + ' ' + 'day' + ', ' + Math.round(item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 )) + ' hours and ' + Math.round((item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 ) ) * 60) + ' ' + 'mins' 
                    : 
                      Math.floor(item.number_of_days) + ' ' + 'day' + ', ' + Math.round(item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 )) + ' hours and ' + Math.round((item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 ) ) * 60) + ' ' + 'min' 
                  :
                  // hour and minute/s
                      Math.round((item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 )) * 60) > 1 ? 
                       Math.floor(item.number_of_days) + ' ' + 'day' + ', ' + Math.round(item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 )) + ' hour and ' + Math.round((item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 ) ) * 60) + ' ' + 'mins' 
                    : 
                      Math.floor(item.number_of_days) + ' ' + 'day' + ', ' +  Math.round(item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 )) + ' hour and ' + Math.round((item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 ) ) * 60) + ' ' + 'min' 
                      
                :
                  // minutes
                  Math.round((item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 )) * 60) > 1 ? 
                    Math.floor(item.number_of_days) + ' ' + 'day' + ' and ' + Math.round((item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 )) * 60) + ' ' + 'mins' 
                  : 
                    Math.floor(item.number_of_days) + ' ' + 'day' + ' and ' + Math.round((item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 )) * 60) + ' ' + 'min' 
              

          // false

        :
          Math.round(item.number_of_days  * 24) >= 1 ? 
            Math.round(item.number_of_days  * 24) > 1 ? 
              Math.round((item.number_of_days  * 24- Math.trunc(item.number_of_days  * 24 )) * 60) > 1 ? 
              // hours and minute/s
                Math.round(item.number_of_days  * 24) + ' hours and ' + Math.round((item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 ) ) * 60) + ' ' + 'mins' 
              : 
                Math.round(item.number_of_days  * 24) + ' hours and ' + Math.round((item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 ) ) * 60) + ' ' + 'min' 
            :
            // hour and minute/s
                Math.round((item.number_of_days  * 24- Math.trunc(item.number_of_days  * 24 )) * 60) > 1 ? 
                Math.round(item.number_of_days  * 24) + ' hour and ' + Math.round((item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 ) ) * 60) + ' ' + 'mins' 
              : 
                Math.round(item.number_of_days  * 24) + ' hour and ' + Math.round((item.number_of_days  * 24 - Math.trunc(item.number_of_days  * 24 ) ) * 60) + ' ' + 'min' 
                
          :
            // minutes
            Math.round((item.number_of_days  * 24) * 60) > 1 ? 
              Math.round((item.number_of_days  * 24) * 60) + ' ' + 'mins' 
            : 
              Math.round((item.number_of_days  * 24) * 60) + ' ' + 'min' 
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
