<template>
  <v-data-table :headers="headers" :items="user" :search="search" class="elevation-1">
    <template v-slot:top>
      <v-toolbar class="mb-2" color="blue darken-1" dark flat>
        <v-toolbar-title class="col pa-3 py-4 white--text" style="font-size:16px ">MANAGE USER</v-toolbar-title>
        <v-text-field
          v-model="search"
          clearable
          flat
          solo-inverted
          hide-details
          prepend-inner-icon="mdi-magnify"
          label="Search"
        ></v-text-field>

        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on, attrs }">
            <createUser></createUser>
          </template>
        </v-dialog>

        <!-- Delete Modal -->
        <ConfirmationDel ref="confirmDel" @onConfirm="confirmDel($event)"></ConfirmationDel>

      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon small class="mr-2" @click="seeItem(item)">mdi-eye</v-icon>
      <v-dialog v-model="showModal" width="600px">
        <v-simple-table>
          <template v-slot:default>
            <thead>
              <tr>
                <th class="text-left">Name</th>
                <th class="text-left">Calories</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in user" :key="item.name">
                <td>{{ item.name }}</td>
                <td>{{ item.calories }}</td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>
      </v-dialog>
      <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
      <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
    </template>
  </v-data-table>
</template>
<script>
import createUser from "./modals/add_user.vue";
import ConfirmationDel from "./modals/confirmation/delete.vue";
export default {
  data: () => ({
    showModal: false,
    dialog: false,
    search: "",
    headers: [
      { text: "NAME", align: "start", sortable: false, value: "first_name" },
      { text: "ID NO.", value: "user_information.company_number" },
      { text: "COMPANY EMAIL", value: "email" },
      { text: "DEPARTMENT", value: "user_information.department_id" },
      { text: "PRP IN CHARGE", value: "prp_assigned" },
      { text: "STATUS", value: "user_information.company_status" },
      { text: "ACTIONS", value: "actions", sortable: false }
    ],
    user: [],
    editedIndex: -1,
    user_id: localStorage.getItem("id")
  }),
  components: {
    ConfirmationDel,
    createUser
  },
  mounted(){
    this.retrieve()
  },
  methods: {
    retrieve(){
      this.$axios.get("http://localhost:8000/hr/manage/user").then(response => {
        // console.log(response.data)
        this.user = response.data
        // this.user = response.data.first_name + '' + response.data.last_name
      })
    },
    //End
    editItem(item) {
      this.editedIndex = this.user.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.id = item.id;
      this.$refs.confirmDel.show(item)
    },
    confirmDel(){
      this.$axios
        .delete("http://localhost:8000/hr/manage/user/" + this.id)
        .then(response => {
          this.retrieve()
        });
    },
    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    save() {
      if (this.editedIndex > -1) {
        Object.assign(this.user[this.editedIndex], this.editedItem);
      } else {
        this.user.push(this.editedItem);
      }
      this.close();
    },
    seeItem(item) {
      this.showModal = true;
    }
  }
};
</script>