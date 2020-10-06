<template>
  <v-row justify="center">
    <v-dialog
      v-model="dialog"
      persistent
      max-width="600px"
    >
      <template>
        <v-btn
          color="primary"
          dark
          v-model="showDetails"
        >
          Make Request
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Leave Request Form</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col
                cols="12">
                <v-select
                  :items="['Sick Leave', 'Single Parent Leave', 'Vacation Leave', 'Other Leave']"
                  label="Reason*"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  label="Total Day/s of Leave*"
                  type="number"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-menu
                  ref="menu1"
                  v-model="menu1"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  max-width="290px"
                  min-width="290px"
                  margin-left="20px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="dateFormatted"
                      label="Start Date*"
                      required
                      persistent-hint
                      v-bind="attrs"
                      @blur="date = parseDate(dateFormatted)"
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="date"
                    no-title
                    @input="menu1 = false"
                  ></v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="12" sm="4">
                <v-menu
                  ref="menu1"
                  v-model="menu1"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  max-width="290px"
                  min-width="290px"
                  margin-left="20px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="dateFormatted"
                      label="End Date*"
                      required
                      persistent-hint
                      v-bind="attrs"
                      @blur="date = parseDate(dateFormatted)"
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="date"
                    no-title
                    @input="menu1 = false"
                  ></v-date-picker>
                </v-menu>
              </v-col>
              <v-col
                cols="12">
                <v-select
                  :items="['Sick Leave', 'Single Parent Leave', 'Vacation Leave', 'Other Leave']"
                  label="PRP in Charge*"
                  required
                ></v-select>
              </v-col>
              <!-- <v-col cols="12">
                <v-text-field
                  label="Status"
                ></v-text-field>
              </v-col> -->
            </v-row>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="dialog = false"
          >
            Close
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="dialog = false"
          >
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
  }
</script>