<template>
  <v-row justify="center">
    <v-dialog scrollable v-model="dialog" persistent max-width="600px">
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
              <span class="headline-bold">CREATE OVERTIME REQUEST</span>
            </v-card-title>
          </v-toolbar>
        <v-card-text>
          <v-container>
            <span v-if="error" style="color: red; font-style: italic">All data are required!</span>
            <v-row>
              <v-col cols="12">
                <v-textarea 
                    clearable
                    clear-icon="mdi-close-circle"
                     label="Reason*" 
                     v-model="reason"
                      required>
                </v-textarea>
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
                      v-model="overtime_date"
                      label="Date"
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="overtime_date"
                    :allowed-dates="disabledDates"
                    no-title
                    scrollable
                    color="primary"
                  ></v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  label="Start Time*"
                  v-model="start_time"
                  type="time"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  label="End Time*"
                  v-model="end_time"
                  type="time"
                  @change="checkEndTime()"
                  required
                ></v-text-field>
                <span v-if="errorMessage !== null" style="color: red; font-style: italic">{{errorMessage}}</span>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red" dark @click="dialog = false">
            Cancel
          </v-btn>
          <v-btn color="success" @click="createShift()">
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
import moment from "moment";
export default {
  data: () => ({
    errorMessage: null,
    dialog: false,
    overtime_date: null,
    start_time: null,
    end_time: null,
    error: false,
    prp_assigned_id: localStorage.getItem("assigned_prp_id"),
    reason: null,
    user_id: localStorage.getItem("id"),
    totalSeconds1: 0,
    totalSeconds2: 0
  }),
  methods: {
    checkEndTime(){
      var str1 = this.start_time
      var str2 = this.end_time
      str1 =  str1.split(':');
      str2 =  str2.split(':');
      this.totalSeconds1 = parseInt(str1[0] * 3600 + str1[1] * 60 + str1[0]);
      this.totalSeconds2 = parseInt(str2[0] * 3600 + str2[1] * 60 + str2[0]);
      this.totalSeconds1 < this.totalSeconds2 ? this.errorMessage = null : this.errorMessage = 'End time must be higher than the start time'
    },
    disabledDates(date) {
      return date > new Date().toISOString().substr(0, 10);
    },
    createShift(){
      if(this.date !== null && this.date !== '' && this.start_time !== null && this.start_time !== '' &&
      this.end_time !== null && this.end_time !== '' && this.reason !== null && this.reason !== '' && this.errorMessage === null){
        let parameter = {
          user_id: this.user_id,
          date: this.overtime_date,
          start_time: this.start_time,
          end_time: this.end_time,
          reason: this.reason,
          prp_assigned_id: this.prp_assigned_id
        }
        this.$axios.post("overtime_request", parameter).then(res =>{
          this.$parent.$parent.$parent.$parent.$parent.retrieve()

          this.dialog = false
        })
      }else{
        this.error = true
        this.dialog = true
      }
    },
    removeData(){
      this.reason = null,
      this.start_time = null,
      this.end_time = null,
      this.overtime_date = null
    }
  }
}
</script>