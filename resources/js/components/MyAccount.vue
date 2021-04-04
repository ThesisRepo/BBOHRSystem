<template>
<v-app>
  <v-layout>
    <v-container>
      <v-card class="mx-auto" elevation="3">
          <v-card-title class="primary fill-height" >
            <span class="headline white--text">USER PROFILE</span> 

          </v-card-title>
          <v-container class="pl-10 pr-10">
            <v-row 
              align="center"
              justify="center"
              >
              <!-- style="background-color:blue" -->
              <v-col md="3" style="text-align:center">
                <!-- <v-avatar v-if="profile_url === null" class="ml-15" size="200">
                  <img src="images/user.png" width="100%" height="100%" id="profile">
                  <div class="overlay" @click="onButtonClick">upload image</div>
                </v-avatar> -->
                <v-avatar  class=" avatar" color="grey darken-1" size="200">
                  <img :src="profile_url" width="100%" height="100%" id="profile">
                   <div class="overlay" @click="onButtonClick">UPLOAD IMAGE</div>
                </v-avatar>
                <v-row>
                  <v-col>
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
                  <v-col>
                    <v-btn margin color="primary" class="text-none" rounded outlined depressed @click="password()">
                      <v-icon left>mdi-lock</v-icon>Manage Password
                    </v-btn>
                  </v-col>
                </v-row> 
              </v-col>

              <v-col  class="pl-md-10 pr-md-10"  md="8">
                <v-row >
                  <v-col col="12" md="6">
                    <h4 class="text-truncate text-center text-md-left primary--text">{{ user_name ? user_name : 'No User Name' }}</h4>
                  </v-col>
                  <v-col col="12" md="6">
                    <editProfile v-if="!isAdmin" :datas="datas" :datum="datum" class="float-md-right"></editProfile>
                    <EditProfileAdmin v-else :userData="editProfileInformation" @update="getInfo()" ref="editProfileAdmin"></EditProfileAdmin>
                  </v-col>
                </v-row>
                <v-row style="background-color:#FBFCFC;border-bottom:1px solid #D6DBDF">
                  <v-col md="4">
                     <v-icon class="primary--text">mdi-account-cog</v-icon>
                     <span class="ml-2 primary--text  text-caption text-sm-body-2 text-md-body-1">Company Position</span>
                  </v-col>
                  <v-col md="8">
                    <h2 class="text--primary text-caption text-md-right text-sm-body-2 text-md-body-1"  :style="[company_position ? {}: {'color': 'grey!important'}]">              
                      {{ company_position != null ? company_position : 'NA' }}
                    </h2>
                  </v-col>
                </v-row>
                <v-row style="background-color:#FBFCFC;border-bottom:1px solid #D6DBDF">
                  <v-col md="6">
                     <v-icon class="primary--text">mdi-email</v-icon>
                     <span class="ml-2 primary--text  text-caption text-sm-body-2 text-md-body-1">Company E-mail</span>
                  </v-col>
                  <v-col md="6">
                    <h2 class="text--primary text-caption  text-md-right text-sm-body-2 text-md-body-1 "  :style="[user_email ? {}: {'color': 'grey!important'}]"> 
                      {{ user_email ? user_email : 'NA' }}
                    </h2>
                  </v-col>
                </v-row>

                <v-row  style="background-color:#FBFCFC;border-bottom:1px solid #D6DBDF">
                  <v-col md="6">
                     <v-icon class="primary--text">mdi-id-card</v-icon>
                     <span class="ml-2 primary--text  text-caption text-sm-body-2 text-md-body-1">Company Number</span>

                  </v-col>
                  <v-col md="6">
                    <h2 class="text--primary text-caption text-md-right text-sm-body-2 text-md-body-1" :style="[company_number ? {}: {'color': 'grey!important'}]">
                      {{ company_number ? company_number : 'NA' }}
                    </h2>
                  </v-col>
                </v-row>

                <v-row  style="background-color:#FBFCFC;border-bottom:1px solid #D6DBDF" v-if="notGen && notAdmin">
                  <v-col md="4">
                     <v-icon class="primary--text">mdi-account-tie</v-icon> 
                     <span class="ml-2 primary--text  text-caption text-sm-body-2 text-md-body-1">PRP Assigned</span>
                  </v-col>
                  <v-col md="8">
                    <h2 class="text--primary text-caption text-md-right text-sm-body-2 text-md-body-1"  :style="[prp_assign ? {}: {'color': 'grey!important'}]">
                    {{ prp_assign ?  prp_assign : 'No Assigned PRP'}}
                    <u class="indigo--text text-md-right lighten-1--text" style="cursor:pointer" @click="updatePrp">UPDATE PRP</u>                    
                  </h2>
                  </v-col>
                </v-row>
                <v-row  style="background-color:#FBFCFC;border-bottom:1px solid #D6DBDF" v-if="notGen && notAdmin">
                  <v-col md="4">
                      <v-icon class="primary--text">mdi-account-cash</v-icon>
                      <span class="ml-2 primary--text  text-caption text-sm-body-2 text-md-body-1">Finance Assigned</span>
                  </v-col>
                  <v-col md="8">
                    <h2 class="text--primary text-caption text-md-right text-sm-body-2 text-md-body-1"  :style="[user_finance ? {}: {'color': 'grey!important'}]">
                    {{  user_finance ?  user_finance : 'No Assigned Finance' }}
                    <u class="indigo--text text-md-right lighten-1--text" style="cursor:pointer" @click="updateFinance">UPDATE FINANCE</u>                    
                  </h2>
                  </v-col>
                </v-row>
                <updatePrp
                  ref="updatePrp"
                >
                </updatePrp>
                <updateFinance
                  ref="updateFinance"
                >
                </updateFinance>
              </v-col>
            </v-row>
          </v-container>
          
      </v-card>
      <Password
        ref="pass"
        >
        </Password>
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
                  <p class="black--text" style="font-size:20px"><v-icon class="primary--text">mdi-calendar</v-icon> {{ birthdate ? formatDateStandardDateOnly(birthdate) : 'No Birthdate'}}</p>
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
                  <p class="black--text"  style="font-size:20px"><v-icon class="primary--text">mdi-calendar-check</v-icon> {{ date_hired ? formatDateStandardDateOnly(date_hired) : 'No Date Hired'}}</p>
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
import Password from "./modals/change_password.vue";
import EditProfileAdmin from "./modals/personalInfo_user.vue";
import { mapGetters } from "vuex";
import {formatDateStandardDateOnly} from  "../helpers/date_format.js";

