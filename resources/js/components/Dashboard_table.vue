<template>
  <v-data-table :headers="headers" :items="desserts" class="elevation-1">
    <template v-slot:top>
    <v-toolbar
          class="mb-2"
          color="blue darken-1"
          dark
          flat
        >
        <v-toolbar-title class="col pa-3 py-4 white--text"
          >REQUESTS STATUS</v-toolbar-title
        >
    </v-toolbar>
        <v-dialog v-model="dialog" max-width="500px">
          <v-card>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.date"
                      label="date"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.type_request"
                      label="type_request"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.status"
                      label="status"
                    ></v-text-field>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>
          </v-card>
        </v-dialog>
    </template>

    <template v-slot:no-data>
      <v-btn color="primary" @click="initialize"> Reset </v-btn>
    </template>
  </v-data-table>
</template>
<script>
export default {
  data: () => ({
    dialog: false,
    dialogDelete: false,
    headers: [
      {
        text: "DATE",
        align: "start",
        value: "date",
      },
      { text: "TYPE OF REQUEST", value: "type_request" },
      { text: "STATUS", value: "status" },
    ],
    desserts: [],
    editedIndex: -1,
    editedItem: {
      date: "",
      type_request: "",
      status: "",
    },
    defaultItem: {
      date: "",
      type_request: "",
      status: "",
    },
  }),
  methods: {
    initialize() {
      this.desserts = [
        {
          date: "September 8, 2020",
          type_request: "Leave Request",
          status: "Pending in HR",
        },
      ];
    },
    editItem(item) {
      this.editedIndex = this.desserts.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.desserts.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      this.desserts.splice(this.editedIndex, 1);
      this.closeDelete();
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    save() {
      if (this.editedIndex > -1) {
        Object.assign(this.desserts[this.editedIndex], this.editedItem);
      } else {
        this.desserts.push(this.editedItem);
      }
      this.close();
    },
  },
};
</script>