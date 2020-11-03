<template>
  <v-data-table :headers="headers" :items="user" class="elevation-1">
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
          <v-card>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.name" label="name"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.id_number" label="id_number"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.email" label="email"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.password" label="password"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.department" label="department"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.regularization_date"
                      label="regularization_date"
                    ></v-text-field>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="save">Save</v-btn>
            </v-card-actions>
          </v-card>
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
      {
        text: "NAME",
        align: "start",
        sortable: false,
        value: "name"
      },
      { text: "ID NO.", value: "id_number" },
      { text: "COMPANY EMAIL", value: "email" },
      { text: "PASSWORD", value: "password" },
      { text: "DEPARTMENT", value: "department" },
      { text: "REGULARIZATION DATE", value: "regularization_date" },
      { text: "ACTIONS", value: "actions", sortable: false }
    ],
    user: [],
    editedIndex: -1,
    editedItem: {
      name: "",
      id_number: 0,
      email: 0,
      password: 0,
      department: "",
      regularization_date: ""
    }
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
        console.log(response)
        // this.user = response
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
        .delete("http://localhost:8000/leave_request/" + this.id)
        .then(response => {
          // this.retrieve();x
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