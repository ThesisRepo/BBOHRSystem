<template>
<v-app>
  <v-layout>
    <v-container>
      <v-card class="mx-auto" elevation="3">
          <v-card-title class="primary fill-height" >
            <span class="headline white--text">USER PROFILE</span> 

          </v-card-title>
          <v-container>
            <v-row>
              <v-col>

                <v-avatar v-if="profile_url === null" class="ml-15" size="200">
                  <img src="images/user.png" width="100%" height="100%" id="profile">
                </v-avatar>
                <v-avatar v-else class="ml-15 avatar" color="grey darken-1" size="200">
                  <img :src="profile_url" width="100%" height="100%" id="profile">
                   <div class="overlay" @click="onButtonClick">upload image</div>
                </v-avatar>
                <v-row>
                  <v-col class="ml-16">
                  <v-btn
                    margin
                    color="primary"
                    class="text-none"
                    rounded
                    outlined
                    depressed
                    :loading="isSelecting"
                    @click="updateFileChanged"
                  >Change Profile Image</v-btn>

                  <input
                    ref="uploader"
                    class="d-none"
                    type="file"
                    accept="image/*"
                    @change="onFileChanged"
                  >
                </v-col>
                </v-row>
                
              </v-col>
              <v-col>
                <h1 class="title-h4 text-md-h4 text-sm-h4 text-truncate mt-8 primary--text"><b>{{ user_name ? user_name : 'No User Name' }}</b></h1>
                <h2 class="title-h6 text-md-h6 text-sm-h6 text-truncate"><v-icon class="primary--text">mdi-account-cog</v-icon> {{ company_position ? company_position : 'No Position' }}</h2>

                <h3
                  class="text--primary text-caption text-sm-body-2 text-md-body-1 "
                ><v-icon class="primary--text">mdi-email</v-icon> {{ user_email ? user_email : 'No email' }}</h3>
                <h4
                  class="text--primary text-caption text-sm-body-2 text-md-body-1"
                ><v-icon class="primary--text">mdi-id-card</v-icon> {{ company_number ? company_number : 'No ID No.' }}</h4>
                <v-row>
                  <span class="text--primary text-caption text-sm-body-2 text-md-body-1">
                    &nbsp;&nbsp;&nbsp;<v-icon class="primary--text">mdi-account-tie</v-icon> {{ prp_assign }}
                  </span>
                  <span class="text--primary text-caption text-sm-body-2 text-md-body-1">
                    &nbsp;&nbsp;<u class="indigo--text lighten-1--text" style="cursor:pointer" @click="updatePrp">UPDATE ASSIGNED PRP</u>
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
                    &nbsp;&nbsp;<u class="indigo--text lighten-1--text" style="cursor:pointer" @click="updateFinance">UPDATE ASSIGNED FINANCE</u>
                  </span>
                    <updateFinance
                    ref="updateFinance"
                    ></updateFinance>
                </v-row>
              </v-col>
              <v-col class="text-right">
              <editProfile :datas="datas" :datum="datum"></editProfile>
            </v-col>
            </v-row>
          </v-container>
      </v-card>
      <Reminder
      ref="reminder"
      :message="myMessage"
      ></Reminder>
      <Confirmation
      ref="confirms"
      :title="confirmationTitle"
      :message="confirmationMessage"
      @onConfirm="confirm($event)"
    ></Confirmation>
    </v-container>
    
  </v-layout>
  <v-container >
        <v-card class="mx-auto" elevation="3">
          <v-card-text>
            <v-container>
              <h4 class="primary--text" mb-1 style="margin-left: 3%;">Personal Information:</h4>
              <v-row style="margin-left: 5%;">
                <v-col cols="12" md="6">
                  <p class="black--text" style="font-size:20px"><v-icon class="primary--text">mdi-map-marker</v-icon> {{ address ? address : 'No Address' }}</p>
                  <p class="black--text" style="font-size:20px"><v-icon class="primary--text">mdi-calendar</v-icon> {{ birthdate ? birthdate : 'No Birthdate'}}</p>
                </v-col>
                <v-col cols="12" md="6">
                  <p class="black--text" style="font-size:20px"><v-icon class="primary--text">mdi-contacts</v-icon> {{ contact_number ? contact_number : 'No Contact No.' }}</p>
                  <p class="black--text" style="font-size:20px"><v-icon class="primary--text">mdi-account</v-icon> {{ status === 'single' ? 'Single' : status === 'married' ? 'Married' : status ? status : 'No Status' }}</p>
                </v-col>
              </v-row>
              <!-- end Personal Info -->
              <h4 class="primary--text" mb-1 style="margin-left: 3%;">Business Information:</h4>
              <v-row style="margin-left: 5%;">
                <v-col cols="12" md="6">
                  <p class="black--text" style="font-size:20px"><v-icon class="primary--text">mdi-account-group</v-icon> {{ department ? department : 'No Department' }}</p>
                  <p class="black--text" style="font-size:20px"><v-icon class="primary--text">mdi-google-street-view</v-icon> {{ company_status === 'regular' ? 'Regular' : company_status ? company_status : 'No Company Status' }}</p>
                </v-col>
                <v-col cols="12" md="6">
                  <p class="black--text"  style="font-size:20px"><v-icon class="primary--text">mdi-calendar-check</v-icon> {{ date_hired ? date_hired : 'No Date Hired'}}</p>
                  <p class="black--text"  style="font-size:20px"><v-icon class="primary--text">mdi-timetable</v-icon> {{ shift ? shift : 'No Shift Time'}}</p>
                </v-col>
              </v-row>
              <!-- end Business Info -->
              <h4 class="primary--text" mb-1 style="margin-left: 3%;">Others:</h4>
              <v-row style="margin-left: 5%;">
                <v-col cols="12" md="6">
                  <p class="black--text" style="font-size:20px"><v-icon class="primary--text">mdi-calculator</v-icon> {{ pag_ibig ? pag_ibig : 'No Pag-ibig Account' }}</p>
                  <p class="black--text" style="font-size:20px"><v-icon class="primary--text">mdi-calculator</v-icon> {{ tin_number ? tin_number : 'No TIN'}}</p>
                </v-col>
                <v-col cols="12" md="6">
                  <p class="black--text"  style="font-size:20px"><v-icon class="primary--text">mdi-calculator</v-icon> {{ philhealth_num ? philhealth_num : 'No PhilHealth'}}</p>
                  <p class="black--text"  style="font-size:20px"><v-icon class="primary--text">mdi-calculator</v-icon> {{ sss_num ? sss_num : 'No SSS'}}</p>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
        </v-card>
    </v-container>
