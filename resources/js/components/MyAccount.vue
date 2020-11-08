<template>
  <v-row>
    <v-container cols="4">
      <v-col>
        <v-card class="mx-auto" elevation="6">
          <v-card-title class="primary fill-height" >
            <span class="headline white--text">USER PROFILE</span>
          </v-card-title>
          <v-row>
            <v-col>
              <v-avatar v-if="profile_url === null" class="ml-15" size="200">
                <img src="images/user.png" width="100%" height="100%" id="profile">
              </v-avatar>
              <v-avatar v-else class="ml-15" color="grey darken-1" size="200">
                <img :src="profile_url" width="100%" height="100%" id="profile">
              </v-avatar>

              <v-col class="ml-15">
                <v-btn
                  margin
                  color="primary"
                  class="text-none"
                  rounded
                  outlined
                  depressed
                  :loading="isSelecting"
                  @click="onButtonClick"
                >CHANGE PROFILE</v-btn>

                <input
                  ref="uploader"
                  class="d-none"
                  type="file"
                  accept="image/*"
                  @change="onFileChanged"
                >
              </v-col>
            </v-col>
            <v-col>
              <h1 class="title-h4 text-md-h4 text-sm-h4 text-truncate mt-8"><b>{{ user_name }}</b></h1>
              <h2 class="title-h6 text-md-h6 text-sm-h6 text-truncate"><v-icon>mdi-account-cog</v-icon> {{ datas ? datas.company_position : '' }}</h2>

              <h3
                class="text--primary text-caption text-sm-body-2 text-md-body-1"
              ><v-icon>mdi-email</v-icon> {{ user_email }}</h3>
              <h4
                class="text--primary text-caption text-sm-body-2 text-md-body-1"
              ><v-icon>mdi-id-card</v-icon> {{ company_number }}</h4>
              <v-row>
                <span class="text--primary text-caption text-sm-body-2 text-md-body-1">
                  &nbsp;&nbsp;&nbsp;<v-icon>mdi-account-tie</v-icon> {{ prp_assign }}
                </span>
                <span class="text--primary text-caption text-sm-body-2 text-md-body-1">
                   &nbsp;&nbsp;<u class="indigo--text lighten-1--text" style="cursor:pointer" @click="updatePrp">Update</u>
                </span>
                <updatePrp
                ref="updatePrp"
                ></updatePrp>
              </v-row>
              <v-row class="mt-3">
                <span class="text--primary text-caption text-sm-body-2 text-md-body-1">
                  &nbsp;&nbsp;&nbsp;<v-icon>mdi-account-cash</v-icon> {{ user_finance }}
                </span>
                <span class="text--primary text-caption text-sm-body-2 text-md-body-1">
                   &nbsp;&nbsp;<u class="indigo--text lighten-1--text" style="cursor:pointer" @click="updateFinance">Update</u>
                </span>
                  <updateFinance
                  ref="updateFinance"
                  ></updateFinance>
              </v-row>
            </v-col>
            <v-col class="text-right">
              <editProfile :datas="datas"></editProfile>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-container>
    <br>
    <br>
    <v-container cols="4" mt-10>
      <v-col>
        <v-card>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12" sm="4" md="12">
                  <v-text-field v-model="address" label="Address" outlined readonly></v-text-field>
                </v-col>

                <v-col cols="12" sm="4" md="4">
                  <v-text-field label="Department" outlined readonly v-model="department"></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="4">
                  <v-text-field
                    v-model="company_status"
                    label="Employment Status"
                    outlined
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="4">
                  <v-text-field v-model="date_hired" label="Date Hired" outlined readonly></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="4">
                  <v-text-field v-model="status" label="Civil Status" outlined readonly></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="4">
                  <v-text-field v-model="birthdate" label="Birthdate" outlined readonly></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="4">
                  <v-text-field v-model="contact_number" label="Contact Number" outlined readonly></v-text-field>
                </v-col>
                <v-col cols="12" sm="3" md="3">
                  <v-text-field v-model="pag_ibig" label="PagIbig Number" outlined readonly></v-text-field>
                </v-col>
                <v-col cols="12" sm="3" md="3">
                  <v-text-field v-model="tin_number" label="Tin Number" outlined readonly></v-text-field>
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
                  <v-text-field v-model="sss_num" label="SSS Number" outlined readonly></v-text-field>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
        </v-card>
      </v-col>
    </v-container>
  </v-row>
</template>
<script>
import editProfile from "./modals/edit_profile.vue";
import updatePrp from "./modals/edit_prp.vue";
import updateFinance from "./modals/edit_finance.vue";
export default {
  data() {
    return {
      isSelecting: false,
      user_name: localStorage.getItem("user_name"),
      prp_assign: localStorage.getItem("prp_assign"),
      user_id: localStorage.getItem("id"),
      user_finance: localStorage.getItem("user_finance"),
      user_email: localStorage.getItem("email"),
      company_number: localStorage.getItem("company_id"),
      dialog: false,
      department: null,
      employment_status: null,
      position: null,
      company_status: null,
      date_hired: null,
      address: null,
      status: null,
      birthdate: null,
      contact_number: null,
      pag_ibig: null,
      tin_number: null,
      philhealth_num: null,
      sss_num: null,
      prp: null,
      datas: [],
      profile_url: null,
      isSelecting: false
    };
  },
  mounted() {
    this.getInfo();
  },
  components: {
    editProfile,
    updatePrp,
    updateFinance
  },
  methods: {
    updatePrp(){
      this.$refs.updatePrp.show()
    },
    updateFinance(){
      this.$refs.updateFinance.show()
    },
    getInfo() {
      this.$axios
        .get("http://localhost:8000/user_info/" + this.user_id)
        .then(response => {
          this.prp_assign = localStorage.getItem("prp_assign");
          this.user_finance = localStorage.getItem("user_finance");
          this.datas = response.data.user_information;
          this.department =
            response.data.user_information.department.department_name;
          this.date_hired = response.data.user_information.date_hired;
          this.address = response.data.user_information.address;
          this.status = response.data.user_information.civil_status;
          this.company_status = response.data.user_information.company_status;
          this.profile_url = response.data.user_information.profile_url;
          this.birthdate = response.data.user_information.birthday;
          this.contact_number = response.data.user_information.contact_number;
          this.pag_ibig = response.data.user_information.pag_ibig_number;
          this.tin_number = response.data.user_information.tin_number;
          this.philhealth_num =
            response.data.user_information.philhealth_number;
          this.sss_num = response.data.user_information.sss_number;
        })
        .catch(e => {
          console.log(e);
        });
    },
    onButtonClick() {
      this.isSelecting = false;
      window.addEventListener(
        "focus",
        () => {
          this.isSelecting = false;
        },
        { once: true }
      );
      this.$refs.uploader.click();
    },
    onFileChanged(e) {
      this.selectedFile = e.target.files[0];
      this.profile_url = URL.createObjectURL(e.target.files[0]);
      const config = {
        header: { "content-type": "multipart/form-data" }
      };
      let formData = new FormData();
      formData.append("image", this.selectedFile);
      let param = {
        id: this.user_id
      };
      this.$axios
        .post(
          "http://localhost:8000/update_profile_img/" + this.user_id,
          formData
        )
        .then(response => {});
    }
  }
};
</script>