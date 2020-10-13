<template>
  <v-row>
    <v-container cols="4">
      <v-col>
        <v-card class="mx-auto pa-2">
          <v-card-title>
            <span class="headline primary--text">USER PROFILE</span>
          </v-card-title>
          <v-divider></v-divider>
          <v-row>
            <v-col cols="12" sm="4" md="4">
              <v-avatar
                class="ml-15"
                color="grey darken-1"
                size="200"
              ></v-avatar>
              <v-col>
                <v-btn color="primary" class="ml-16"> Change Profile </v-btn>
              </v-col>
            </v-col>
            <v-col>
              <h1 class="title-h3 text-md-h3 text-sm-h3 text-truncate mt-8">
                {{ user_name }}
              </h1>
              <h2 class="title-h5 text-md-h5 text-sm-h5 text-truncate">
                PHP Developer
              </h2>

              <h3
                class="text--primary text-caption text-sm-body-2 text-md-body-1"
              >
                Company Email: {{ user_email }}
              </h3>
              <span
                class="text--primary text-caption text-sm-body-2 text-md-body-1"
              >
                Id Number: {{ company_number }}
              </span>
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
                    label="Department"
                    outlined
                    readonly
                    v-model="department"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" sm="4" md="4">
                  <v-text-field
                    v-model="date_hired"
                    label="Type of Employee"
                    outlined
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="4">
                  <v-text-field
                    v-model="date_hired"
                    label="Date Hired"
                    outlined
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="3">
                  <v-text-field
                    v-model="address"
                    label="Address"
                    outlined
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="3">
                  <v-text-field
                    v-model="status"
                    label="Status"
                    outlined
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="3">
                  <v-text-field
                    v-model="birthdate"
                    label="Birthdate"
                    outlined
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="3">
                  <v-text-field
                    v-model="contact_number"
                    label="Contact Number"
                    outlined
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="3" md="3">
                  <v-text-field
                    v-model="pag_ibig"
                    label="PagIbig Number"
                    outlined
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="3" md="3">
                  <v-text-field
                    v-model="tin_number"
                    label="Tin Number"
                    outlined
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="3" md="3">
                  <v-text-field
                    v-model="philhealth_num"
                    label="PhilHealth Number"
                    outlined
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="3" md="3">
                  <v-text-field
                    v-model="sss_num"
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
<script>
import editProfile from "./modals/edit_profile.vue";
export default {
  data() {
    return {
      user_name: localStorage.getItem("user_name"),
      user_id: localStorage.getItem("id"),
      user_email: localStorage.getItem("email"),
      company_number: localStorage.getItem("company_id"),
      dialog: false,
      department: null,
      position: null,
      date_hired: null,
      address: null,
      status: null,
      birthdate: null,
      contact_number: null,
      pag_ibig: null,
      tin_number: null,
      philhealth_num: null,
      sss_num: null,
    };
  },
  mounted() {
    this.getInfo();
  },
  components: {
    editProfile,
  },
  methods: {
    getInfo() {
      axios
        .get("http://localhost:8000/user_info/1")
        .then((response) => {
          console.log(response);
          this.position = response.data.company_position;
          this.date_hired = response.data.date_hired;
          this.address = response.data.address;
          this.status = response.data.civil_status;
          this.birthdate = response.data.birthday;
          this.contact_number = response.data.contact_number;
          this.pag_ibig = response.data.pag_ibig_number;
          this.tin_number = response.data.tin_number;
          this.philhealth_num = response.data.philhealth_number;
          this.sss_num = response.data.sss_number;
          console.log(
            "-----------test-----------",
            this.position,
            this.date_hired
          );
        })
        .catch((e) => {
          console.log(e);
        });
    },
    editProfile() {
      this.userInfo = userInfo;
    },
  },
};
</script>