<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <template v-slot:activator="{ on, attrs }">
        <u
          color="light blue"
          rounded
          v-bind="attrs"
          v-on="on"
          @click="removeData()"
        >
          <v-toolbar-title>Update</v-toolbar-title>
        </u>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Update Prp Assign</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <span v-if="error" style="color: red; font-style: italic">All data are required!</span>
            <v-row>
             <v-col cols="12">
                <v-select
                  :items="prp"
                  label="Prp Assign"
                  :item-text="prp => prp.first_name + ' ' + prp.last_name"
                  item-value="id"
                  v-model="selectPrp"
                  required
                ></v-select>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">
            Close
          </v-btn>
          <v-btn color="blue darken-1" text @click="update">
            Update
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
    error: false,
    selectPrp: null,
    prp: null,
    user_id: localStorage.getItem("id"),
    prp_assign: localStorage.getItem("prp_assign")
  }),
  mounted(){
    this.getAllPrp()
    this.selectPrp = localStorage.getItem("prp_assign")
    console.log(this.selectPrp)
  },
  methods: {
    update(){
      if(this.selectPrp !== null && this.selectPrp !== ''){
        let parameter = {
          prp_assigned_id: this.selectPrp
        }
        console.log(parameter)
        this.$axios.post("http://localhost:8000/prp/" + this.user_id, parameter).then(res =>{
          console.log('Successfully Updated', res.data)
          this.$parent.$parent.$parent.$parent.$parent.getInfo()
        })
        this.dialog = false
      }else{
        this.error = true
        this.dialog = true
      }
    },
    removeData(){
      this.getAllPrp()
      this.prp.forEach(element => {
        if(element.first_name + ' ' + element.last_name === localStorage.getItem("prp_assign")){
          console.log(element.id)
          this.selectPrp = element.id
        }
      });
    },
    getAllPrp(){
      this.$axios.get("http://localhost:8000/prp/" + this.user_id).then(response => {
        console.log(response.data)
        this.prp = response.data
      })
    }
  }
}
</script>
