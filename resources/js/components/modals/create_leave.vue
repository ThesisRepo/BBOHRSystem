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
                  :close-on-content-click="false"
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
                  ></v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="12" sm="4">
                <v-menu
                  :close-on-content-click="false"
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
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="end_date"
                    :allowed-dates="disabledDates2"
                    no-title
                    color="primary"
                    scrollable
                  ></v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  label="Total Day/s of Leave*"
                  type="number"
                  v-model="number_of_leave"
                  required
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
          <v-btn color="blue darken-1" text @click="dialog = false, createRequest()">Save</v-btn>
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
      leaveType: [{value:1, name:'Sick Leave'}, 
      {value: 2, name:'Solo Parent Leave'}, 
      {value: 3, name:'Vacation Leave'}, 
      {value: 4, name:'Emergency Leave'}, 
      {value: 5, name:'Paternity Leave'},
      {value: 6, name:'Maternity Leave'}],
      dialog: false,
      request: [],
      reason: null,
      number_of_leave: null,
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
      let params = {
        user_id: this.user_id,
        leave_type_id: this.selectedLeaveType,
        start_date: this.start_date,
        end_date: this.end_date,
        number_of_days: this.number_of_leave,
        prp_assigned_id: 1
      }
      this.$axios.post("http://localhost:8000/leave_request", params).then(res =>{
        console.log('Successfully Added')
        this.retrieve()
        // this.$axios.get("http://localhost:8000/leave_request/" + this.user_id).then(response => {
        //   console.log('hi', response.data)
        // })
        // .catch(e => {
        //   console.log(e);
        // })
      })
    }
  }
}
</script>