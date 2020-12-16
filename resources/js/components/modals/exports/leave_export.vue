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
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="red" @click="dialog = false" class="mr-2" dark>Close</v-btn>
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
// import { GridPlugin } from '@syncfusion/ej2-vue-grids';
import Vue from "vue";
import VueJsonToCsv from 'vue-json-to-csv'
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
      { text: "REASON", value: "reason" },
      { text: "OVERTIME DATE", value: "date" },
      { text: "START TIME", value: "start_time" },
      { text: "END TIME", value: "end_time" },
      { text: "STATUS", value: "status.status_name" }
    ]
  }),
  provide: {
      grid: [Toolbar, ExcelExport]
  },
  components: {
    VueJsonToCsv,
    // GridPlugin
  },
  methods: {
    show(param1, param2, item) {
      this.start_date = param1;
      this.end_date = param2;
      let param = {
        start_date: param1 > param2 ? param2 : param1,
        end_date: param2 ? (param1 > param2 ? param1 : param2) : param1
      };
      console.log(param)
      if (item === "Approved Requests") {
        this.$axios
          .post("hr/summary/leave_request", param)
          .then(response => {
            this.summary = response.data;
            console.log(this.summary)
          });
      } else if (item === "Disapproved Requests") {
        this.$axios
          .post("hr/summary/leave_request", param)
          .then(response => {
            this.summary = response.data;
          });
      }
      this.dialog = true;
    },
    toolbarClick(args) {
        if (args.item.id === 'Grid_excelexport') { // 'Grid_excelexport' -> Grid component id + _ + toolbar item name
            let excelExportProperties = {
                // fileName: this.formatDate + ' Sales.xlsx',
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
