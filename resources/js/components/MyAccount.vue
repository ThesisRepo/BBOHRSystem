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
            <v-col>
              <v-avatar
                v-if="profile_url === null"
                class="ml-15"
                color="grey darken-1"
                size="200"
              ></v-avatar>
              <v-avatar v-else 
                class="ml-15"
                color="grey darken-1"
                size="200">
                <img
                :src="profile_url"
               
                max-width="100%"
                max-height="100%"
              
                id ="profile"
              ></v-avatar>
              
              <v-col class="ml-15">
               <v-btn 
                margin
                color="primary"
                class="text-none"
                round
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
                <changeProfile></changeProfile>
              </v-col>
            </v-col>
            <v-col>
              <h1 class="title-h3 text-md-h3 text-sm-h3 text-truncate mt-8">
                {{ user_name }}
              </h1>
              <h2 class="title-h5 text-md-h5 text-sm-h5 text-truncate">
                {{ datas.company_position }}
              </h2>

              <h3
                class="text--primary text-caption text-sm-body-2 text-md-body-1"
              >
                Company Email: {{ user_email }}
              </h3>
              <span
                class="text--primary text-caption text-sm-body-2 text-md-body-1"
                >Id Number: {{ company_number }}</span
              >
            </v-col>
            <v-col class="text-right">
              <editProfile :datas="datas"></editProfile>
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
                <v-col cols="12" sm="4" md="12">
                  <v-text-field
                    v-model="address"
                    label="Address"
                    outlined
                    readonly
                  ></v-text-field>
                </v-col>

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
                    v-model="company_status"
                    label="Employment Status"
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
                <v-col cols="12" sm="4" md="4">
                  <v-text-field
                    v-model="status"
                    label="Civil Status"
                    outlined
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="4">
                  <v-text-field
                    v-model="birthdate"
                    label="Birthdate"
                    outlined
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="4">
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
      datas: [],
      profile_url: null,
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
      console.log("hi");
      this.$axios
        .get("http://localhost:8000/user_info/" + this.user_id)
        .then((response) => {
          console.log(response.data);
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
        .catch((e) => {
          console.log(e);
        });
    },
     onButtonClick() {
      this.isSelecting = true
      window.addEventListener('focus', () => {
        this.isSelecting = false
      }, { once: true })

      this.$refs.uploader.click()
    },
    onFileChanged(e) {
      this.selectedFile = e.target.files[0] 
      this.profile_url = URL.createObjectURL(e.target.files[0]);
      

      const config = {
        header: { 'content-type': 'multipart/form-data'}
      }
      let formData = new FormData();
      formData.append('image',this.selectedFile)
     let param = {
       id:this.user_id,

     }

      console.log(this.user_id,"this is url");
       this.$axios
        .post("http://localhost:8000/update_profile_img/" + this.user_id,formData).then( response =>{
          console.log("sud")
          console.log(response.data)
        })

    },
  }
};
</script>