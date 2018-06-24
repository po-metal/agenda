<template>
    <div class="row">
        <navi></navi>

        <div class="clearfix"></div>
        <div class="col-lg-2">
         <panel></panel>
        </div>

        <div class="col-lg-10">
            <loading :isLoading="getLoading"></loading>
            <div class="clearfix"></div>
            <div class="zfc-calendars" ref="zfcCalendars" v-on:scroll="handleCalendarScroll">
                <table class="table-bordered table-striped table-responsive  zfc-td">
                    <thead>
                    <tr>
                        <th v-if="hasCalendars" class="zfc-column-hours"></th>
                        <th class="zfc-column-calendar"
                            v-if="hasCalendars"
                            v-for="calendar in getCalendars"
                            :key="calendar.id">
                            {{calendar.name}}
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr v-if="hasCalendars" v-for="hour in getHours" v-bind:key="hour">
                        <td class="zfc-column-hours">{{hour}}</td>
                        <calendarTd v-if="hasCalendars"
                                    v-for="calendar in getCalendars"
                                    :key='calendar.id + hour'
                                    :calendarId="calendar.id" :name="calendar.name" :hour="hour"
                                    :parentTop="top" :parentLeft="left"
                                    v-on:dropForNewEvent="onDropForNewEvent"
                                    v-on:dropForChangeEvent="onDropForChangeEvent">
                        </calendarTd>
                    </tr>

                    <tr>
                        <th  v-if="hasCalendars" class="zfc-column-hours">FB</th>
                        <calendarTd v-if="hasCalendars"
                                    v-for="calendar in getCalendars"
                                    :key='calendar.id+"_fb"'
                                    :calendarId="calendar.id" :name="calendar.name" :hour="'fb'"
                                    :parentTop="top" :parentLeft="left">
                        </calendarTd>
                    </tr>
                    </tbody>
                </table>

                <event v-if="getEvents" v-for="(event,index) in getEvents" :key="index" :index="index"
                       :id="event.id" :title="event.title" :description="event.description"
                       :duration="event.duration"
                       :date="event.getDate" :calendar="event.calendar" :hour="event.hour"
                       :ticketId="event.ticket"
                       :top="event.top" :left="event.left"
                       :start="event.start" :end="event.end" :state="event.state" :type="event.type"
                       v-on:editEvent="onEditEvent">
                </event>
            </div>
        </div>
        <modal :title="eventForm.title" :showModal="showModal" @close="showModal = false">
            <form-event :calendars="getCalendars" v-model="eventForm"
                        :index="eventIndex" v-on:remove="removeEvent" />
        </modal>
    </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex';
  import {calculateEnd} from './../utils/helpers'
  import {Drag, Drop} from 'vue-drag-drop';


  import modal from './helpers/modal.vue'
  import loading from './helpers/loading.vue'

  import navi from './navi.vue'
  import panel from './panel.vue'
  import calendarTd from './calendarTd.vue'
  import event from './event.vue'
  import preEvent from "./preEvent.vue";

  import formEvent from './forms/form-event.vue'

  export default {
    name: 'calendars',
    components: {calendarTd, event, preEvent, Drag, Drop, modal, loading, formEvent,navi,panel},
    data() {
      return {
        tds: {},
        eventForm: {},
        eventIndex: '',
        showModal: false,
        titleModal: ''
      }
    },
    created: function () {
      this.eventStateList();
      this.eventTypeList();
      this.calendarList();
      this.preEventList();
    },
    mounted() {
      this.$nextTick(function () {
        window.addEventListener('scroll', this.handleWindowScroll);
        window.addEventListener('resize', this.handleCalendarPosition);
      });
      this.handleCalendarPosition();
    },
    computed: {
      ...mapGetters([
        'getLoading',
        'getCalendars',
        'getPreEvents',
        'getEvents',
        'getEventByKey',
        'getDate',
        'getNextDate',
        'getDay',
        'hasCalendars',
        'getHours'
      ]),
    },
    methods: {
      ...mapActions([
        'eventStateList',
        'eventTypeList',
        'calendarList',
        'preEventList',
        'removePreEvent',
        'updateEvent',
        'pushEvent'
      ]),
      removeEvent: function(){

      },
      onEditEvent: function (index) {
        this.eventForm = this.getEventByKey(index)
        this.eventIndex = index
        this.titleModal = 'Evento: ' + this.eventForm.title
        this.showModal = true
      },
      onDropForNewEvent: function (preEvent, index, top, left) {
        var event = preEvent;
        event.date = this.date
        event.start = this.getDate + " " + event.hour
        event.end = calculateEnd(event.start, event.duration)
        this.pushEvent(event);
        this.removePreEvent({index:index});
      },
      onDropForChangeEvent: function (calendar, eventKey, hour) {
        var event = this.getEventByKey(eventKey);
        event.hour = hour
        event.calendar = calendar
        event.start = this.getDate + " " + hour
        event.end = calculateEnd(event.start, event.duration)
        this.updateEvent({index:eventKey,event:event});
      },
      handleCalendarPosition: function () {
        this.top = this.$refs.zfcCalendars.getBoundingClientRect().top;
        this.left = this.$refs.zfcCalendars.getBoundingClientRect().left;
        this.$store.commit('SET_CALENDAR_POSITION',{top:this.top,left:this.left});
      },
      handleCalendarScroll: function(e){
        this.$store.commit('SET_CALENDAR_SCROLL',{top:e.srcElement.scrollTop,left:e.srcElement.scrollLeft});
      },
      handleWindowScroll: function(e){
        this.$store.commit('SET_BODY_SCROLL',{top:e.srcElement.scrollTop || window.pageYOffset,left: e.srcElement.scrollLeft || window.pageXOffset });
      },
    }

  }
</script>

<style scoped>

    .zfc-calendars {
        position: relative;
        overflow-y: auto;
        overflow-x: auto;
    }

    .zfc-column-hours {
        width: 50px;
    }

    .zfc-column-calendar {
        width: 180px;
        min-width: 180px;
        max-width: 180px;
        overflow: hidden;
        text-align: center;
    }

    table.zfc-td > tbody > tr > td, table.zfc-td > tbody > tr > th {
        font-size: 14px;
        height: 25px;
        padding: 0;
        margin: 0;
        text-align: center;
    }

    table.zfc-td > tbody > tr > td > div {
        height: 100%;
        background: #0d6aad;
    }
</style>
