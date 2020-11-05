<template>
  <v-data-table :headers="headers" :items="requests" class="elevation-1">
    <template v-slot:top>
    <v-toolbar class="mb-2" color="blue darken-1" dark flat>
      <v-toolbar-title class="col pa-3 py-4 white--text" style="font-size:16px">REQUESTS STATUS</v-toolbar-title>
    </v-toolbar>
    </template>
    <template v-slot:item.status.status_name="{ item }"> <span>{{item.status + 'bsag'}}</span> </template>
  </v-data-table>
</template>
<script>
export default {
  data: () => ({
    user_id: localStorage.getItem("id"),
    headers: [
      { text: "DATE", align: "start", value: "created_at" },
      { text: "TYPE OF REQUEST", value: "request_type" },
      { text: "STATUS", value: "status.status_name" },
    ],
    requests: [],
  }),
  mounted(){
    this.getRequests()
  },
  methods: {
    getRequests(){
      this.$axios.get('http://localhost:8000/user_info/pending_requests/' + this.user_id).then(response =>{
        console.log('requests', response.data)
        this.requests = response.data
      })
    }
  }
}
</script>