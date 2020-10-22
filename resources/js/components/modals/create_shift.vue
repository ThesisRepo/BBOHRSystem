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
          <span class="headline">Shift Change Request Form</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field label="Reason*" v-model="reason" required></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-menu
                  :close-on-content-click="false"
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
                <!-- <v-text-field label="Shift Time*" v-model="shift_time" required></v-text-field> -->
                <v-select
                  :items="shiftTime"
                  label="Shift Time*"
                  item-text="time"
                  item-value="value"
                  v-model="shift_time"
                  required
                ></v-select>
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
                  required
                ></v-select>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false"
            >Close</v-btn
          >
          <v-btn color="blue darken-1" text @click="dialog = false, createShift()">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
export default {
  data: () => ({
    dialog: false,
    shift_date: null,
    shift_time: null,
    shiftTime: [{value:1, time:'8 - 5pm'}, 
    {value: 2, time:'9 - 6pm'}, 
    {value: 3, time:'2 - 11pm'}],
    prp_assigned_id: null,
    reason: null,
    user_id: localStorage.getItem("id")
  }),
  methods: {
    disabledDates(date) {
      return date > new Date().toISOString().substr(0, 10);
    },
    createShift(){
      let parameter = {
        user_id: this.user_id,
        shift_date: this.shift_date,
        shift_time: this.shift_time,
        reason: this.reason,
        prp_assigned_id: 1
      }
      this.$axios.post("http://localhost:8000/shift_change_request", parameter).then(res =>{
        console.log('Successfully Added', res.data)
        this.retrieve()
      })
    },
    retrieve(){
      this.$axios.post("http://localhost:8000/shift_change_request/" + this.user_id).then(response =>{
      })
      .catch(e => {
        console.log(e);
      })
    }
  }
}
</script>