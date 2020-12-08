<template>
  <v-row justify="end" id="pass">
    <v-dialog v-model="dialog" persistent max-width="650px">
      <v-card>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat>
          <v-card-title>
            <span class="headline-bold">Manage Password</span>
          </v-card-title>
        </v-toolbar>
        <v-card-text>
          <v-container>
            <v-row>
                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="password"
                    prepend-icon="mdi-lock"
                    label="New Password*"
                    :append-icon="
                      value ? 'mdi-eye' : 'mdi-eye-off'
                    "
                    :type="value ? 'password' : 'text'"
                    @keyup="validate('password')"
                    dense
                    required
                    @click:append="() => (value = !value)"
                  ></v-text-field>
                  <span
                    class="ml-8"
                    v-if="errorMessage6 !== null"
                    style="color: red; font-size: 12px"
                  >{{ errorMessage6 }}</span>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field
                    label="Confirm Password"
                    :append-icon="
                      valuePass ? 'mdi-eye' : 'mdi-eye-off'
                    "
                    @click:append="
                      () => (valuePass = !valuePass)
                    "
                    :type="valuePass ? 'password' : 'text'"
                    @keyup="validate('confirm_password')"
                    name="password"
                    prepend-icon="mdi-lock"
                    v-model="confirm_password"
                    dense
                    required
                  ></v-text-field>
                  <span
                    class="ml-8"
                    v-if="errorMessage7 !== null"
                    style="color: red; font-size: 12px"
                  >{{ errorMessage7 }}</span>
                </v-col>
              </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red" dark @click="dialog = false">Cancel</v-btn>
          <v-btn color="green" dark @click="dialog = false">Update</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    
    <ConfirmationDel
      ref="confirmDel"
      @onConfirm="confirmDel($event)"
    ></ConfirmationDel>
  </v-row>
</template>
<style>
</style>
<script>
import ConfirmationDel from "./confirmation/delete.vue";
export default {
  data: () => ({
    dialog: false,
    user_id: localStorage.getItem("id"),
    password: null,
    confirm_password: null,
    valuePass: false,
    errorMessage6: null,
    errorMessage7: null,
    value: true
  }),
  mounted() {
  },
  components: {
    ConfirmationDel
  },
  methods: {
    show(){
      this.dialog = true
    },
    validate(input){
        if (input === "password") {
        this.errorMessage6 = null;
        if(this.password === '' || this.password === null){
          this.errorMessage6 = "Password is required";
        }else if (this.password.length < 8) {
          this.errorMessage6 = "Password must be atleast 8 characters.";
        } else if (
          /^.*(?=.{8,})((?=.*[!@#$%^&*()\-_=+{};:,<.>]){1})(?=.*\d)((?=.*[a-z]){1})((?=.*[A-Z]){1}).*$/.test(
            this.password
          )
        ) {
          this.successMessage = "Strong password";
          this.errorMessage6 = null;
        } else {
          this.errorMessage6 =
            "Password must be alphanumeric characters. It should contain 1 number, 1 special character and 1 capital letter";
        }
      } else if (input === "confirm_password") {
        this.errorMessage7 = null;
        if(this.confirm_password === '' || this.confirm_password === null){
          this.errorMessage6 = "Confirm password is required";
        }else if (this.password.localeCompare(this.confirm_password) !== 0) {
          this.errorMessage7 = "Password did not match";
        } else {
          this.errorMessage7 = null;
        }
      }
    },
    update(){
      let parameter = {
        id: this.storeage.id,
        event_name: this.event_name,
        color: this.color
      }
      this.$axios.post('event_types/' + this.storeage.id, parameter).then( response =>{
        // this.getEventType()
        this.event_name = null,
        this.color = 'Colors'
        this.showSave = false
      })
    }
  }
}
</script>
