<template>
  <div>
    <v-row justify="center">
        <v-dialog
        v-model="dialog"
        persistent
        max-width="600px"
        >
        <v-card>
                <v-card-title>
            <center>
                <span style="text-align: center">SUMMARY</span>
            </center>
                <br><br>
                <p>{{ start_date ? start_date : 'No start date selected' }} - {{ end_date ? end_date : 'No end date selected' }}</p>
                </v-card-title>
            <v-card-text>
                <v-container>
                    <template v-if="summary !== null">
                        <v-data-table
                            :headers="headers"
                            :items="summary"
                            class="elevation-1"
                        >
                            <template v-slot:header.name="{ header }">
                            {{ header.text.toUpperCase() }}
                            </template>
                        </v-data-table>
                    </template>
                    <template
                    v-else
                    >
                    <h1>"No data"</h1>
                    </template>
                </v-container>
            </v-card-text>
            <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
                color="blue darken-1"
                text
                @click="dialog = false"
            >
                Close
            </v-btn>
            <vue-json-to-csv :json-data="summary"
            :csv-title="'SUMMARY OF LEAVE REQUEST FROM' + start_date + '-' + end_date"
            >
            <v-btn
                color="blue darken-1"
                text
            >
                Export as CSV
            </v-btn>
            </vue-json-to-csv>
            </v-card-actions>
        </v-card>
        </v-dialog>
    </v-row>
  </div>
</template>
<script>
import VueJsonToCsv from 'vue-json-to-csv'
export default {
  data: () => ({
    dialog: false,
    summary: [],
    start_date: '',
    end_date: '',
    headers: [
        {
          text: 'REQUESTER',
          align: 'start',
          value: 'user_id',
        },
        { text: 'TYPE OF LEAVE', value: 'leave_type.leave_type_name' },
        { text: 'TOTAL DAY/S LEAVE', value: 'number_of_days' },
        { text: 'START DATE', value: 'start_date' },
        { text: 'END DATE', value: 'end_date' },
        { text: 'STATUS', value: 'status.status_name' },
      ],
 }),
 components: {
    'vue-json-to-csv': VueJsonToCsv
  },
 methods: {
     show(param1, param2){
         this.start_date = param1
         this.end_date = param2
         let param = {
             start_date: param1,
             end_date: param2
         }
         this.$axios.post('http://localhost:8000/hr/summary/leave_request', param).then( response =>{
             this.summary = response.data
         })
         this.dialog = true
     }
 }

    
}
</script>

