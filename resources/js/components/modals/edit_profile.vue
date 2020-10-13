<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="primary" rounded large dark v-bind="attrs" v-on="on">
          <v-icon left> mdi-pencil </v-icon>
          Edit Profile
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Edit Profile</span>
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" md="4">
                <v-text-field label="Full Name*" v-model="userInfo.name" required ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field label="Position*" v-model="userInfo.position" required></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field label="Address*" v-model="userInfo.address" required></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-select
                  :items="['Single', 'Married', 'Widowed', 'Single-Parent']"
                  label="Status*"
                  v-model="userInfo.status"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field label="Contact No.*" v-model="userInfo.contact_num" required ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field label="PagIbig No.*" v-model="userInfo.pag_ibig" required></v-text-field>
              </v-col>
               <v-col cols="12" sm="6" md="4">
                <v-text-field label="SSS No.*" v-model="userInfo.sss_num" required></v-text-field>
              </v-col>
               <v-col cols="12" sm="6" md="4">
                <v-text-field label="Tin No.*" v-model="userInfo.tin_num" required></v-text-field>
              </v-col>
               <v-col cols="12" sm="6" md="4">
                <v-text-field label="PhilHealth No.*" v-model="userInfo.philhealth" required></v-text-field>
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
    
  }
};
</script>