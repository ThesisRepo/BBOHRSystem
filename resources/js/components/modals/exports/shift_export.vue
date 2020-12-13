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
          <v-card-text>
            <ejs-grid ref='grid' id='Grid' :dataSource='summary' :toolbar='toolbarOptions' height='270px' :allowPaging='true' :allowExcelExport='true' :toolbarClick='toolbarClick'>
                <e-columns>
                    <e-column field='Date' headerText='Date' width=120></e-column>
                    <e-column field='Products' headerText='All Products' width=150></e-column>
                    <e-column field='Add_ons' headerText='Add-Ons' width=150></e-column>
                    <e-column field='DeliveryFee' headerText='Delivery Fee' width=150></e-column>
                    <e-column field='CupType' headerText='Cup Type' width=150></e-column>
                    <e-column field='TotalSales' headerText='Total Sales' width=150></e-column>
                </e-columns>
            </ejs-grid>
          </v-card-text>
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
            <!-- <vue-json-to-csv
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
export default {
  data: () => ({
    toolbarOptions: ['ExcelExport'],
    dialog: false,
    search: "",
    summary: [],
    start_date: "",
    end_date: ""
  }),
  components: {
    // "vue-json-to-csv": VueJsonToCsv
  },
  methods: {
    show(param1, param2, item) {
      this.start_date = param1;
      this.end_date = param2;
      let param = {
        start_date: param1 > param2 ? param2 : param1,
        end_date: param2 ? (param1 > param2 ? param1 : param2) : param1
      };
      if(item === 'Approved Requests'){
        this.$axios
        .post("hr/summary/shift_change_request/approved/", param)
        .then(response => {
            this.summary = response.data;
            this.summary = response.data.feedbacked_shift_change_requests;
            // this.summary.forEach(el => {
            //   this.summary.push(el)
            // });
        });
      }else if(item === 'Disapproved Requests'){
        this.$axios
        .post("hr/summary/shift_change_request/disapproved/", param)
        .then(response => {
            this.summary = response.data;
        });
      }
      this.dialog = true;
    },
    toolbarClick(args) {
        if (args.item.id === 'Grid_excelexport') { // 'Grid_excelexport' -> Grid component id + _ + toolbar item name
            let excelExportProperties = {
                fileName: ' Shift Change Request.xlsx',
                header: {
                    headerRows: 7,
                    rows: [
                        { cells: [{ colSpan: 6, value: "Driptea System", style: { fontColor: '#C67878', fontSize: 20, hAlign: 'Center', bold: true, } }] },
                        { cells: [{ colSpan: 6, value: "A.C. Cortes Ave., Looc", style: { fontColor: '#C67878', fontSize: 15, hAlign: 'Center', bold: true, } }] },
                        { cells: [{ colSpan: 6, value: "6014 Mandaue City, Philippine", style: { fontColor: '#C67878', fontSize: 15, hAlign: 'Center', bold: true, } }] },
                        { cells: [{ colSpan: 6, value: "0917 329 7269", style: { fontColor: '#C67878', fontSize: 15, hAlign: 'Center', bold: true, } }] },
                        { cells: [{ colSpan: 6, hyperlink: { target: 'https://www.facebook.com/driptealoocmandaue/', displayText: 'www.facebook.com/driptealoocmandaue' }, style: { hAlign: 'Center' } }] },
                        { cells: [{ colSpan: 6, hyperlink: { target: 'samuelazurajr@gmail.com' }, style: { hAlign: 'Center' } }] },
                    ]
                },
                footer: {
                    footerRows: 3,
                    rows: [
                        { cells: [{ colSpan: 6, value: ("Total Sales: " + this.overAllTotal), style: { hAlign: 'Right', bold: true } }] },
                        { cells:  [{ colSpan: 2, value: "Print By: " + this.adminName + '  ' +  moment(new Date()).format('MM/DD/YYYY'), style: {fontSize: 15, hAlign: 'Left', bold: true, }},]},
                    ]
                }
            };
            this.$refs.grid.excelExport(excelExportProperties);
        }
    },
  }
};
</script>
