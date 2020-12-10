<template>
  <v-row justify="end" id="event">
    <v-dialog scrollable v-model="dialog" persistent max-width="650px">
      <v-card>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat>
          <v-card-title>
            <span class="headline-bold">EVENT TYPE</span>
          </v-card-title>
        </v-toolbar>
        <v-card-text>
          <v-container>
            <!-- <span v-if="error" style="color: red; font-style: italic">All data are required!</span> -->
            <h5>{{ !showSave ? 'Save' : 'Update'}} New Event Type</h5>
            <v-row>
              <v-col cols="4">
                <v-text-field label="Event Title*" v-model="event_name" @keyup="validate('event_title')" require></v-text-field>
                <span class="ml-2" v-if="errorMessage1 !== null"  style="color: red; font-size: 12px">{{ errorMessage1 }}</span>
              </v-col>

              <v-col cols="4">
                <!-- <label for="color">Color</label> -->
                <!-- <input type="color" id="color" name="color" value="#e66465" size="50px"> -->
                <br>
                <select :style="color.style" class="form-control colorstyle" @change="validate('color')" v-model="color">

                  <option value="Colors" selected hidden>Colors*</option>
                  <option
                    v-for="(item, index) in colorItem"
                    :key="index"
                    :style="item.style"
                    :value="item.value"
                  >{{item.name}}</option>
                </select>
                <!-- <v-select
                  :items="colorItem"
                  label="Color*"
                  v-model="color"
                  item-text="name"
                  item-value="value"
                  required
                ></v-select>-->
              <span class="ml-2" v-if="errorMessage2 !== null" style="color: red; font-size: 12px">{{ errorMessage2 }}</span>
              </v-col>
              <v-col cols="4">
                <br>
                <v-btn
                  v-if="!showSave"
                  color="green"
                  class="white--text"
                  style="width: 1%;"
                  @click="toSave()"
                >Add</v-btn>
                <v-btn
                  v-else
                  color="green"
                  class="white--text"
                  @click="toUpdate()"
                  style="width: 1%;"
                >Update</v-btn>
                <v-btn
                  v-if="!showSave"
                  color="red"
                  class="white--text"
                  @click="clear"
                  style="width: 1%;"
                >Clear</v-btn>
                <v-btn v-else color="red" class="white--text" @click="add" style="width: 1%;">Cancel</v-btn>
              </v-col>
            </v-row>
            <v-data-table :headers="headers" :items="event_types" class="elevation-1">
              <template v-slot:top>
                <v-toolbar class="mb-2" color="blue darken-1" dark flat>
                  <v-toolbar-title
                    class="col pa-3 py-4 white--text"
                    style="font-size:16px"
                  >LIST OF EVENT TYPES</v-toolbar-title>
                </v-toolbar>
              </template>
              <template v-slot:item.color="{ item }">
                <input type="color" :value="item.color">
              </template>
              <template v-slot:item.actions="{ item }">
                <v-icon
                  medium
                  class="mr-2"
                  @click="item.event_name == 'Holiday' || item.event_name == 'Birthday' ? ' ' : editItem(item) "
                  :style="[ item.event_name == 'Holiday' || item.event_name == 'Birthday' ? {'color' : 'grey'} : {'color' : 'blue'}]"
                >mdi-pencil</v-icon>
                <v-icon
                  medium
                  @click="item.event_name == 'Holiday' || item.event_name == 'Birthday' ? ' ' : deleteItem(item)"
                  :style="[ item.event_name == 'Holiday' || item.event_name == 'Birthday' ? {'color' : 'grey'} : {'color' : 'red'}]"
                >mdi-delete</v-icon>
              </template>
            </v-data-table>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <!-- <v-btn color="red" dark @click="dialog = false">Close</v-btn> -->
          <v-btn color="red" dark @click="close()">Close</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <ConfirmationDel ref="confirmDel" @onConfirm="confirmDel($event)"></ConfirmationDel>
    <Confirmation
      ref="confirms"
      :title="confirmationTitle"
      :message="confirmationMessage"
      @onConfirm="confirm($event)"
    ></Confirmation>
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
.colorstyle {
  border-top-style: hidden;
  border-right-style: hidden;
  border-left-style: hidden;
  border-bottom-style: groove;
}
.center {
  text-align: center;
}
</style>

