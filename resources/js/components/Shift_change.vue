<template>
  <div>
    <v-row>
      <v-col cols="10">
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-col>
      <v-col cols="2">
        <createShift></createShift>
      </v-col>
    </v-row>
    <br>
    <v-data-table :headers="headers" :items="desserts" :items-per-page="5" class="elevation-1"></v-data-table>
  </div>
</template>
<script>
import createShift from './modals/create_shift.vue'
export default {
  data() {
    return {
      show: false,
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
        { text: "REQUEST STATUS", value: "status" }
      ],
      desserts: [
        {
          reason: "LOVE SICK",
          shift_date: 3,
          shift_time: "September 15, 2222",
          prp_assigned: "Jessavel Toring",
          status: "pending"
        }
      ]
    };
  },
  components: {
    createShift
  },
  methods: {
  }
};
</script>