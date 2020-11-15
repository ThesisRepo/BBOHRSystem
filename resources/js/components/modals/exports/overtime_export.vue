<template>
    <div>
        <v-row justify="center">
            <v-dialog v-model="dialog" persistent max-width="650px">
                <v-card>
                    <v-toolbar class="mb-2" color="blue darken-1" dark flat>
                        <v-card-title>
                            <v-col>
                                <span style="font-size: 18px">SUMMARY OF OVERTIME REQUEST:</span>
                            </v-col>

                            <span style="font-size: 15px">
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
                    <v-card-text v-if="summary.length > 0">
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
                    <v-card-text v-else>
                        <center>
                        <h1>No data</h1>
                        </center>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="red"
                            @click="dialog = false"
                            class="mr-2"
                            dark
                        >
                            Close
                        </v-btn>
                        <vue-json-to-csv
                            :json-data="summary"
                            :csv-title="
                                'SUMMARY OF OVERTIME REQUEST FROM' +
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
        summary: [],
        start_date: "",
        end_date: "",
        headers: [
            {
                text: "REQUESTER",
                align: "start",
                value: "user_id"
            },
            { text: "REASON", value: "reason" },
            { text: "OVERTIME DATE", value: "date" },
            { text: "START TIME", value: "start_time" },
            { text: "END TIME", value: "end_time" },
            { text: "STATUS", value: "status.status_name" }
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
                .post(
                    "http://localhost:8000/hr/summary/overtime_request",
                    param
                )
                .then(response => {
                    this.summary = response.data;
                });
            }else if(item === 'Disapproved Requests'){
                this.$axios
                .post(
                    "http://localhost:8000/hr/summary/overtime_request",
                    param
                )
                .then(response => {
                    this.summary = response.data;
                });
            }
            this.dialog = true;
        }
    }
};
</script>
