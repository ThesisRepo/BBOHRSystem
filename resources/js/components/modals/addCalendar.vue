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
              <v-col cols="12">
                <v-text-field label="Event*" v-model="event" required></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field label="Start Date" type="datetime-local" v-model="start_date" color="primary"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field label="End Date" type="datetime-local" v-model="end_date" color="primary"></v-text-field>
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
    dialog: false,
    start_date: null,
    end_date: null,
    time: null,
    event: null
  }),
  mounted() {
    // this.getShift()
  },
  methods: {
    save(){
        console.log(this.$parent)
        this.$parent.$parent.events.push({
            name: this.event,
            start: this.start_date,
            end: this.end_date,
            color: 'blue',
            timed: true,
        })
        // this.$parent.updateRange()
        console.log(this.$parent.$parent.events)
    }
  }
};
</script>
