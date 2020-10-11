<template>
  <v-row>
    <v-container cols="4">
      <v-col>
        <v-card class="mx-auto pa-2">
          <v-card-title>
            <span
              class="headline"
              color="blue lighten-3
"
              >USER PROFILE</span
            >
          </v-card-title>
          <v-divider></v-divider>
          <v-row>
            <v-col cols="12" sm="4" md="4">
              <v-avatar
                class="ml-15"
                color="grey darken-1"
                size="190"
              ></v-avatar>
              <v-col>
                <v-btn color="primary" class="ml-16"> Change Profile </v-btn>
              </v-col>
            </v-col>
            <v-col cols="12" sm="4" md="4" pa="3">
              <h1 class="title-2 text-center mt-10 ">Marion Jay Balugo</h1>
              <h5 class="title-2 text-center">
                Company Email: mbalugo@bbo.com
              </h5>
              <h6 class="subtitle-2 text-center">Id Number: 260197300</h6>
            </v-col>
            <v-col cols="12" sm="4" md="4" class="text-right">
              <editProfile></editProfile>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-container>
    <v-container cols="8">
      <v-col>
        <v-card>
          <v-card-text>
            <br />
            <v-container>
              <v-row>
                <v-col cols="12" sm="4" md="4">
                  <v-text-field
                    value="Web Integration"
                    label="Department"
                    outlined
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="4">
                  <v-text-field
                    value="Computer Engineer"
                    label="Position"
                    outlined
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="4">
                  <v-text-field
                    value="07/10/2020"
                    label="Date Hired"
                    outlined
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="3">
                  <v-text-field
                    value="Lapu-Lapu City"
                    label="Address"
                    outlined
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="3">
                  <v-text-field
                    value="Single"
                    label="Status"
                    outlined
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="3">
                  <v-text-field
                    value="December 24,1997"
                    label="Birthdate"
                    outlined
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="3">
                  <v-text-field
                    value="09102957389"
                    label="Contact Number"
                    outlined
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="3" md="3">
                  <v-text-field
                    value="4204223242"
                    label="PagIbig Number"
                    outlined
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="3" md="3">
                  <v-text-field
                    value="4204223242"
                    label="Tin Number"
                    outlined
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="3" md="3">
                  <v-text-field
                    value="4204223242"
                    label="PhilHealth Number"
                    outlined
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="3" md="3">
                  <v-text-field
                    value="4204223242"
                    label="SSS Number"
                    outlined
                    readonly
                  ></v-text-field>
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
</style>
</style>
<script>
import editProfile from "./modals/edit_profile.vue";
export default {
  data: () => ({
    dialog: false,
  }),
  components: {
    editProfile,
  },
};
</script>
