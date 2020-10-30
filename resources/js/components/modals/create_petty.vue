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
          <span class="headline">Petty Cash Request Form</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <span v-if="error" style="color: red; font-style: italic">All data are required!</span>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  label="Description of Need*"
                  v-model="description_need"
                  required
                ></v-text-field>
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
              <v-col cols="12" sm="6">
                <v-text-field
                  label="Total Amount*"
                  type="number"
                  v-model="total_amount"
                  required
                ></v-text-field>
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
          <v-btn color="blue darken-1" text @click="createPetty()">
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
    error: false,
    user_finance: localStorage.getItem("user_finance"),
    date: null,
    department: null,
    description_need: null,
    total_amount: null,
    user_department: localStorage.getItem("user_department"),
    user_id: localStorage.getItem("id")
  }),
  mounted(){
  },
  methods: {
    disabledDates(date) {
      return date > new Date().toISOString().substr(0, 10);
    },
    createPetty(){
      if(this.date !== null && this.description_need !== null &&
      this.total_amount !== null && this.date !== '' && this.description_need !== '' &&
      this.total_amount !== ''){
        let parameter = {
          user_id: this.user_id,
          date: this.date,
          description_need: this.description_need,
          department_id: this.user_department,
          total_amount: this.total_amount,
          finance_mngr_assigned: user_finance
        }
        this.$axios.post("http://localhost:8000/petty_cash_request", parameter).then(res =>{
          console.log('Successfully Added', res.data)
          this.$parent.$parent.$parent.$parent.$parent.retrieve()
        })
        this.dialog = false
      }else{
        this.error = true
        this.dialog = true
      }
    },
    removeData(){
      this.date = null,
      this.description_need = null,
      this.total_amount = null
    }
  }
}
</script>
