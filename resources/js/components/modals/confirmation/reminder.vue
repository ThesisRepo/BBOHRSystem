<template>
  <div class="text-center">
    <v-dialog v-model="dialog" width="500">
      <v-card>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat>
          <v-card-title>
              <span class="headline-bold ">Reminder</span>
          </v-card-title>
        </v-toolbar>
        
        <center>
          <v-card-text><b>{{ message }}</b></v-card-text>
        </center>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="success" @click="onConfirm()">Ok</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
export default {
  data() {
    return {
      id: null,
      dialog: false
    };
  },
  props: ['message'],
  methods: {
    show(id){
      this.id = id
      this.dialog = true
    },
    hideModal(){
      this.dialog = false
    },
    onConfirm(){
      this.hideModal()
    }
  }
};
</script>