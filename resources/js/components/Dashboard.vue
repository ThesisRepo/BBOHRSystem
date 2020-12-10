<template>
  <v-app>
    <v-row>
      <v-col lg="4" cols="sm" class="pb-2" v-if="!user_type.includes('general mngr')">
        <v-card>
          <v-row class="no-gutters">
            <div class="col-auto">
              <div class="primary fill-height">&nbsp;</div>
            </div>
            <div class="col pa-3 py-4 primary--text">
              <h5 class="text-truncate text-uppercase">Remaining Leave Request</h5>
              <h1>{{ leave_number == 'null' ?  0 : leave_number }}</h1>
            </div>
          </v-row>
        </v-card>
      </v-col>
      <v-col lg="4" cols="sm" class="pb-2" v-if="!user_type.includes('general mngr')">
        <v-card>
          <v-row class="no-gutters">
            <div class="col-auto">
              <div class="red fill-height">&nbsp;</div>
            </div>
            <div class="col pa-3 py-4 red--text">
              <h5 class="text-truncate text-uppercase">Pending Request</h5>
              <h1>{{ pending ? pending : 0 }}</h1>
            </div>
          </v-row>
        </v-card>
      </v-col>

      <v-col lg="4" cols="sm" class="pb-2" v-if="!user_type.includes('general mngr')">
        <v-card>
          <v-row class="no-gutters">
            <div class="col-auto">
              <div class="green fill-height">&nbsp;</div>
            </div>
            <div class="col pa-3 py-4 green--text">
              <h5 class="text-truncate text-uppercase">Approved Request</h5>
              <h1>{{ approve ? approve : 0 }}</h1>
            </div>
          </v-row>
        </v-card>
      </v-col>
    </v-row>
    <br>
    <br>
    <DashBoardtable></DashBoardtable>
    <v-spacer></v-spacer>
    <br>
    <br>
    <!-- <AddEvent></AddEvent>
    <CalendarAdd></CalendarAdd> -->
    <div class="text-right">
      <v-btn color="light blue darken-2" rounded outlined @click="eventType()">
        <v-icon>mdi-plus</v-icon>Event Type
      </v-btn>
      <v-btn color="light blue darken-2" rounded outlined @click="eventAdd()">
        <v-icon>mdi-plus</v-icon>Add Event
      </v-btn>
    </div>

    <AddEvent
    ref="addType"
    ></AddEvent>
    <CalendarAdd
    ref="addEvent"
    ></CalendarAdd>

    <v-row class="fill-height">
      <v-col>
        <v-sheet height="64">
          <v-toolbar flat>
            <v-btn outlined class="mr-4" color="grey darken-2" @click="setToday">Today</v-btn>
            <v-btn fab text small color="grey darken-2" @click="prev">
              <v-icon small>mdi-chevron-left</v-icon>
            </v-btn>
            <v-btn fab text small color="grey darken-2" @click="next">
              <v-icon small>mdi-chevron-right</v-icon>
            </v-btn>
            <v-toolbar-title v-if="$refs.calendar">{{ $refs.calendar.title }}</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-menu bottom right>
              <template v-slot:activator="{ on, attrs }">
                <v-btn outlined color="grey darken-2" v-bind="attrs" v-on="on">
                  <span>{{ typeToLabel[type] }}</span>
                  <v-icon right>mdi-menu-down</v-icon>
                </v-btn>
              </template>
              <v-list>
                <v-list-item @click="type = 'day'">
                  <v-list-item-title>Day</v-list-item-title>
                </v-list-item>
                <v-list-item @click="type = 'week'">
                  <v-list-item-title>Week</v-list-item-title>
                </v-list-item>
                <v-list-item @click="type = 'month'">
                  <v-list-item-title>Month</v-list-item-title>
                </v-list-item>
                <v-list-item @click="type = '4day'">
                  <v-list-item-title>4 days</v-list-item-title>
                </v-list-item>
              </v-list>
            </v-menu>
          </v-toolbar>
        </v-sheet>
        <v-sheet height="600">
          <v-calendar
            ref="calendar"
            id="calendar"
            v-model="focus"
            color="primary"
            :events="events"
            :type="type"
            :now="today"
            eventOverlap: false
            :event-color="getEventColor"
            :event-text-color="getProperColor"
            @click:event="showEvent"
            @click:more="viewDay"
            @click:date="viewDay"
            @change="updateRange"
          >
          </v-calendar>
          <v-menu
            v-model="selectedOpen"
            :close-on-content-click="false"
            :activator="selectedElement"
            offset-x
          >
            <v-card color="grey lighten-4" width="350px" flat>
              <v-toolbar :color="selectedEvent.color"
                :style="[lightColoredTextData.includes(selectedEvent.color) ? {'color':'black!important'} : {}]"
               dark>
                <v-btn
                 icon>
                  <v-icon 
                  v-if="selectedEvent.user_id == user_id"
                  :style="[lightColoredTextData.includes(selectedEvent.color) ? {'color':'black!important'} : {}]"                                  
                  @click="editItem(selectedEvent)">mdi-pencil</v-icon>
                </v-btn>
                <v-toolbar-title 
                v-html="selectedEvent.name + ' ' + '(' + selectedEvent.event_type + ')'"></v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn icon>
                  <v-icon 
                  v-if="selectedEvent.user_id == user_id"
                  :style="[lightColoredTextData.includes(selectedEvent.color) ? {'color':'black!important'} : {}]"
                  @click="deleteItem(selectedEvent)">mdi-delete</v-icon>
                </v-btn>

                <ConfirmationDel
                  ref="confirmDel"
                  @onConfirm="confirmDel($event)"
                ></ConfirmationDel>

                <!-- <v-btn icon>
                  <v-icon>mdi-dots-vertical</v-icon>
                </v-btn> -->
              </v-toolbar>
              <v-card-text >
                <span v-html="selectedEvent.details"></span>
                <p v-if="selectedEvent.event_type !=  'Holiday' && selectedEvent.event_type !=  'Birthday' ">{{selectedEvent.start}} - {{selectedEvent.end}}</p>
                <p><b>Details:</b> {{selectedEvent.content}}</p>
              </v-card-text>
              <v-card-actions>
                <v-btn color="red" dark @click="selectedOpen = false">Close</v-btn>
              </v-card-actions>
            </v-card>
          </v-menu>
        </v-sheet>
      </v-col>
    </v-row>
    <v-dialog scrollable v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-toolbar class="mb-2" color="blue darken-1" dark flat>
          <v-card-title>
            <span class="headline-bold">EDIT EVENT</span>
          </v-card-title>
        </v-toolbar>
        <v-card-text>
          <v-container>
            <span v-if="errorMessage1" style="color: red; font-size: 13px">{{ errorMessage1 }}</span>
            <span v-if="errorMessage2" style="color: red; font-size: 13px">{{ errorMessage2 }}</span>
            <span v-if="errorMessage3" style="color: red; font-size: 13px">{{ errorMessage3 }}</span>
            <v-row>
              <v-col cols="12" sm="6">
                <v-text-field label="Title*" @keyup="validate('title')" autocomplete="off" v-model="editedItem.title" required></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-select label="Event Type*" :items="event_types" @keyup="validate('event')" item-text="event_name" item-value="id" v-model="editedItem.event_type" required></v-select>
              </v-col>
              <v-col cols="12">
                <!-- <v-text-field label="Content*" v-model="content" required></v-text-field> -->
                <v-textarea
                  outlined
                  label="Content*"
                   @keyup="validate('details')"
                  v-model="editedItem.content"
                  rows="3"
                  required
                ></v-textarea>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field label="Start Date & Time" type="datetime-local" v-model="editedItem.start_date" color="primary"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field label="End Date & Time" type="datetime-local" v-model="editedItem.end_date" color="primary"></v-text-field>
              </v-col>
              <v-col cols="12" v-if="user_type.includes('hr mngr')">
                <v-checkbox
                  v-model="editedItem.checkbox"
                  label="Public"
                ></v-checkbox>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red" dark @click="dialog = false">Cancel</v-btn>
          <v-btn color="success" @click="confirm()">Update</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <Confirmation
      ref="confirm"
      :title="'Confirmation'"
      :message="'Are you sure you want to update ?'"
      @onConfirm="updateCalendar($event)"
    ></Confirmation>
    <Loading v-if="loading"></Loading>
  </v-app>
