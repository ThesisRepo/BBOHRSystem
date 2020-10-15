<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="primary" dark v-bind="attrs" v-on="on">
          Make Request
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Overtime Request Form</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" md="6">
                <v-menu
                  :close-on-content-click="false"
                  :return-value.sync="date"
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
              <v-spacer></v-spacer>
              <v-col cols="12" sm="6" md="6">
                <v-select
                  :items="[
                    'Marion Jay Balugo',
                    'Cherry Mae Herrera',
                    'Marvie Cauyan',
                    'Jessavel Toring',
                  ]"
                  label="PRP in Charge*"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field
                  label="Start Time*"
                  type="time"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field
                  label="End Time*"
                  type="time"
                  required
                ></v-text-field>
              </v-col>
              <v-col
                cols="12">
                <v-select
                  :items="['Jocel Redotco Mendoza', 'Fenella Corinne Real Rosales', 'Cielo Fe Sasing', 'April Claire Chagas Podador', 'Nathaniel Cala Terdes', 'Carl Wyner Velasco Javier']"
                  label="PRP in Charge*"
                  required
                ></v-select>
              </v-col>
            </v-row>
          </v-container>
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
    }),
    methods: {
      disabledDates(date) {
        return date >  new Date().toISOString().substr(0, 10)
      }
    }
  }
</script>