<template>
  <div>
    <v-row justify="center">
        <v-dialog
        v-model="dialog"
        persistent
        max-width="600px"
        >
        <template v-slot:activator="{ on, attrs }">
            <v-btn
            color="primary"
            dark
            v-bind="attrs"
            v-on="on"
            >
            Open Dialog
            </v-btn>
        </template>
        <v-card>
            <v-card-title>
            <span class="headline">User Profile</span>
            </v-card-title>
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
            <small>*indicates required field</small>
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
            <v-btn
                color="blue darken-1"
                text
                @click="dialog = false"
            >
                Save
            </v-btn>
            </v-card-actions>
        </v-card>
        </v-dialog>
    </v-row>
  </div>
</template>
<script>
// import VueJsonToCsv from 'vue-json-to-csv'
export default {
  data: () => ({
    dialog: false,
    headers: [
        {
          text: 'Date',
          align: 'start',
          value: 'name',
        },
        // { text: 'Calories', value: 'calories' },
        // { text: 'Fat (g)', value: 'fat' },
        // { text: 'Carbs (g)', value: 'carbs' },
        // { text: 'Protein (g)', value: 'protein' },
        // { text: 'Iron (%)', value: 'iron' },
      ],
      summary: [
        {
          name: 'Frozen Yogurt',
        //   calories: 159,
        //   fat: 6.0,
        //   carbs: 24,
        //   protein: 4.0,
        //   iron: '1%',
        }
      ],
 }),
 methods: {
     show(param1, param2){
         let param = {
             start_date: param1,
             end_date: param2
         }
         console.log(param)
         this.$axios.post('http://localhost:8000/hr/summary/shift_change_request', param).then( response =>{
             console.log(response.data, 'ghjkdfrgthyu')
             this.summary = response.data
         })
         this.dialog = true
     }
 }
//   name: 'TemplateSummaryExporter',
//   components: {
//     'vue-json-to-csv': VueJsonToCsv
//   },
// <vue-json-to-csv :json-data="[
//                     { name: 'Joe', surname: 'Roe' },
//                     { name: 'John', surname: 'Doe' }
//                 ]"
//                 :labels="{ name: { title: 'First name' }, surname: { title: 'Last name'} }"
//                 >
//                 <button>
//                     <b>My custom button</b>
//                 </button>
//                 </vue-json-to-csv>
    
}
</script>

