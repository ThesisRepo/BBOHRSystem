<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <!-- <template v-slot:activator="{ on, attrs }">
        <div
          class="indigo--text lighten-1--text text-decoration-underline"
          v-bind="attrs"
          v-on="on"
          @click="removeData()"
        >
          <v-toolbar-title class="indigo--text lighten-1--text" style="font-size:18px">Update</v-toolbar-title>
        </div>
      </template> -->
      <v-card>
        <v-card-title>
          <span class="headline">Update Finance Assign</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <span v-if="error" style="color: red; font-style: italic">All data are required!</span>
            <v-row>
              <v-col cols="12">
                <v-select
                  :items="finance"
                  label="Finance Assign"
                  :item-text="
                                        finance =>
                                            finance.first_name +
                                            ' ' +
                                            finance.last_name
                                    "
                  item-value="id"
                  v-model="selectFinance"
                  required
                ></v-select>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
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
    selectFinance: null,
    finance: null,
    user_id: localStorage.getItem("id"),
    user_finance: localStorage.getItem("user_finance")
  }),
  mounted() {
    this.getAllFinance();
    this.removeData()
    this.selectFinance = localStorage.getItem("user_finance");
  },
  methods: {
    show(){
      this.dialog = true
    },
    update() {
      if (this.selectFinance !== null && this.selectFinance !== "") {
        let parameter = {
          finance_mngr_assigned: this.selectFinance
        };
        this.$axios
          .post("http://localhost:8000/finance/" + this.user_id, parameter)
          .then(res => {
            this.finance.forEach(element => {
              if (element.id === this.selectFinance) {
                localStorage.setItem(
                  "user_finance",
                  element.first_name + " " + element.last_name
                );
                console.log(localStorage.getItem("user_finance"));
                this.$parent.$parent.getInfo();
              }
            });
            //   console.log(res.data)
          });
        this.dialog = false;
      } else {
        this.error = true;
        this.dialog = true;
      }
    },
    removeData() {
      this.getAllFinance();
      this.finance.forEach(element => {
        if (
          element.first_name + " " + element.last_name ===
          localStorage.getItem("user_finance")
        ) {
          this.selectFinance = element.id;
        }
      });
    },
    getAllFinance() {
      this.$axios
        .get("http://localhost:8000/finance/" + this.user_id)
        .then(response => {
          this.finance = response.data;
        });
    }
  }
};
</script>
