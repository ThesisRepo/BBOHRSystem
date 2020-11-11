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
         <v-toolbar class="mb-2" color="blue darken-1" dark flat>
            <v-card-title>
              <span class="headline-bold">SHIFT CHANGE REQUEST FORM</span>
            </v-card-title>
          </v-toolbar>
        <v-card-text>
          <v-container>
            <span v-if="error" style="color: red; font-style: italic">All data are required!</span>
            <v-row>
              <v-col cols="12">
                <v-text-field label="Reason*" v-model="reason" required></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-menu
                  :close-on-content-click="true"
                  transition="scale-transition"
                  offset-y
                  min-width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="shift_date"
                      label="Shift Date"
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                      color="primary"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="shift_date"
                    :allowed-dates="disabledDates"
                    no-title
                    scrollable
                    color="primary"
                  ></v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="12" sm="6">
                <v-select
                  :items="this.sTime"
                  label="Shift Time*"
                  item-text="shift_time_name"
                  item-value="id"
                  v-model="shift_time"
                  required
                ></v-select>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red" dark @click="dialog = false"
            >Close</v-btn
          >
          <v-btn color="success" @click="dialog = false, createShift()">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
export default {
  data: () => ({
    dialog: false,
    error: false,
    sTime: null,
    shift_date: null,
    shift_time: null,
    reason: null,
    prp_assigned_id: localStorage.getItem("assigned_prp_id"),
    user_id: localStorage.getItem("id")
  }),
  mounted(){
    this.getShift()
  },
  methods: {
    disabledDates(date) {
      return date > new Date().toISOString().substr(0, 10);
    },
    hideModal(){
      this.dialog = false
    },
    createShift(){
      if(this.shift_date !== null && this.shift_time !== null && this.reason !== null && this.reason !== ''){
        let parameter = {
          user_id: this.user_id,
          shift_date: this.shift_date,
        shift_time_id: this.shift_time,
          reason: this.reason,
          prp_assigned_id: this.prp_assigned_id
        }
        console.log(parameter)
        this.$axios.post("http://localhost:8000/shift_change_request", parameter).then(res =>{
          this.$parent.$parent.$parent.$parent.$parent.retrieve()
          this.dialog = false
        })
      }else{
        this.error = true
        this.dialog = true
      }
    },
    getShift(){
      this.$axios.get("http://localhost:8000/shift_time").then(response => {
        console.log('hi', response)
        this.sTime = response.data
      })
    },
    removeData(){
      this.reason = null,
      this.shift_time = null,
      this.shift_date = null
    }
  }
}
</script>
