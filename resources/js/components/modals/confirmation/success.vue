<template>
  <div class="text-center">
    <v-snackbar
      v-model="snackbar"
      :multi-line="multiLine"
    >
      {{ messages }}

    <template v-slot:action="{ attrs }">
        <v-btn
          color="red"
          class="white--text"
          text
          v-bind="attrs"
          @click="snackbar = false"
        >
          Close
        </v-btn>
    <!-- <v-btn color="red" class="white--text" outlined @click="hideModal()">Close</v-btn> -->
    </template>
    </v-snackbar>
  </div>
</template>
<script>
export default {
  data() {
    return {
      multiLine: true,        
      snackbar: false
    };
  },
  props: ['messages'],
  methods: {
    show(){
      console.log('sadf')
      this.snackbar = true
    },
    hideModal(){
      this.snackbar = false
    }
  }
};
</script>