<script>
import ConfirmationDel from "./confirmation/delete.vue";
import Confirmation from "./confirmation/confirm.vue";
export default {
  data: () => ({
    showSave: false,
    event_name: null,
    error: false,
    color: "Colors",
    dialog: false,
    user_id: localStorage.getItem("id"),
    headers: [
      { text: "EVENT NAME", align: "start", value: "event_name" },
      { text: "EVENT COLOR", value: "color" },
      { text: "ACTIONS", value: "actions" }
    ],
    event_types: [],
    colorItem: [
      { value: "#FF0000", name: "Red", style: "background-color: red" },
      { value: "#FFA500", name: "Orange", style: "background-color: orange" },
      { value: "#FFFF00", name: "Yellow", style: "background-color: yellow" },
      { value: "#008000", name: "Green", style: "background-color: green" },
      { value: "#0000FF", name: "Blue", style: "background-color: blue" },
      { value: "#EE82EE", name: "Violet", style: "background-color: violet" },
      { value: "#FFC0CB", name: "Pink", style: "background-color: pink" }
    ],
    editedIndex: null,
    storeage: [],
    errorMessage1 : null,
    errorMessage2 : null,
    confirmationTitle:null,
    confirmationMessage: null,
  }),
  mounted() {
    this.getEventType();
  },
  components: {
    ConfirmationDel,
    Confirmation
  },
  methods: {
    validate(input){
      if (input === "event_title") {
        this.errorMessage1 = null;
        if (this.event_name === "" || this.event_name === null) {
          this.errorMessage1 = "Event name is required";
        } else {
          this.errorMessage1 = null;
        }
      }else if (input === "color") {
        this.errorMessage2 = null;
        if (this.color === "Colors" || this.color === null) {
          this.errorMessage2 = "Color is required";
        } else {
          this.errorMessage2 = null;
        }
      }
    },
    close() {
      this.event_name = "";
      this.color = "Colors";
      this.errorMessage1 = null;
      this.errorMessage2 = null;
      this.dialog = false;
    },
    show() {
      this.dialog = true;
    },
    confirm(){
      this.$store.commit("state_loading", true);
      if(this.confirmationTitle == 'Add Event Type'){
        this.save();
      }
      if(this.confirmationTitle == 'Update Event Type'){
        this.update();
      }
    },
    toSave() {
      this.validate("event_title");
      this.validate("color");
      if (
        this.errorMessage1 === null &&
        this.errorMessage2 === null
      ) {
        this.confirmationTitle = 'Add Event Type';
        this.confirmationMessage = 'Are you sure you want to Add new event type?';
        this.$refs.confirms.show();
      }
    },
    toUpdate() {
      this.validate("event_title");
      this.validate("color");
      if (
        this.errorMessage1 === null &&
        this.errorMessage2 === null
      ) {
        this.confirmationTitle = 'Update Event Type',
        this.confirmationMessage = 'Are you sure you want to update your event type?',
        this.$refs.confirms.show();
      }
    },
    save() {
      this.dialog = true;
      let params = {
        event_name: this.event_name,
        color: this.color
      };
      this.$axios.post("user_info/event_types/" + this.user_id, params).then(response => {
          this.$store.commit("state_loading", false);
          this.getEventType();
          this.event_name = null, 
          this.color = "Colors"
        }, this.timeout)  
        .catch(err => {
          this.$store.commit("state_loading", false);
        });
    },
    getEventType() {
      this.$axios
        .get("user_info/event_types/" + this.user_id)
        .then(response => {
          const event_types = [];
          response.data.event_types.forEach(element => {
            event_types.push(element);
          });
          this.event_types = event_types.reverse();
        }, this.timeout);
    },
    update() {
      let parameter = {
        id: this.storeage.id,
        event_name: this.event_name,
        color: this.color
      };
      this.$axios
        .post("event_types/" + this.storeage.id, parameter)
        .then(response => {
          this.$store.commit("state_loading", false);
          this.getEventType();
          this.event_name = null;
          this.color = "Colors";
          this.showSave = false;
          this.$store.commit("state_loading", false);
        }, this.timeout).catch((err)=> {
          this.$store.commit("state_loading", false);
        });
    },
    editItem(item) {
      this.storeage = item;
      this.editedIndex = this.event_types.indexOf(item);
      this.showSave = true;
      this.event_name = item.event_name;
      this.color = item.color;
    },
    clear() {
      this.event_name = null;
      this.color = "Colors";
    },
    add() {
      this.showSave = false;
      this.clear();
    },
    deleteItem(item) {
      this.id = item.id;
      this.$refs.confirmDel.show(item);
    },
    confirmDel() {
      this.$store.commit("state_loading", true);
      this.$axios.delete("event_types/" + this.id).then(response => {
        this.$store.commit("state_loading", false);
        this.getEventType();
      }, this.timeout).catch((err) => {
          this.$store.commit("state_loading", false);
      });
    }
  }
};
</script>
