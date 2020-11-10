<template>
  <v-row>
    <v-container cols="4">
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
              <h1 class="title-h4 text-md-h4 text-sm-h4 text-truncate mt-8 primary--text"><b>{{ user_name ? user_name : 'No User Name' }}</b></h1>
              <h2 class="title-h6 text-md-h6 text-sm-h6 text-truncate"><v-icon class="primary--text">mdi-account-cog</v-icon> {{ datas ? datas.company_position : 'No Position' }}</h2>

              <h3
                class="text--primary text-caption text-sm-body-2 text-md-body-1"
              ><v-icon class="primary--text">mdi-email</v-icon> {{ user_email ? user_email : 'No email' }}</h3>
              <h4
                class="text--primary text-caption text-sm-body-2 text-md-body-1"
              ><v-icon class="primary--text">mdi-id-card</v-icon> {{ company_number ? company_number : 'No ID No.' }}</h4>
              <v-row>
                <span class="text--primary text-caption text-sm-body-2 text-md-body-1">
                  &nbsp;&nbsp;&nbsp;<v-icon class="primary--text">mdi-account-tie</v-icon> {{ prp_assign }}
                </span>
                <span class="text--primary text-caption text-sm-body-2 text-md-body-1">
                   &nbsp;&nbsp;<u class="indigo--text lighten-1--text" style="cursor:pointer" @click="updatePrp">UPDATE</u>
                </span>
                <updatePrp
                ref="updatePrp"
                ></updatePrp>
              </v-row>
              <v-row class="mt-3">
                <span class="text--primary text-caption text-sm-body-2 text-md-body-1">
                  &nbsp;&nbsp;&nbsp;<v-icon class="primary--text">mdi-account-cash</v-icon> {{ user_finance }}
                </span>
                <span class="text--primary text-caption text-sm-body-2 text-md-body-1">
                   &nbsp;&nbsp;<u class="indigo--text lighten-1--text" style="cursor:pointer" @click="updateFinance">UPDATE</u>
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
    </v-container>
    <v-container cols="4">
        <v-card class="mx-auto" elevation="6">
          <v-card-text>
            <v-container>
              <v-row>
                <h4 class="primary--text" style="margin-left: 3%;">Personal Information:</h4>
                <v-col cols="12" md="12">
                  <span style="margin-left: 3%;"><v-icon class="primary--text">mdi-map-marker</v-icon> {{ address }}</span>
                </v-col>
                <v-col cols="12" md="12">
                  <span style="margin-left: 3%;"><v-icon class="primary--text">mdi-account-group</v-icon> {{ department }}</span>
                </v-col>
                <v-col cols="12" md="12">
                  <span style="margin-left: 3%;"><v-icon class="primary--text">mdi-google-street-view</v-icon> {{ company_status }}</span>
                </v-col>
                <v-col cols="12" md="12">
                  <span style="margin-left: 3%;"><v-icon class="primary--text">mdi-calendar-check</v-icon> {{ date_hired }}</span>
                </v-col>
                <v-col cols="12" md="12">
                  <span style="margin-left: 3%;"><v-icon class="primary--text">mdi-account</v-icon> {{ status }}</span>
                </v-col>
                <v-col cols="12" md="12">
                  <span style="margin-left: 3%;"><v-icon class="primary--text">mdi-calendar</v-icon> {{ birthdate }}</span>
                </v-col>
                <v-col cols="12" md="12">
                  <span style="margin-left: 3%;"><v-icon class="primary--text">mdi-contacts</v-icon> {{ contact_number }}</span>
                </v-col>
                <v-col cols="12" md="12">
                  <span style="margin-left: 3%;"><v-icon class="primary--text">mdi-calculator</v-icon> {{ pag_ibig }}</span>
                </v-col>
                <v-col cols="12" md="12">
                  <span style="margin-left: 3%;"><v-icon class="primary--text">mdi-calculator</v-icon> {{ tin_number }}</span>
                </v-col>
                <v-col cols="12" md="12">
                  <span style="margin-left: 3%;"><v-icon class="primary--text">mdi-calculator</v-icon> {{ philhealth_num }}</span>
                </v-col>
                <v-col cols="12" md="12">
                  <span style="margin-left: 3%;"><v-icon class="primary--text">mdi-calculator</v-icon> {{ sss_num }}</span>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
        </v-card>
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
      isSelecting: false,
      testClass: 'red--text'
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
            response.data.user_information.department.department_name ? response.data.user_information.department.department_name : 'No Department';
          this.date_hired = response.data.user_information.date_hired ? response.data.user_information.date_hired : 'No Date Hired';
          this.address = response.data.user_information.address ? response.data.user_information.address : 'Unkown Address';
          this.status = response.data.user_information.civil_status ? response.data.user_information.civil_status : 'No Civil Status';
          this.company_status = response.data.user_information.company_status ? response.data.user_information.company_status : 'No Company Status';
          this.profile_url = response.data.user_information.profile_url;
          this.birthdate = response.data.user_information.birthday ? response.data.user_information.birthday : 'No Birthdate';
          this.contact_number = response.data.user_information.contact_number ? response.data.user_information.contact_number : 'No Contact No.';
          this.pag_ibig = response.data.user_information.pag_ibig_number ? response.data.user_information.pag_ibig_number : 'No Pag-ibig Account';
          this.tin_number = response.data.user_information.tin_number ? response.data.user_information.tin_number : 'No TIN';
          this.philhealth_num =
            response.data.user_information.philhealth_number ? response.data.user_information.philhealth_number : 'No PhilHealth';
          this.sss_num = response.data.user_information.sss_number ? response.data.user_information.sss_number : 'No SSS';
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