</template>
<script>
import Confirmation from "./modals/confirmation/confirmation.vue";
import DashBoardtable from "./Dashboard_table";
import CalendarAdd from "./modals/addCalendar.vue";
import AddEvent from "./modals/add_event_title.vue";
import ConfirmationDel from "./modals/confirmation/delete.vue";
import Loading from "./Loading.vue";
import moment from "moment";
export default {
  components: {
    DashBoardtable,
    CalendarAdd,
    ConfirmationDel,
    Confirmation,
    AddEvent,
    Loading
  },
  data: () => ({
    today: new Date().toISOString().substr(0,10),
    user_type: localStorage.getItem("user_type"),
    leave_number: localStorage.getItem("leave_number"),
    user_id: localStorage.getItem("id"),
    pending: null,
    approve: null,
    update: false,
    dialog: false,
    event_types: [],
    focus:  new Date().toISOString().substr(0,10),
    type: "month",
    typeToLabel: {
      month: "Month",
      week: "Week",
      day: "Day",
      "4day": "4 Days"
    },
    selectedEvent: {},
    selectedElement: null,
    selectedOpen: false,
    events: [],
    title: [],
    editedItem: {
      content: null,
      title: null,
      start_date: null,
      end_date: null,
      checkbox: false,
      event_type: null,
    },
    loading: false,
    errorMessage1: null,
    errorMessage2: null,
    errorMessage3: null,
    lightColoredTextData: [
      '#FFFF00'
    ],
    year: null
  }),
  mounted() {
    this.$refs.calendar.checkChange();
    this.getNoApprove();
    this.getNoPending();
    this.getEventType();
    this.retrieve();

  },
  methods: {
    confirm(){
      if(this.editedItem.title !== null && this.editedItem.title !== "" && this.editedItem.event_type !== null && this.editedItem.event_type !== "" && this.editedItem.content !== null && this.editedItem.content !== "" && this.editedItem.start_date !== null && this.editedItem.start_date !== "" && this.editedItem.end_date !== null && this.editedItem.end_date !== ""){
        this.$refs.confirm.show()
      }else {
        this.error = true
        this.dialog = true
      }
    },
    validate(item){
      if(item === 'title'){
        if(this.editedItem.title === '' || this.editedItem.title === null){
          this.errorMessage1 = 'Title field is required'
        }else{
          this.errorMessage1 = null
        }
      }else if(item === 'event'){
        if(this.editedItem.event_type === '' || this.editedItem.event_type === null){
          this.errorMessage2 = 'Event type field is required'
        }else{
          this.errorMessage2 = null
        }
      }else if(item === 'details'){
        if(this.editedItem.content === '' || this.editedItem.content === null){
          this.errorMessage3 = 'Details field is required'
        }else{
          this.errorMessage3 = null
        }
      }
    },
    eventAdd(){
      this.$refs.addEvent.show()
    },
    eventType(){
      this.$refs.addType.show()
    },
    getNoApprove() {
      this.$axios
        .get("user_info/approved_requests/count/" + this.user_id)
        .then(response => {
          this.approve = response.data;
        });
    },
    getNoPending() {
      this.loading = true
      this.$axios
        .get("user_info/pending_requests/count/" + this.user_id)
        .then(response => {
          this.loading = false
          this.pending = response.data;
        });
    },
    // End
    viewDay({ date }) {
      this.focus = date;
      this.type = "day";
    },
    getEventColor(event) {
      return event.color;
    },
    getProperColor(event) {
      var bright = this.isBright(event.color);
      return bright ? 'black': 'white';
    },
    isBright(color) {
      var element, bgColor, brightness, r, g, b, hsp;
      if (color.match(/^rgb/)) {
        color = color.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+(?:\.\d+)?))?\)$/);

        r = color[1];
        g = color[2];
        b = color[3];
      } 
      else {
        color = +("0x" + color.slice(1).replace(color.length < 5 && /./g, '$&$&'));
        r = color >> 16;
        g = color >> 8 & 255;
        b = color & 255;
      }
      hsp = Math.sqrt(
        0.299 * (r * r) +
        0.587 * (g * g) +
        0.114 * (b * b)
      );

      // Using the HSP value, determine whether the color is light or dark
      if (hsp>127.5) {

        return true;
      } 
      else {

        return false;
      }
    },
    setToday() {
      this.focus = "";
    },
    prev() {
      this.$refs.calendar.prev();
    },
    next() { 
      this.$refs.calendar.next();
    },
    showEvent({ nativeEvent, event }) {
      const open = () => {
        this.selectedEvent = event;
        this.selectedElement = nativeEvent.target;
        setTimeout(() => {
          this.selectedOpen = true;
        }, 10);
      };
      if (this.selectedOpen) {
        this.selectedOpen = false;
        setTimeout(open, 10);
      } else {
        open();
      }
      nativeEvent.stopPropagation();  
    },
    updateRange(e) {
      var yearCurrent =  e.start.year;
      if(this.year != yearCurrent || this.year == null){
        this.year = yearCurrent;
        this.events = this.events.map(function(val) {
          if(val.is_yearly == 1) {
            var end_date = new Date(val.start);
            var start_date = new Date(val.end);
            val.start = new Date( end_date.getTime() + Math.abs(end_date.getTimezoneOffset()*60000) ) .toISOString().substr(0,10).split('-');
            val.end = new Date( start_date.getTime() + Math.abs(start_date.getTimezoneOffset()*60000) ) .toISOString().substr(0,10).split('-');
            val.start[0] = yearCurrent;
            val.end[0] = yearCurrent;
            val.start = val.start.join('-');
            val.end = val.end.join('-');
          }
          return val;
        });
      }
      const events = [];
      for (let i = 0; i < this.events.length; i++) {
          events.push({
          user_id: this.events[i].user_id,
          name: this.events[i].name,
          content: this.events[i].content,
          start: this.events[i].start,
          end: this.events[i].end,
          color: this.events[i].color,
          event_type: this.events[i].event_type,
          checkbox: this.events[i].checkbox,
          timed: this.events[i].timed,
          is_yearly:this.events[i].is_yearly
        });
      }
      this.events = events;
    },
    rnd(a, b) {
      return Math.floor((b - a + 1) * Math.random()) + a;
    },
    getEventType() {
      this.$axios
        .get("user_info/event_types/" + this.user_id)
        .then(response => {
          response.data.event_types.forEach(element => {
            this.event_types.push(element)  
          });
        });
    },
    retrieve() {
      this.loading = true
      let parameter = {
        user_id: this.user_id
      };
      this.$axios.get("events/"+  this.user_id).then(response => {
        this.loading = false
        this.events = []
        console.log(response.data);
        response.data.forEach(element => {
          var temp = {
            user_id: element.user_id,
            id: element.id,
            name: element.title,
            content: element.content,
            start: element.start_date,
            end: element.end_date,
            color: element.event_type.color,
            event_type: element.event_type.event_name,
            checkbox: element.is_public,
            is_yearly: element.is_yearly,
            timed: true
          };
          this.events.push(temp)
        }, 1);
      });
    },
    deleteItem(selectedEvent) {
      this.id = selectedEvent.id;
      this.$refs.confirmDel.show(selectedEvent)
    },
    confirmDel() {
      this.loading = true
      this.$axios
        .delete("events/" + this.id)
        .then(response => {
          this.loading = false
          this.retrieve();
          this.selectedOpen = false
        });
    },    
    editItem(selectedEvent) {
      this.errorMessage1 = null
      this.errorMessage2 = null
      this.errorMessage3 = null                                        
      this.editedItem.id = selectedEvent.id;
      this.editedIndex = this.events.indexOf(selectedEvent);
      this.editedItem.content = selectedEvent.content;
      this.editedItem.checkbox = selectedEvent.checkbox;
      this.editedItem.start_date = moment(selectedEvent.start).format('YYYY-MM-DDTHH:mm');
      this.editedItem.end_date = moment(selectedEvent.end).format('YYYY-MM-DDTHH:mm');
      this.editedItem.title = selectedEvent.name;
      this.dialog = true;
      this.event_types.forEach(el => {
        if(el.event_name === selectedEvent.event_type){
          this.editedItem.event_type = el
        }
      })
    },
    updateCalendar(){
      this.validate('title')
      this.validate('event')
      this.validate('details')
      if(this.errorMessage1 === null && this.errorMessage2 === null && this.errorMessage3 === null){
        this.loading = true
        let params = {
            id: this.editedItem.id,
            user_id: this.user_id,
            content: this.editedItem.content,
            is_public: this.editedItem.checkbox,
            start_date: this.editedItem.start_date,
            end_date: this.editedItem.end_date,
            event_type_id: this.editedItem.event_type.id ? this.editedItem.event_type.id : this.editedItem.event_type,
            title: this.editedItem.title
          };
          this.$axios
            .post(
              "events/" + this.editedItem.id,
              params
            )
            .then(response => {
              this.loading = false
              this.retrieve();
              this.dialog = false;
            });
        }
      }
  }
};
</script>