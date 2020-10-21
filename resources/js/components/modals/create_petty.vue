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
          <v-toolbar-title style="font-size: 16px">Make Request</v-toolbar-title>
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Petty Cash Request Form</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  label="Description of Need*"
                  v-model="description_need"
                  required
                ></v-text-field>
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
                      v-model="date"
                      label="Date"
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="date"
                    :allowed-dates="disabledDates"
                    no-title
                    scrollable
                    color="primary"
                  ></v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="12" sm="4">
                <v-select
                  :items="departments"
                  label="Department*"
                  v-model="department"
                  item-text="name"
                  item-value="value"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  label="Total Amount*"
                  type="number"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  label="Details*"
                  v-model="details"
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
          <v-btn color="blue darken-1" text @click="dialog = false">
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
    departments: [{value:1, name:'Marketing'}, 
      {value: 2, name:'CS'}, 
      {value: 3, name:'Apps'}, 
      {value: 4, name:'PHP'}, 
      {value: 5, name:'Accounting'},
      {value: 6, name:'Admin'}],
      date: null,
      details: null,
      department: null,
      description_need: null,
      total_amount: null
  }),
  methods: {
    disabledDates(date) {
      return date > new Date().toISOString().substr(0, 10);
    },
    createPetty(){
      let parameter = {
        user_id: this.user_id,
        date: this.date,
        description_need: this.description_need,
        details: this.details,
        department_id: this.department,
        total_amount: this.total_amount,
        prp_assigned_id: 1
      }
      this.$axios.post("http://localhost:8000/petty_cash_request", parameter).then(res =>{
        console.log('Successfully Added', res.data)
        this.retrieve()
      })
    },
    retrieve(){
      this.$axios.post("http://localhost:8000/petty_cash_request/" + this.user_id).then(response =>{
      })
      .catch(e => {
        console.log(e);
      })
    }
  }
}
</script>
