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
          <v-container v-if="datas !== null">
            <v-row>
              <v-col cols="12" sm="6" md="4">
                <v-text-field label="Position*" v-model="datas.company_position" required></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field label="Address*" v-model="datas.address" required></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-select
                  :items="['single', 'Married', 'Widowed', 'Single-Parent']"
                  label="Status*"
                  v-model="datas.civil_status"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field label="Contact No.*" v-model="datas.contact_number" required ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field label="PagIbig No.*" v-model="datas.pag_ibig_number" required></v-text-field>
              </v-col>
               <v-col cols="12" sm="6" md="4">
                <v-text-field label="SSS No.*" v-model="datas.sss_number" required></v-text-field>
              </v-col>
               <v-col cols="12" sm="6" md="4">
                <v-text-field label="Tin No.*" v-model="datas.tin_number" required></v-text-field>
              </v-col>
               <v-col cols="12" sm="6" md="4">
                <v-text-field label="PhilHealth No.*" v-model="datas.philhealth_number" required></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">
            Close
          </v-btn>
          <v-btn color="blue darken-1" text @click="update()">
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
  props: ['datas'],
  methods: {
    update() {
      if(this.datas.company_position === null && this.datas.address === null && this.datas.civil_status === null && this.datas.contact_number === null &&
      this.datas.pag_ibig_number === null && this.datas.sss_number === null && this.datas.tin_number === null && this.datas.philhealth_number === null) {
        e.preventDefault()
      }
      let params = {
        company_position: this.datas.company_position,
        address: this.datas.address,
        civil_status: this.datas.civil_status,
        contact_number: this.datas.contact_number,
        pag_ibig_number: this.datas.pag_ibig_number,
        sss_number: this.datas.sss_number,
        tin_number: this.datas.tin_number,
        philhealth_number: this.datas.philhealth_number
      }
      this.$axios.post('http://localhost:8000/user_info/update/' + localStorage.getItem('id'), params).then(response => {
        if(response.data.length > 0) {
          this.$parent.getInfo()
          // this.dialog = false
        }
      })
    }
  }
};
</script>