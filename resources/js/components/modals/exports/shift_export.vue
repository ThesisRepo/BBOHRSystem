<template>
  <div>
    <v-row justify="center">
      <v-dialog v-model="dialog" persistent max-width="650px">
        <v-card>
          <v-toolbar class="mb-2" color="blue darken-1" dark flat>
            <v-card-title>
              <v-col>
                <span style="font-size: 18px">SUMMARY OF SHIFT CHANGE REQUEST:</span>
              </v-col>

              <span style="font-size: 15px">
                {{
                start_date
                ? start_date
                : "No start date selected"
                }}
                /
                {{ end_date ? end_date : start_date }}
              </span>
            </v-card-title>
          </v-toolbar>
          <v-card-text v-if="summary.length > 0">
            <v-container>
              <template>
                <v-data-table
                  :headers="headers"
                  :items="summary"
                  :search="search"
                  class="elevation-1"
                >
                  <template v-slot:header.name="{ header }">{{ header.text.toUpperCase() }}</template>
                </v-data-table>
              </template>
            </v-container>
          </v-card-text>
          <v-card-text v-else>
            <center>
              <h1>No data</h1>
            </center>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="red" @click="dialog = false" class="mr-2" dark>Close</v-btn>
            <vue-json-to-csv
              :json-data="summary"
              :csv-title="
                                'SUMMARY OF SHIFT REQUEST FROM' +
                                    start_date +
                                    '-' +
                                    end_date
                            "
            >
              <v-btn color="success" v-if="summary.length > 0" class="mr-8">Export as CSV</v-btn>
              <v-btn disabled v-else class="mr-8">Export as CSV</v-btn>
            </vue-json-to-csv>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>
  </div>
</template>
<script>
import VueJsonToCsv from "vue-json-to-csv";
export default {
  data: () => ({
    dialog: false,
    search: "",
    summary: [],
    start_date: "",
    end_date: "",
    headers: [
      {
        text: "DATE",
        align: "start",
        value: "shift_date"
      },
      { text: "REQUESTER", value: "user_id" },
      { text: "REASON", value: "reason" },
      { text: "SHIFT DATE", value: "shift_date" },
      { text: "SHIFT TIME", value: "shift_time_id" },
      { text: "STATUS", value: "status_id" }
    ]
  }),
  components: {
    "vue-json-to-csv": VueJsonToCsv
  },
  methods: {
    show(param1, param2, item) {
      this.start_date = param1;
      this.end_date = param2;
      let param = {
        start_date: param1,
        end_date: param2
      };
      if(item === 'Approved Requests'){
        this.$axios
        .post("hr/summary/shift_change_request", param)
        .then(response => {
            this.summary = response.data;
        });
      }else if(item === 'Disapproved Requests'){
        this.$axios
        .post("hr/summary/shift_change_request", param)
        .then(response => {
            this.summary = response.data;
        });
      }
      this.dialog = true;
    }
  }
};
</script>
