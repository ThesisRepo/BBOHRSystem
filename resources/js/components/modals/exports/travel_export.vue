<template>
  <div>
    <v-row justify="center">
      <v-dialog v-model="dialog" persistent max-width="800px">
        <v-card>
          <v-toolbar class="mb-2" color="blue darken-1" dark flat>
            <v-card-title>
              <v-col>
                <span style="font-size: 18px">SUMMARY OF TRAVEL AUTHORIZATION REQUEST:</span>
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
                    <e-column field='user.email' headerText='REQUESTER' width=150></e-column>
                    <e-column field='destination' headerText='DESTINATION' width=150></e-column>
                    <e-column field='start_date' headerText='START DATE' width=120></e-column>
                    <e-column field='end_date' headerText='END DATE' width=150></e-column>
                    <e-column field='emergency_contact' headerText='EMERGENCY CONTACT' width=150></e-column>
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
import Vue from "vue";
Vue.use(GridPlugin)
export default {
  data: () => ({
    toolbarOptions: ['ExcelExport'],
    dialog: false,
    summary: [],
    start_date: "",
    end_date: ""
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
        .post("hr/summary/travel_auth_request", param)
        .then(response => {
            this.summary = response.data;
            console.log(this.summary)
        });
      }else if(item === 'Disapproved Requests'){
        this.$axios
        .post("hr/summary/travel_auth_request", param)
        .then(response => {
            this.summary = response.datas;
        });
      }
      this.dialog = true;
    },
    toolbarClick(args) {
        if (args.item.id === 'Grid_excelexport') { // 'Grid_excelexport' -> Grid component id + _ + toolbar item name
            let excelExportProperties = {
                fileName: ' Travel Authorization Request.xlsx',
                header: {
                    headerRows: 5,
                    rows: [
                        { cells: [{ colSpan: 5, value: "BBO REQUEST MANAGEMENT SYSTEM", style: { fontColor: '#0000FF', fontSize: 20, hAlign: 'Center', bold: true, } }] },
                        { cells: [{ colSpan: 5, value: "Unit 1, 8F Mabuhay Tower IT Park", style: { fontColor: '#0000FF', fontSize: 15, hAlign: 'Center', bold: true, } }] },
                        { cells: [{ colSpan: 5, value: "Cebu City, 6000 Cebu, Philippines", style: { fontColor: '#0000FF', fontSize: 15, hAlign: 'Center', bold: true, } }] },
                        { cells: [{ colSpan: 5, value: "(032) 328 2321", style: { fontColor: '#0000FF', fontSize: 15, hAlign: 'Center', bold: true, } }] }
                    ]
                },
            };
            this.$refs.grid.excelExport(excelExportProperties);
        }
    },
  }
};
</script>
