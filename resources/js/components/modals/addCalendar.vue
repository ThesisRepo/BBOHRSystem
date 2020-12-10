<template>
  <v-row justify='end' id="move">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat>
          <v-card-title>
            <span class="headline-bold">ADD EVENT</span>
          </v-card-title>
        </v-toolbar>
        <v-card-text>
          <v-container>
            <span v-if="error" style="color: red; font-size: 13px">All data are required</span>
            <span v-if="errorMessage1" style="color: red; font-size: 13px">{{ errorMessage1 }}</span>
            <v-row>
              <v-col cols="12" sm="6">
                <v-text-field label="Title*" v-model="title" autocomplete="off" @keyup="validate('title')" required></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-select label="Event Type*" :items="event_types" item-text="event_name" item-value="id"  @keyup="validate('event')" v-model="event_type" required></v-select>
              </v-col>
              <v-col cols="12">
                <!-- <v-text-field label="Content*" v-model="content" required></v-text-field> -->
                <v-textarea
                  outlined
                  label="Details*"
                  v-model="content"
                  @keyup="validate('details')"
                  rows="3"
                  required
                ></v-textarea>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field label="Start Date & Time" type="datetime-local" v-model="start_date" :allowed-dates="disabledDates" @change="changeDate()" color="primary"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field label="End Date & Time" type="datetime-local" :allowed-dates="disabledDates2" v-model="end_date" @change="changeDate()" color="primary"></v-text-field>
              </v-col>
              <span
                v-if="error1"
                class="ml-7"
                style="color: red; font-size: 13px"
              >Higher the End Date</span>
              <v-col cols="12" v-if="user_type.includes('hr mngr')">
                <v-checkbox
                  v-model="checkbox"
                  label="Public"
                ></v-checkbox>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red" dark @click="dialog = false">Cancel</v-btn>
          <v-btn color="success" @click="save()">Add</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<style>
#move{
  margin-right: 3%;
}
</style>

<script>
import moment from 'moment'
export default {
  data: () => ({
    user_type: localStorage.getItem("user_type"),
    dialog: false,
    user_id: localStorage.getItem("id"),
    start_date: '',
    end_date: '',
    time: '',
    content: '',
    event_type: '',
    title: '',
    checkbox: false,
    error: false,
    error1: false,
    errorMessage1: null,
    event_types: [],
    retrieveRequest: []
  }),
  mounted() {
    this.getEventType()
  },
  methods: {
    validate(item){
      if(item === 'title'){
        if(this.title === '' || this.title === null){
          this.errorMessage1 = 'Title field is required'
        }else{
          this.errorMessage1 = null
        }
      }else if(item === 'event'){
        if(this.event_type === '' || this.event_type === null){
          this.errorMessage1 = 'Event type field is required'
        }else{
          this.errorMessage1 = null
        }
      }else if(item === 'details'){
        if(this.content === '' || this.content === null){
          this.errorMessage1 = 'Content field is required'
        }else{
          this.errorMessage1 = null
        }
      }
    },
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
    show(){
      this.error = false,
      this.error1 = false,
      this.errorMessage1 = null,
      this.dialog = true
      this.title = '',
      this.start_date = '',
      this.end_date = '',
      this.content = '',
      this.checkbox = '',
      this.event_type = ''
      this.getEventType()
    },
    save(){
      this.validate('title')
      this.validate('event')
      this.validate('details')
      if(this.user_type === 'hr mngr') {
        let params = {
          title: this.title,
          start_date: this.start_date,
          end_date: this.end_date,
          content: this.content,
          is_public: this.checkbox,
          event_type_id: this.event_type,
          user_id: this.user_id
        }
        if (
          this.title !== '' &&
          this.start_date !== '' &&
          this.end_date !== '' &&
          this.content !== '' &&
          this.event_type !== '' &&
          this.error1 === false &&
          this.errorMessage1 === null
        ){
          this.$axios.post("events", params).then(response => {
            this.$parent.$parent.retrieve()
            this.dialog = false
          })
        } else {
          this.errorMessage1 = "Please fill up all fields";
        }
      }else {
        let parameter = {
          title: this.title,
          start_date: this.start_date,
          end_date: this.end_date,
          content: this.content,
          is_public: 1,
          event_type_id: this.event_type,
          user_id: this.user_id
        }
        if (
          this.title !== '' &&
          this.start_date !== '' &&
          this.end_date !== '' &&
          this.content !== '' &&
          this.event_type !== '' &&
          this.error1 === false &&
          this.errorMessage1 === null
        ){
          this.$axios.post("events", parameter).then(response => {
            this.$parent.$parent.retrieve()
            this.dialog = false
          })
        } else {
          this.errorMessage1 = "Please fill up all fields";
        }
      }
    },
    getEventType(){
      this.event_types = []
      this.$axios.get("user_info/event_types/" + this.user_id).then(response => {
        response.data.event_types.forEach(element => {
          this.event_types.push(element)
        })
      })
    }
  }
};
</script>
