<template>
  <div>
    <v-row justify="center">
        <v-dialog
        v-model="dialog"
        persistent
        max-width="600px"
        >
        <v-card>
              v-toolbar class="mb-2" color="blue darken-1" dark flat>
                        <v-card-title>
                            <v-col >
                                <span style="font-size: 20px">SUMMARY:</span>
                            </v-col>

                            <span
                                style="font-size: 15px"
                            >
                                {{
                                    start_date
                                        ? start_date
                                        : "No start date selected"
                                }}
                                /
                                {{ end_date ? end_date : "END DATE" }}
                            </span>
                        </v-card-title>
                    </v-toolbar>
            <v-card-text>
                <v-container>
                    <template>
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
                </v-container>
            </v-card-text>
            <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
                color="blue darken-1"
                @click="dialog = false"
                class="mr-2"
                dark
            >
                Close
            </v-btn>
            <vue-json-to-csv :json-data="summary"
            :csv-title="'SUMMARY OF PETTY CASH REQUEST FROM' + start_date + '-' + end_date"
            >
            <v-btn
                v-btn color="success" class ="mr-8"
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
        { text: 'DESCRIPTION', value: 'description_need' },
        { text: 'DATE', value: 'date' },
        { text: 'DEPARTMENT', value: 'department.department.name' },
        { text: 'TOTAL AMOUNT', value: 'total_amount' },
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
         this.$axios.post('http://localhost:8000/hr/summary/petty_cash_request', param).then( response =>{
             this.summary = response.data
         })
         this.dialog = true
     }
 }

    
}
</script>

