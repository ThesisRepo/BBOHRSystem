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
        <v-card-title>
          <span class="headline">Overtime Request Form</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <span v-if="error" style="color: red; font-style: italic">All data are required!</span>
            <v-row>
              <v-col cols="12">
                <v-text-field label="Reason*" v-model="reason" required></v-text-field>
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
                  required
                ></v-select>
              </v-col>
            </v-row>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">
            Close
          </v-btn>
          <v-btn color="blue darken-1" text @click="createShift()">
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
export default {
  data: () => ({
    dialog: false,
    overtime_date: null,
    start_time: null,
    end_time: null,
    error: false,
    prp_assigned_id: localStorage.getItem("assigned_prp_id"),
    reason: null,
    user_id: localStorage.getItem("id")
  }),
  methods: {
    disabledDates(date) {
      return date > new Date().toISOString().substr(0, 10);
    },
    createShift(){
      if(this.date !== null && this.date !== '' && this.start_time !== null && this.start_time !== '' &&
      this.end_time !== null && this.end_time !== '' && this.reason !== null && this.reason !== ''){
        let parameter = {
          user_id: this.user_id,
          date: this.overtime_date,
          start_time: this.start_time,
          end_time: this.end_time,
          reason: this.reason,
          prp_assigned_id: this.prp_assigned_id
        }
        this.$axios.post("http://localhost:8000/overtime_request", parameter).then(res =>{
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
      this.shift_time = null,
      this.shift_date = null
    }
  }
}
</script>