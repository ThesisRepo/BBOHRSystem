<template>
  <div>
    <v-row justify="center">
      <v-dialog v-model="dialog" persistent max-width="600px">
        <v-card>
          <v-toolbar class="mb-2" color="blue darken-1" dark flat>
            <v-card-title>
              <v-col>
                <span style="font-size: 18px">SUMMARY OF PETTY CASH REQUEST:</span>
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
          <v-card-text>
            <ejs-grid ref='grid' id='Grid' :dataSource='summary' :toolbar='toolbarOptions' height='270px' :allowPaging='true' :allowExcelExport='true' :toolbarClick='toolbarClick'>
                <e-columns>
                    <e-column field='description_need' headerText='Description' width=120></e-column>
                    <e-column field='date' headerText='Date' width=150></e-column>
                    <e-column field='department.department_name' headerText='Department' width=150></e-column>
                    <e-column field='amount' headerText='Amount' width=150></e-column>
                </e-columns>
            </ejs-grid>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="red" @click="dialog = false" class="mr-2" dark>Close</v-btn>
            <!-- <vue-json-to-csv
              :json-data="summary"
              :csv-title="'SUMMARY OF PETTY CASH REQUEST FROM' + start_date + '-' + end_date"
            >
              <v-btn color="success" v-if="summary.length > 0" class="mr-8">Export as CSV</v-btn>
              <v-btn disabled v-else class="mr-8">Export as CSV</v-btn>
            </vue-json-to-csv> -->
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>
  </div>
</template>
<style scoped>
@import url('https://cdn.syncfusion.com/ej2/material.css');
</style>
<script>
import { GridPlugin, Toolbar, ExcelExport } from "@syncfusion/ej2-vue-grids";
import Vue from "vue";
Vue.use(GridPlugin)
export default {
  data: () => ({
    toolbarOptions: ['ExcelExport'],
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
      { text: "DESCRIPTION", value: "description_need" },
      { text: "DATE", value: "date" },
      { text: "DEPARTMENT", value: "department.department.name" },
      { text: "TOTAL AMOUNT", value: "total_amount" },
      { text: "STATUS", value: "status.status_name" }
    ]
  }),
  provide: {
      grid: [Toolbar, ExcelExport]
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
        .post("hr/summary/petty_cash_request", param)
        .then(response => {
          this.summary = response.data.feedbacked_petty_cash_requests;
        });
      }else if(item === 'Disapproved Requests'){
        this.$axios
        .post("finance/summary/petty_cash_request", param)
        .then(response => {
            this.summary = response.data.feedbacked_petty_cash_requests;
        });
      }
      this.dialog = true;
    },
    toolbarClick(args) {
        if (args.item.id === 'Grid_excelexport') { // 'Grid_excelexport' -> Grid component id + _ + toolbar item name
            let excelExportProperties = {
                fileName: ' Petty Cash Request.xlsx',
                header: {
                    headerRows: 5,
                    rows: [
                        { cells: [{ colSpan: 4, value: "BBO REQUEST MANAGEMENT SYSTEM", style: { fontColor: '#C67878', fontSize: 20, hAlign: 'Center', bold: true, } }] },
                        { cells: [{ colSpan: 4, value: "Unit 1, 8F Mabuhay Tower IT Park", style: { fontColor: '#C67878', fontSize: 15, hAlign: 'Center', bold: true, } }] },
                        { cells: [{ colSpan: 4, value: "Cebu City, 6000 Cebu, Philippine", style: { fontColor: '#C67878', fontSize: 15, hAlign: 'Center', bold: true, } }] },
                        { cells: [{ colSpan: 4, value: "09269753710", style: { fontColor: '#C67878', fontSize: 15, hAlign: 'Center', bold: true, } }] }
                    ]
                },
            };
            this.$refs.grid.excelExport(excelExportProperties);
        }
    },
  }
};
</script>

