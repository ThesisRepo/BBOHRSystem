<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <template v-slot:activator="{ on, attrs }">
        <v-col cols="12" sm="4" md="4" >
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
        </v-col>
      </template>
      <v-card>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat>
          <v-card-title>
            <span class="headline-bold">BUDGET REQUEST FORM</span>
          </v-card-title>
        </v-toolbar>
        <v-card-text>
          <v-container>
            <span v-if="error" style="color: red; font-style: italic">All data are required!</span>
            <v-row>
              <v-col cols="12" sm="12">
                <v-text-field label="Details*" v-model="details" required></v-text-field>
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
                  prefix="₱"
                  required
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red" dark @click="dialog = false">
            Cancel
          </v-btn>
          <v-btn color="success"  @click="createBudget()">
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
    details: null,
    total_amount: null,
    user_department: localStorage.getItem("user_department"),
    user_id: localStorage.getItem("id")
  }),
  methods: {
    disabledDates(date) {
      return date > new Date().toISOString().substr(0, 10);
    },
    createBudget(){
        if(this.date !== null && this.details !== null &&
        this.total_amount !== null && this.date !== '' &&
        this.total_amount !== '' && this.details !== ''){
          let parameter = {
            user_id: this.user_id,
            date: this.date,
            department_id: this.user_department,
            details: this.details,
            total_amount: this.total_amount,
            finance_mngr_assigned: this.user_finance
          }
          this.$axios.post("budget_request", parameter).then(res =>{
            this.$parent.$parent.$parent.$parent.$parent.retrieve()
            this.dialog = false
          })
        }else{
          this.error = true
          this.dialog = true
        }
      },
      removeData(){
        this.date = null,
        this.details = null,
        this.total_amount = null
      }
  }
  }
</script>