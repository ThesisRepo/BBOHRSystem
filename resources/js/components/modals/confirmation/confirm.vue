<template>
  <div class="text-center">
    <v-dialog v-model="dialog" width="500">
      <v-card>
        <v-card-title class="headline grey lighten-2">{{ title }}</v-card-title>

        <v-card-text>{{ message }}</v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text @click="hideModal()">Cancel</v-btn>
          <v-btn color="green darken-1" text @click="onConfirm()">Confirm</v-btn>
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
  props: ['title', 'message'],
  methods: {
    show(id){
      this.id = id
      this.dialog = true
    },
    hideModal(){
      this.dialog = false
    },
    onConfirm(){
      this.$emit('onConfirm', {id: this.id})
      this.id = null
      this.hideModal()
    }
  }
};
</script>