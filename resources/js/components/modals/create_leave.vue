<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="light blue darken-2" rounded outlined dark v-bind="attrs" v-on="on">
          <v-icon>mdi-plus</v-icon>
          <v-toolbar-title>Make Request</v-toolbar-title>
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
                  :items="['Sick Leave', 'Solo Parent Leave', 'Vacation Leave', 'Emergency Leave', 'Paternity Leave', 'Maternity Leave']"
                  label="Reason*"
                  v-model="reason"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  label="Total Day/s of Leave*"
                  type="number"
                  v-model="number_of_leave"
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
              <v-col cols="12">
                <v-select
                  :items="['Sick Leave', 'Single Parent Leave', 'Vacation Leave', 'Other Leave']"
                  label="PRP in Charge*"
                  v-model="prp_assigned"
                  required
                ></v-select>
              </v-col>
            </v-row>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
          <v-btn color="blue darken-1" text @click="dialog = false">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
export default {
  data: () => ({
    dialog: false,
    menu1: null,
    reason: null,
    number_of_leave: null,
    start_date: null,
    end_date: null,
    prp_assigned: null
  }),
  methods: {
    disabledDates(date) {
      return date >  new Date().toISOString().substr(0, 10)
    },
    disabledDates2(date) {
      return date >  new Date(this.start_date).toISOString().substr(0, 10)
    },
    differenceDates() {
      var diff = this.end_date - this.start_date
      console.log(diff)
    },
    menu1() {}
  }
};
</script>