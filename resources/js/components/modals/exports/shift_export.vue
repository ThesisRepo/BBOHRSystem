<template>
  <div>
    <v-row justify="center">
      <v-dialog v-model="dialog" persistent max-width="650px">
        <v-card>
          <v-toolbar class="mb-2" color="blue darken-1" dark flat>
            <!-- <v-card-title> -->
                <span style="font-size: 18px">SUMMARY OF SHIFT CHANGE REQUEST:
                  <span style="font-size: 15px">
                    {{
                    start_date
                    ? start_date
                    : "No start date selected"
                    }}
                    {{ end_date ? ' up to ' + end_date : '' }}
                  </span>
                </span>
            <!-- </v-card-title> -->
          </v-toolbar>
          <v-card-text>
            <ejs-grid ref='grid' id='Grid' :dataSource='summary' :toolbar='toolbarOptions' height='270px' :allowPaging='true' :allowExcelExport='true' :toolbarClick='toolbarClick'>
                <e-columns>
                    <e-column field='user.email' headerText='REQUESTER' width=120></e-column>
                    <e-column field='reason' headerText='REASON' width=150></e-column>
                    <e-column field='shift_date' headerText='SHIFT DATE' width=150></e-column>
                    <e-column field='shift_time.shift_time_name' headerText='SHIFT TIME' width=150></e-column>
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
    search: "",
    summary: [],
    start_date: "",
    end_date: ""
  }),
  components: {
    // "vue-json-to-csv": VueJsonToCsv
  },
  provide: {
      grid: [Toolbar, ExcelExport]
  },
  methods: {
    show(param1, param2, item) {
      this.start_date = param1;
      this.end_date = param2;
      let param = {
        start_date: this.start_date,
        end_date: this.end_date
      };
      if(item === 'Approved Requests'){
        this.$axios
        .post("hr/summary/shift_change_request/approved/", param)
        .then(response => {
            this.summary = response.data;
            console.log('afd', this.summary)
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
                fileName: 'Shift Change Request.xlsx',
                header: {
                    headerRows: 4,
                    rows: [
                        { cells: [{ colSpan: 4, value: "Blue Bee One Management System", style: { fontColor: '#0000FF', fontSize: 20, hAlign: 'Center', bold: true, } }] },
                        { cells: [{ colSpan: 4, value: "Unit 1, 8F Mabuhay Tower IT Park", style: { fontColor: '#0000FF', fontSize: 15, hAlign: 'Center', bold: true, } }] },
                        { cells: [{ colSpan: 5, value: "Cebu City, 6000 Cebu, Philippines", style: { fontColor: '#0000FF', fontSize: 15, hAlign: 'Center', bold: true, } }] },
                        { cells: [{ colSpan: 4, value: "(032) 328 2321", style: { fontColor: '#0000FF', fontSize: 15, hAlign: 'Center', bold: true, } }] }
                    ]
                }
            };
            this.$refs.grid.excelExport(excelExportProperties);
        }
    },
  }
};
</script>
