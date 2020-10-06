<template>
  <v-row>
    <v-container cols="4">
      <v-col>
        <v-card class="mx-auto">
          <v-card-title>
            <span class="headline">USER PROFILE</span>
          </v-card-title>

          <v-list-item>
            <v-list-item-content>
              <v-list-item-title class="title">
                Marion Jay Balugo Gwapo
              </v-list-item-title>
              <v-list-item-subtitle>Network Engineer</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-card>
      </v-col>
    </v-container>
    <v-container cols="8">
      <v-col>
        <v-card>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12" sm="4" md="4">
                  <v-text-field label="Position*" required></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="4">
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
                        label="Date Hired*"
                        required
                        persistent-hint
                        prepend-icon="mdi-calendar"
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
                <v-col cols="12" sm="4" md="4">
                  <v-text-field
                    label="Contact Number*"
                    persistent-hint
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="4">
                  <v-text-field label="Address" required></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="4">
                  <v-select
                    :items="['Single', 'Married', 'Widowed', 'Separated']"
                    label="Status*"
                    required
                  ></v-select>
                </v-col>
                <v-col cols="12" sm="4" md="4">
                  <v-menu
                    v-model="menu2"
                    :close-on-content-click="false"
                    transition="scale-transition"
                    offset-y
                    max-width="290px"
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                        v-model="computedDateFormatted"
                        label="Date of Birth*"
                        persistent-hint
                        prepend-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                      ></v-text-field>
                    </template>
                    <v-date-picker
                      v-model="date"
                      no-title
                      @input="menu2 = false"
                    ></v-date-picker>
                  </v-menu>
                </v-col>
                <v-col cols="12" sm="3" md="3">
                  <v-text-field label="PagIbig No.*" required></v-text-field>
                </v-col>
                <v-col cols="12" sm="3" md="3">
                  <v-text-field label="Tin No.*" required></v-text-field>
                </v-col>
                <v-col cols="12" sm="3" md="3">
                  <v-text-field label="PhilHealth No." required></v-text-field>
                </v-col>
                <v-col cols="12" sm="3" md="3">
                  <v-text-field label="SSS No." required></v-text-field>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="dialog = false">
              Cancel
            </v-btn>
            <v-btn color="blue darken-1" text @click="dialog = false">
              Update
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-container>
  </v-row>
</template>
<style scoped>
v-card {
  margin-top: 10%;
}
</style>
</style>
<script>
export default {
  data: () => ({
    dialog: false,
  }),
};
</script>