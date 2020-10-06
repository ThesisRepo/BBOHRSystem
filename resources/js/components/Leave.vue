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
        <create></create>
      </v-col>
    </v-row>
    <br>
    <v-data-table :headers="headers" :items="desserts" :items-per-page="5" class="elevation-1"></v-data-table>
  </div>
</template>
<script>
import create from './modals/create_leave.vue'
export default {
  data() {
    return {
      show: false,
      headers: [
        {
          text: "Type of Leave",
          align: "start",
          sortable: false,
          value: "reason"
        },
        { text: "TOTAL DAY/S LEAVE", value: "days" },
        { text: "START DATE", value: "start_date" },
        { text: "END DATE", value: "end_date" },
        { text: "PRP IN CHARGE", value: "prp_assigned" },
        { text: "LEAVE STATUS", value: "status" }
      ],
      desserts: [
        {
          reason: "LOVE SICK",
          days: 3,
          start_date: "September 15, 2222",
          end_date: "September 18, 2222",
          prp_assigned: "Jessavel Toring",
          status: "pending"
        }
      ]
    };
  },
  components: {
    create
  },
  methods: {
    addRequest(){
      this.show = true
      console.log('gawas')
    }
  }
};
</script>