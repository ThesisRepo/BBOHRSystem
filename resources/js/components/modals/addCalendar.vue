<template>
  <v-row justify='end' id="move">
    <v-btn rounded color="light blue darken-2" outlined @click="dialog = true">
      <v-icon>mdi-plus</v-icon>Add Event
    </v-btn>
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat>
          <v-card-title>
            <span class="headline-bold">ADD EVENT</span>
          </v-card-title>
        </v-toolbar>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6">
                <v-text-field label="Title*" v-model="title" required></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-select label="Event Type*" :items="event_types" item-text="event_name" item-value="id" v-model="event_type" required></v-select>
              </v-col>
              <v-col cols="12">
                <!-- <v-text-field label="Content*" v-model="content" required></v-text-field> -->
                <v-textarea
                  outlined
                  label="Details*"
                  v-model="content"
                  rows="3"
                  required
                ></v-textarea>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field label="Start Date" type="datetime-local" v-model="start_date" color="primary"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field label="End Date" type="datetime-local" v-model="end_date" color="primary"></v-text-field>
              </v-col>
              <v-col cols="12" v-if="user_type.includes('hr mngr')">
                <v-checkbox
                  v-model="checkbox"
                  label="Public"
                ></v-checkbox>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red" dark @click="dialog = false">Cancel</v-btn>
          <v-btn color="success" @click="dialog = false, save()">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<style>
#move{
    margin-right: 3%;
}
</style>

<script>
export default {
  data: () => ({
    user_type: localStorage.getItem("user_type"),
    dialog: false,
    user_id: localStorage.getItem("id"),
    start_date: null,
    end_date: null,
    time: null,
    content: null,
    event_type: null,
    title: null,
    checkbox: false,
    event_types: [],
    retrieveRequest: []
  }),
  mounted() {
    this.getEventType()
  },
  methods: {
    save(){
      let params = {
        title: this.title,
        start_date: this.start_date,
        end_date: this.end_date,
        content: this.content,
        is_private: this.checkbox,
        event_type_id: this.event_type,
        user_id: this.user_id
      }
      console.log('parameter', params)
      this.$axios.post("events", params).then(response => {
        this.$parent.$parent.retrieve()
      })
    },
    getEventType(){
      this.$axios.get("user_info/event_types/" + this.user_id).then(response => {
        response.data.event_types.forEach(element => {
          this.event_types.push(element)
        })
      })
    }
  }
};
</script>
