<template>
  <v-row justify="end" id="event">
    <!-- <v-btn color="light blue darken-2" rounded outlined @click="dialog = true">
      <v-icon>mdi-plus</v-icon>Event Type
    </v-btn> -->
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat>
          <v-card-title>
            <span class="headline-bold">EVENT TYPE</span>
          </v-card-title>
        </v-toolbar>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="8">
                <v-text-field label="Event Title*" v-model="event_title" require></v-text-field>
              </v-col>
              <div>
                <br>
                <br>
                <label for="color">Color</label>
                <input type="color" id="color" name="color" value="#e66465" size="50px">
              </div>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red" dark @click="dialog = false">Cancel</v-btn>
          <v-btn color="success" @click="(dialog = false), save()">Save</v-btn>
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
</style>

<script>
export default {
  data: () => ({
    event_title: null,
    dialog: false
  }),
  mounted() {
    this.getEventType();
  },
  methods: {
    show(){
      console.log('im here')
      this.dialog = true
    },
    save() {
      let params = {
        event_title: this.event_title
      };
      console.log("parameter", params);
      this.$axios.post("events", params).then(response => {
        this.$parent.$parent.retrieve();
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