</v-app>
</template>
<style scoped>
.avatar {
  position: relative;
  width: 50%;
  max-width: 300px;
}
.overlay {
  position: absolute;
  bottom: 0;
  background: rgb(0, 0, 0);
  background: rgba(0, 0, 0, 0.5); /* Black see-through */
  color: #f1f1f1;
  width: 100%;
  transition: .5s ease;
  /* opacity:0; */
  color: white;
  font-size: 20px;
  padding: 20px;
  text-align: center;
}

/* When you mouse over the container, fade in the overlay title */
.avatar:hover .overlay {
  /* opacity: 1; */
  cursor: pointer;
}
</style>


<script>
import editProfile from "./modals/edit_profile.vue";
import updatePrp from "./modals/edit_prp.vue";
import updateFinance from "./modals/edit_finance.vue";
import Reminder from "./modals/confirmation/reminder.vue";
import Confirmation from "./modals/confirmation/confirm.vue";
import { mapGetters } from "vuex";
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
      company_position: null,
      employment_status: null,
      position: null,
      company_status: null,
      shift: null,
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
      profile_url: this.profileUrl,
      isSelecting: false,
      testClass: 'red--text',
      formData: null,
      isEditabelProfile: false,
      myMessage: null,
      imgMaxSize: 2.097152,
      confirmationTitle:null,
      confirmationMessage: null,
      datum: []
    };
  },
  created() {
    this.getInfo();
  },
  components: {
    editProfile,
    updatePrp,
    updateFinance,
    Reminder,
    Confirmation
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
        .get("user_info/" + this.user_id)
        .then(response => {
          this.prp_assign = localStorage.getItem("prp_assign");
          this.user_finance = localStorage.getItem("user_finance");
          if(response.data.user_information !== null){
            this.datas = response.data.user_information;
            this.datum = response.data
            this.company_position = response.data.user_information.company_positions[0].position_name;
            this.shift = response.data.user_information.shift_time.shift_time_name;
            this.department = response.data.user_information.department.department_name;
            this.date_hired = response.data.user_information.date_hired;
            this.address = response.data.user_information.address;
            this.status = response.data.user_information.civil_status;
            this.company_status = response.data.user_information.company_status;
            this.profile_url = response.data.user_information.profile_url;
            this.birthdate = response.data.user_information.birthday;
            this.contact_number = response.data.user_information.contact_number;
            this.pag_ibig = response.data.user_information.pag_ibig_number;
            this.tin_number = response.data.user_information.tin_number;
            this.philhealth_num = response.data.user_information.philhealth_number;
            this.sss_num = response.data.user_information.sss_number;
          }
          // location.reload();
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
    confirm(){
      if(this.confirmationTitle == 'Update Profile'){
        this.uploadImg();
      }
    },
    uploadImg() {
      this.$store.dispatch('ChangeProfileUrl', {user:this.user_id, profileUrl:this.formData}).then(()=> {
        // alert('ddf');
        this.isEditabelProfile = false;
        this.isConfirmed = false;
      });
    },
    updateFileChanged() {
      if(this.isEditabelProfile) {
        this.confirmationTitle = 'Update Profile',
        this.confirmationMessage = 'Are you sure you want to update your profile photo?',
        this.$refs.confirms.show()
      }else{
        this.myMessage = 'Seems like you didn\'t upload an image.'
        this.$refs.reminder.show();
      }
    },
    onFileChanged(e) {
      this.selectedFile = e.target.files[0];
      if(this.selectedFile.size > this.imgMaxSize * 1024 * 1024) {
        this.myMessage = 'Opps! Image too large.'
        this.$refs.reminder.show();
      }else {
        this.isEditabelProfile = this.profile_url !=  URL.createObjectURL(e.target.files[0])
        this.profile_url = URL.createObjectURL(e.target.files[0]);
        const config = {
          header: { "content-type": "multipart/form-data" }
        };
        let formData = new FormData();
        formData.append("image", this.selectedFile);
        this.formData = formData;
      }
      // this.$axios
      //   .post(
      //     "update_profile_img/" + this.user_id,
      //     formData
      //   )
      //   .then(response => {});
    }
  },
  computed: {
    ...mapGetters(["profileUrl"])
  }
};
</script>
