<template>
  <div>
    <v-toolbar flat>
      <template v-slot:extension>
        <v-tabs
          fixed-tabs
          v-if="user_type === 'hr mngr' || user_type === 'prp emp' || user_type === 'general mngr'"
        >
          <v-tabs-slider></v-tabs-slider>
          <v-tab @click="employees = false, requests = true">
            <!-- <v-icon>mdi-phone</v-icon> -->
            Employees Requests
          </v-tab>
          <v-tab @click="requests = false, employees = true">
            <!-- <v-icon>mdi-heart</v-icon> -->
            My Requests
          </v-tab>
        </v-tabs>
      </template>
    </v-toolbar>
    <v-data-table v-if="!employees" :headers="headers" :items="desserts" class="elevation-3">
      <template v-slot:top>
        <v-toolbar flat>
          <!-- <v-toolbar-title>Employees Leave Request</v-toolbar-title> -->
          <v-col class="mt-8">
            <v-select :items="items" label="Month"></v-select>
          </v-col>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <v-btn depressed color="primary">SUMMARY</v-btn>
          <v-divider class="mx-4" vertical></v-divider>
          <v-spacer></v-spacer>
          <v-text-field
            v-model="search"
            v-icon="mdi-magnify"
            label="Search"
            single-line
            hide-details
            class="mx-5"
          ></v-text-field>
          <v-dialog v-model="dialog">
            <v-card class="mt-5">
              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.reason" label="reason"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.shift_date" label="shift_date"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.shift_time" label="shift_time"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.prp_assigned" label="prp_assigned"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.status" label="status"></v-text-field>
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
          <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="headline">Are you sure you want to delete this item?</v-card-title>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
        <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
      </template>
      <template v-slot:no-data>
        <v-btn color="primary" @click="initialize">Reset</v-btn>
      </template>
    </v-data-table>

    <v-data-table v-if="!requests && (user_type !== 'hr mngr' || user_type !== 'prp emp' || user_type !== 'general mngr')" :headers="headers" :items="desserts" class="elevation-3">
      <template v-slot:top>
      <v-toolbar class="mb-2" color="blue darken-1" dark flat>
        <v-toolbar-title class="col pa-3 py-4 white--text"
          >SHIFT REQUEST</v-toolbar-title
        >
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
            <createShift></createShift>
          </template>
          <v-card>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.reason"
                      label="reason"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.date"
                      label="date"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.start_time"
                      label="start_time"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.prp_assigned"
                      label="prp_assigned"
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
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close"> Cancel </v-btn>
              <v-btn color="blue darken-1" text @click="save"> Save </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="headline"
              >Are you sure you want to delete this item?</v-card-title
            >
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete"
                >Cancel</v-btn
              >
              <v-btn color="blue darken-1" text @click="deleteItemConfirm"
                >OK</v-btn
              >
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
      <template v-slot:item.actions="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
        <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
      </template>
      <template v-slot:no-data>
        <v-btn color="primary" @click="initialize">Reset</v-btn>
      </template>
    </v-data-table>
  </div>
</template>
<script>
import createShift from './modals/create_shift.vue'
export default {
  data: () => ({
    user_type: localStorage.getItem("user_type"),
    employees: ( localStorage.getItem("user_type") !== 'emp' && localStorage.getItem('user_type') !== 'finance mngr' ) ? false : true,
    requests: ( localStorage.getItem("user_type") !== 'emp' && localStorage.getItem('user_type') !== 'finance mngr' ) ? true : false,
    dialog: false,
    dialogDelete: false,
    headers: [
      {
        text: "REASON",
        align: "start",
        sortable: false,
        value: "reason"
      },
      { text: "SHIFT DATE", value: "shift_date" },
      { text: "SHIFT TIME", value: "shift_time" },
      { text: "PRP IN CHARGE", value: "prp_assigned" },
      { text: "STATUS", value: "status" },
      { text: "ACTIONS", value: "actions", sortable: false }
    ],
    desserts: [],
    editedIndex: -1,
    editedItem: {
      reason: "",
      shift_date: 0,
      shift_time: 0,
      prp_assigned: "",
      status: ""
    },
    defaultItem: {
      reason: "",
      shift_date: 0,
      end_date: 0,
      prp_assigned: "",
      status: ""
    },
    items: ["Foo", "Bar", "Fizz", "Buzz"]
  }),
  components: {
    createShift
  },
  mounted(){
    console.log('----------testing------------', this.user_type, this.requests, this.employees)
  },
  methods: {
    initialize() {
      this.desserts = [
        {
          reason: "Wlay kwarta",
          shift_date: 159,
          shift_time: 6,
          prp_assigned: "claire",
          status: "pending"
        }
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
    }
  }
};
</script>
