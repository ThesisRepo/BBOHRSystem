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
          <v-toolbar-title style="font-size: 16px"
            >Make Request</v-toolbar-title
          >
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Leave Request Form</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <span v-if="error" style="color: red; font-style: italic">All data are required!</span>
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
                <span v-if="error1" style="color: red; font-style: italic">End date must be higher than start date!</span>
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
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  label="Total Day/s of Leave*"
                  type="text"
                  v-model="total_days_with_text"
                  disabled
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-select
                  :items="[
                    'Jocel Redotco Mendoza',
                    'Fenella Corinne Real Rosales',
                    'Cielo Fe Sasing',
                    'April Claire Chagas Podador',
                    'Nathaniel Cala Terdes',
                    'Carl Wyner Velasco Javier',
                  ]" 
                  label="PRP in Charge*"
                  v-model="prp_assigned_id"
                  @click="differenceDates()"
                  required
                ></v-select>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="hideModal()">Close</v-btn>
          <v-btn color="blue darken-1" text @click="createRequest()">Save</v-btn>
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
      error: false,
      error1: false,
      disable: true,
      leaveType: [{value:1, name:'Sick Leave'}, 
      {value: 2, name:'Solo Parent Leave'}, 
      {value: 3, name:'Vacation Leave'}, 
      {value: 4, name:'Emergency Leave'}, 
      {value: 5, name:'Paternity Leave'},
      {value: 6, name:'Maternity Leave'}],
      dialog: false,
      request: [],
      reason: null,
      total_days: null,
      total_days_with_text: null,
      start_date: null,
      end_date: null,
      prp_assigned_id: null,
      differenceInDay: null,
      user_id: localStorage.getItem("id")
    }
  },
  mounted() {
    this.retrieve()
  },
  methods: {
    changeDate(){
      console.log('gawas')
      if(this.start_date !== null && this.start_date !== ''){
        let start = moment(String(this.start_date))
        let end = moment(String(this.end_date))
        if(end >= start){
          let diff = (end.diff(start))
          let differenceInDay = ((((diff/1000)/60)/60)/24)
          this.total_days = differenceInDay
          this.total_days_with_text = differenceInDay + ' days of leave'
          this.error1 = false
        }else{
          this.error1 = true
        }
        this.disable = false
      }else{
        this.disable = true
      }
    },
    hideModal(){
      this.dialog = false
    },
    disabledDates(date) {
      return date > new Date().toISOString().substr(0, 10);
    },
    disabledDates2(date) {
      return date > new Date(this.start_date).toISOString().substr(0, 10);
      this.differenceDates();
    },
    differenceDates() {
      let start = moment(String(this.start_date))
      let end = moment(String(this.end_date))
      let diff = (end.diff(start))
      let differenceInDay = ((((diff/1000)/60)/60)/24)
      console.log('-----------difference',  differenceInDay)
      this.differenceInDay = differenceInDay
    },
    retrieve(){
      this.$axios.get("http://localhost:8000/leave_request/" + this.user_id).then(response => {
      })
      .catch(e => {
        console.log(e);
      })
    },
    createRequest(){
      if(this.selectedLeaveType !== null && this.total_days !== null
      && this.start_date !== null && this.end_date !== null) {
      let params = {
        user_id: this.user_id,
        leave_type_id: this.selectedLeaveType,
        start_date: this.start_date,
        end_date: this.end_date,
        number_of_days: this.total_days,
        prp_assigned_id: 1
      }
      this.$axios.post("http://localhost:8000/leave_request", params).then(res =>{
        console.log('Successfully Added')
        this.retrieve()
        this.dialog = false
      })
    }else {
      this.error = true
      this.dialog = true
      }
    },
    removeData(){
      this.selectedLeaveType = null,
      this.total_days = null,
      this.start_date = null,
      this.end_date = null
    }
  }
}
</script>