export default {
  data() {
    return {
      user_type: localStorage.getItem("user_type"),
      isSelecting: false,
      user_name: localStorage.getItem("user_name"),
      prp_assign: localStorage.getItem("prp_assign"),
      user_id: localStorage.getItem("id"),
      user_finance: localStorage.getItem("user_finance"),
      user_email: localStorage.getItem("email"),
      company_number: localStorage.getItem("company_id"),
      dialog: false,
      department: null,
      notGen: true,
      notAdmin: true,
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
      profile_url: this.$store.getters.profileUrl,
      isSelecting: false,
      testClass: 'red--text',
      formData: null,
      isEditabelProfile: false,
      myMessage: null,
      imgMaxSize: 2.097152,
      confirmationTitle:null,
      confirmationMessage: null,
      datum: [],
      editProfileInformation: {
        address: null,
        contact_number: null,
        pag_ibig_number: null,
        sss_number: null,
        tin_number: null,
        philhealth_number: null,
        first_name: null,
        last_name: null,
        password: null,
        confirm_password: null,
        email: null,
        valuePass: true,
        value: true,
        dialogPersonal: false,
        dialogBusiness: false,
        dialogOthers: false,
        departmentItem: null,
        birthday: null,
        menu: false,
        selectPrp: null,
        prp: null,
        finance: null,
        roles: null,
        selectFinance: null,
        sTime: null,
        error: false,
        civil_status: null,
        regularization_date: null,
        prp_assigned: null,
        finance_assigned: null,
        allowed_leave_number: null,
        department: null,
        shift_time: null,
        gender: null,
        company_position: null,
        date_hired: null,
        company_status: null,
        company_number: null,
      },
      isAdmin: false
    };
  },
  mounted() {
    this.isAdmin = this.isAdminFunc(this.$store.getters.roleList);
    this.notGeneral();
    this.notAdminstration();
  },
  created() {
    this.getInfo();
  },
  components: {
    editProfile,
    updatePrp,
    updateFinance,
    Reminder,
    Confirmation,
    Password,
    EditProfileAdmin
  },
  methods: {
    notGeneral(){
      if(this.user_type.includes("general mngr")){
        this.notGen = false;
      }
    },
    notAdminstration(){
      if(this.user_type.includes("admin")){
        this.notAdmin = false;
      }
    },
    password(){
      this.$refs.pass.show()
    },
    formatDateStandardDateOnly,
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
            if(this.company_position = response.data.user_information.company_positions[0]) {
              this.company_position = response.data.user_information.company_positions[0].position_name;
            }
            if(response.data.user_information.shift_time ) {
              this.shift = response.data.user_information.shift_time.shift_time_name;
            }
            if(response.data.user_information.department) {
              this.department = response.data.user_information.department.department_name;
            }
            this.date_hired = response.data.user_information.date_hired;
            this.address = response.data.user_information.address;
            console.log('df', this.address );
            this.status = response.data.user_information.civil_status;
            this.company_status = response.data.user_information.company_status;
            this.birthdate = response.data.user_information.birthday;
            this.contact_number = response.data.user_information.contact_number;
            this.pag_ibig = response.data.user_information.pag_ibig_number;
            this.tin_number = response.data.user_information.tin_number;
            this.philhealth_num = response.data.user_information.philhealth_number;
            this.sss_num = response.data.user_information.sss_number;
            // applicable for admin users only
            if(this.isAdmin) {
              this.editProfileInformation.address = response.data.user_information.address;
              this.editProfileInformation.contact_number = response.data.user_information.contact_number;
              this.editProfileInformation.pag_ibig_number = response.data.user_information.pag_ibig_number;
              this.editProfileInformation.sss_number = response.data.user_information.sss_number;
              this.editProfileInformation.philhealth_number = response.data.user_information.philhealth_number;
              this.editProfileInformation.first_name = response.data.first_name;
              this.editProfileInformation.last_name = response.data.last_name;
              this.editProfileInformation.email =  response.data.email;
              this.editProfileInformation.birthday = response.data.user_information.birthday;
              this.editProfileInformation.civil_status = response.data.user_information.civil_status_id;
              this.editProfileInformation.regularization_date = response.data.user_information.regularization_date;
              this.editProfileInformation.prp_assigned = response.data.prp_assigned;
              this.editProfileInformation.finance_assigned = response.data.finance_mngr_assigned;
              this.editProfileInformation.department = response.data.user_information.department;
              this.editProfileInformation.shift_time = response.data.user_information.shift_time;
              this.editProfileInformation.gender = response.data.user_information.gender;
              this.editProfileInformation.company_position = response.data.company_position;
              this.editProfileInformation.date_hired = response.data.user_information.date_hired;
              this.editProfileInformation.company_status = response.data.user_information.company_status_id;
              this.editProfileInformation.company_number = response.data.user_information.company_number;
            }
            this.$store.commit('ChangeProfileUrl', response.data.user_information.profile_url == null ? 'images/user.png' : response.data.user_information.profile_url);
          }
        }).catch(err => {
          console.log('err', err);
        })
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
    },
    isAdminFunc(list) {
      let roleList = list;
      let res = roleList.includes('hr mngr') || 
      roleList.includes('finance mngr') || 
      roleList.includes('general mngr') || 
      roleList.includes('admin');
      return res;
    }
  },
  computed: {
    ...mapGetters(["profileUrl", "roleList"])
  },
  watch: {
    profileUrl(newVal) {
      this.profile_url = newVal;
    },
    roleList(newVal) {
      this.isAdmin = newVal.includes('hr mngr') || 
      newVal.includes('finance mngr') || 
      newVal.includes('general mngr') || 
      newVal.includes('admin');
      alert(this.isAdmin);
    }
  }
};
</script>