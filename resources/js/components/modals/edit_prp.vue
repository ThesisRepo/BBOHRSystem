<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="headline">Update PRP Assign</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <span v-if="error" style="color: red; font-style: italic">All data are required!</span>
            <v-row>
              <v-col cols="12">
                <v-select
                  :items="prp"
                  label="PRP Assign"
                  :item-text="
                  prp =>
                  prp.first_name + ' ' + prp.last_name
                  "
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
          <v-btn color="blue darken-1" text @click="dialog = false">Cancel</v-btn>
          <v-btn color="blue darken-1" text @click="update">Update</v-btn>
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
  mounted() {
    this.removeData()
  },
  methods: {
    show(){
        this.dialog = true
    },
    update() {
      if (this.selectPrp !== null && this.selectPrp !== "") {
        let parameter = {
          prp_assigned_id: this.selectPrp
        };
        this.$axios
          .post("prp/" + this.user_id, parameter)
          .then(res => {
            this.prp.forEach(element => {
              if (element.id === this.selectPrp) {
                localStorage.setItem(
                  "prp_assign",
                  element.first_name + " " + element.last_name
                );
                this.$parent.$parent.getInfo();
              }
            });
          });
        this.dialog = false;
      } else {
        this.error = true;
        this.dialog = true;
      }
    },
    removeData() {
      this.getAllPrp();
      if(this.prp !== null){
        this.prp.forEach(element => {
          if (
            element.first_name + " " + element.last_name ===
            localStorage.getItem("prp_assign")
          ) {
            this.selectPrp = element.id;
          }
        });
      }
    },
    getAllPrp() {
      this.$axios
        .get("prp/" + this.user_id)
        .then(response => {
          this.prp = response.data;
        });
    }
  }
};
</script>
