<template>
  <v-row justify="end" id="event">
    <v-dialog v-model="dialog" persistent max-width="650px">
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
                <!-- <label for="color">Color</label> -->
                <!-- <input type="color" id="color" name="color" value="#e66465" size="50px"> -->
                <br>
                <select :style="color.style" class="form-control colorstyle" v-model="color">
                  <option value="Colors" selected hidden>Colors*</option>
                  <option v-for="(item, index) in colorItem" :key="index" :style="item.style" :value="item.value">{{item.name}}</option>
                </select>
                <!-- <v-select
                  :items="colorItem"
                  label="Color*"
                  v-model="color"
                  item-text="name"
                  item-value="value"
                  required
                ></v-select> -->
              </v-col>
              <v-col cols="4">
                <br>
                <v-btn v-if="!showSave" color="green" class="white--text" @click="save()">Add</v-btn>
                <v-btn v-else color="green" class="white--text" @click="update()">Update</v-btn>
                <v-btn v-if="!showSave" color="red" class="white--text" @click="clear">Clear</v-btn>
                <v-btn v-else color="red" class="white--text" @click="add">Cancel</v-btn>
              </v-col>
            </v-row>
            <v-data-table :headers="headers" :items="event_types" class="elevation-1">
              <template v-slot:top>
                <v-toolbar class="mb-2" color="blue darken-1" dark flat>
                  <v-toolbar-title class="col pa-3 py-4 white--text" style="font-size:16px">LIST OF EVENT TYPES</v-toolbar-title>
                </v-toolbar>
              </template>
              <template v-slot:item.color="{ item }">
                <input type="color" :value="item.color">
              </template>
              <template v-slot:item.actions="{ item }">
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
    
    <ConfirmationDel
      ref="confirmDel"
      @onConfirm="confirmDel($event)"
    ></ConfirmationDel>
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
.colorstyle{
  border-top-style: hidden;
  border-right-style: hidden;
  border-left-style: hidden;
  border-bottom-style: groove;
}
.center{
  text-align: center;
}
</style>

<script>
import ConfirmationDel from "./confirmation/delete.vue";
export default {
  data: () => ({
    showSave: false,
    event_name: null,
    color: 'Colors',
    dialog: false,
    user_id: localStorage.getItem("id"),
    headers: [
      { text: "EVENT NAME", align: "start", value: "event_name" },
      { text: "EVENT COLOR", value: "color" },
      { text: "ACTIONS", value: "actions" }
    ],
    event_types: [],
    colorItem: [
      { value: '#FF0000', name: "Red", style: 'background-color: red' },
      { value: '#FFA500', name: "Orange", style: 'background-color: orange' },
      { value: '#FFFF00', name: "Yellow", style: 'background-color: yellow' },
      { value: '#008000', name: "Green", style: 'background-color: green' },
      { value: '#0000FF', name: "Blue", style: 'background-color: blue' },
      { value: '#EE82EE', name: "Violet", style: 'background-color: violet' }
    ],
    editedIndex: null,
    storeage: []
  }),
  mounted() {
    this.getEventType();
  },
  components: {
    ConfirmationDel
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
        // this.getEventType()
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
    },
    update(){
      let parameter = {
        id: this.storeage.id,
        event_name: this.event_name,
        color: this.color
      }
      this.$axios.post('event_types/' + this.storeage.id, parameter).then( response =>{
      })
    },
    editItem(item){
      this.storeage = item
      this.editedIndex = this.event_types.indexOf(item);
      this.showSave = true
      this.event_name = item.event_name
      this.color = item.color
    },
    clear(){
      this.event_name = null
      this.color = 'Colors'
    },
    add(){
      this.showSave = false
      this.clear()
    },
    deleteItem(item){
      this.id = item.id; 
      this.$refs.confirmDel.show(item)
    },
    confirmDel(){
      this.$axios
        .delete("event_types/" + this.id)
        .then(response => {
          // this.retrieve();
        });
    },
  }
};
</script>