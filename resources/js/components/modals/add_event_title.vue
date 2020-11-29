<template>
  <v-row justify="end" id="event">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat>
          <v-card-title>
            <span class="headline-bold">EVENT TYPE</span>
          </v-card-title>
        </v-toolbar>
        <v-card-text>
          <v-container>
            <h5>Add New Event Type</h5>
            <v-row>
              <v-col cols="4">
                <v-text-field label="Event Title*" v-model="event_name" require></v-text-field>
              </v-col>
              <v-col cols="4">
                <br>
                <label for="color">Color</label>
                <input type="color" id="color" name="color" value="#e66465" size="50px">
              </v-col>
              <v-col cols="4">
                <br>
                <v-btn color="green" class="white--text" @click="save()">Add</v-btn>&nbsp;
                <v-btn color="red" class="white--text">Clear</v-btn>
              </v-col>
            </v-row>
            <v-data-table :headers="headers" :items="event_types" class="elevation-1">
              <template v-slot:top>
                <v-toolbar class="mb-2" color="blue darken-1" dark flat>
                  <v-toolbar-title class="col pa-3 py-4 white--text" style="font-size:16px">LIST OF EVENT TYPES</v-toolbar-title>
                </v-toolbar>
              </template><template v-slot:item.actions="{ item }">
                <v-icon medium class="mr-2" @click="editItem(item)" style="color:blue">mdi-pencil</v-icon>
                <v-icon medium @click="deleteItem(item)" style="color:red">mdi-delete</v-icon>
              </template>
            </v-data-table>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red" dark @click="dialog = false">Ok</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<style>
#event {
  margin-right: 21%;
}
label {
  font: 1rem "Fira Sans", sans-serif;
}

input {
  margin: 0.4rem;
}
.center{
  text-align: center;
}
</style>

<script>
export default {
  data: () => ({
    event_name: null,
    color: null,
    dialog: false,
    user_id: localStorage.getItem("id"),
    headers: [
      { text: "EVENT NAME", align: "start", value: "event_name" },
      { text: "EVENT COLOR", value: "color" },
      { text: "ACTIONS", value: "actions" }
    ],
    event_types: []
  }),
  mounted() {
    this.getEventType();
  },
  methods: {
    show(){
      this.dialog = true
    },
    save() {
      let params = {
        event_name: this.event_name,
        color: this.color
      };
      console.log("parameter", params);
      this.$axios.post("user_info/event_types/" + this.user_id, params).then(response => {
        console.log('hi response me', response.data)
        // this.$parent.$parent.retrieve();
      });
    },
    getEventType() {
      this.$axios
        .get("user_info/event_types/" + this.user_id)
        .then(response => {
          response.data.event_types.forEach(element => {
            this.event_types.push(element);
          });
        });
    }
  }
};
</script>