<template>
    <div class="row">
        <div class="col-lg-2">
            <h3>Tickets</h3>
            <ticket v-if="tickets" v-for="ticket in tickets" :ticket="ticket" :key="ticket.id" :event="ticket.event">
            </ticket>
        </div>

        <div class="col-lg-10">
            <div class="text-center">
                <loading :isLoading="loading"></loading>
                <day v-model="getDate"></day>

            </div>
            <div class="clearfix"></div>
            <div class="zfc-calendars" ref="zfcCalendars">
                <table class="table-bordered table-striped table-responsive  zfc-td">
                    <thead>
                    <tr>
                        <th class="zfc-column-hours"></th>
                        <th class="zfc-column-calendar" v-if="hasCalendars" v-for="calendar in calendars"
                            :key="calendar.id">
                            {{calendar.name}}
                        </th>

                    </tr>
                    </thead>

                    <tbody>
                    <tr v-if="hasCalendars" v-for="hour in getHours" v-bind:key="hour">

                        <td class="zfc-column-hours">{{hour}}</td>

                        <calendarTd v-if="hasCalendars" v-on:rc="onRc"
                                    v-for="calendar in calendars"
                                    :tid='calendar.id + "-" + hour'
                                    :calendarId="calendar.id" :name="calendar.name" :hour="hour"
                                    :parentTop="top" :parentLeft="left"
                                    :key='calendar.id + "-" + hour'
                                    v-on:dropForNewEvent="onDropForNewEvent"
                                    v-on:dropForChangeEvent="onDropForChangeEvent">
                        </calendarTd>

                    </tr>
                    </tbody>

                </table>

                <event v-if="events" v-for="(event,index) in events" :key="index" :index="index"
                       :id="event.id" :title="event.title" :description="event.description" :duration="event.duration"
                       :date="event.getDate" :calendar="event.calendar" :hour="event.hour" :ticketId="event.ticketId"
                       :top="event.top" :left="event.left"
                :start="event.start" :end="event.end">

                </event>

            </div>
        </div>

        <modal :modalId="'event'" :title="'Evento'" :modalSize="'modal-lg'">
            <form-event v-model="nowEvent" :index="nowEventId" v-on:remove="removeEvent"/>
        </modal>

    </div>
</template>

<script>
    import axios from 'axios'
    import {Drag, Drop} from 'vue-drag-drop';

    import moment from 'moment'
    import momenttz from 'moment-timezone'
    import 'moment/locale/es';

    import modal from './helpers/modal.vue'
    import loading from './helpers/loading.vue'

    import day from './day.vue'
    import calendarTd from './calendarTd.vue'
    import event from './event.vue'
    import ticket from "./ticket.vue";

    import formEvent from './forms/form-event.vue'

    const http = axios.create({
        baseURL: '/zfmc/api/',
        timeout: 5000,
        headers: {
            accept: 'application/json'
        }
    });


    export default {
        name: 'calendars',
        components: {day, calendarTd, event, ticket, Drag, Drop, modal, loading, formEvent},
        data() {
            return {
                calendars: [],
                tickets: [],
                date: moment().locale('es'),
                events: [],
                tds: {},
                top: 0,
                left: 0,
                nowEvent: {},
                nowEventId: '',
                loading: false
            }
        },
        created: function () {
            this.calendarList();
            this.ticketList();

        },
        mounted() {
            this.$nextTick(function () {
                window.addEventListener('resize', this.onResize);
            });
            this.getTop();
            this.getLeft();
            this.loadEvents();
        },
        methods: {
            calendarList: function () {
                http.get('calendars').then((response) => {
                    this.calendars = response.data;
                })
            },
            ticketList: function () {
                http.get('tickets').then((response) => {
                    this.tickets = response.data;
                })
            },
            onRc: function(tid,top,left){
              this.tds[tid] = {top: top,left:left};

            },
            onResize: function () {
                this.getTop();
                this.getLeft();
            },
            getTop: function () {
                this.top = this.$refs.zfcCalendars.getBoundingClientRect().top;
            },
            getLeft: function () {
                this.left = this.$refs.zfcCalendars.getBoundingClientRect().left;
            },
            removeEvent: function () {

            },
            calculateEventDuraction: function(event){
                if(event.start && event.end){
                    return moment(event.end).diff(moment(event.start),'minutes');
                }
              return null;
            },
            getEventTid: function(event){
                if(event.calendar && event.hour){
                return event.calendar+'-'+event.hour;
                }
                return null;
            },
            loadEvents: function (event) {
                axios.get("/zfmc/api/events?start=>="+this.getDate
                ).then((response) => {
                    for(var i=0; i < response.data.length;i++){
                        var event = response.data[i]
                        //Hour
                        event.hour = moment(response.data[i].start).tz('America/Argentina/Buenos_Aires').format("H");
                        //Duration
                        event.duration = this.calculateEventDuraction(response.data[i]);
                        //TOP-LEFT
                        event.top = this.tds[this.getEventTid(event)].top
                        event.left = this.tds[this.getEventTid(event)].left
                        this.events.push(event);
                    }

                    this.loading = false;
                }).catch((error) => {
                    this.nowEvent.errors = error.response.data.errors
                    this.loading = false;
                })
            },
            createEvent: function (event) {
                this.loading = true;
                axios.post("/zfmc/api/events", event
                ).then((response) => {
                    event.id = response.data.id
                    this.getTicketById(event.ticketId).event = response.data.id;
                    this.events.push(event);
                    this.loading = false;
                }).catch((error) => {
                    this.nowEvent.errors = error.response.data.errors
                    this.loading = false;
                })
            },
            updateEvent: function (event) {
                this.loading = true;
                axios.put("/zfmc/api/events/"+event.id, event
                ).then((response) => {
                    this.loading = false;
                }).catch((error) => {
                    this.nowEvent.errors = error.response.data.errors
                    this.loading = false;
                })
            },
            onDropForNewEvent: function (calendar, ticketId, hour, top, left) {
                var event = {};
                event.id = '';
                event.calendar = calendar;
                event.ticketId = ticketId;
                event.hour = hour;
                event.top = top + this.getScrollX() + this.getBodyScrollTop();
                event.left = left + this.getScrollY() + this.getBodyScrollLeft();
                event.duration = 60;
                event.date = this.date;
                event.start = this.getDate + " " + hour;
                var end = moment(this.getDate + " " + hour);
                event.end = end.add(event.duration, "minutes").tz('America/Argentina/Buenos_Aires').format("YYYY-MM-DD HH:mm");

                this.createEvent(event);

            },
            onDropForChangeEvent: function (calendar, eventKey, hour, top, left) {
                this.events[eventKey].top = top + this.getScrollX() + this.getBodyScrollTop();
                this.events[eventKey].left = left + this.getScrollY() + this.getBodyScrollLeft();
                this.events[eventKey].hour = hour;
                this.events[eventKey].calendar = calendar;
                this.events[eventKey].start = this.getDate + " " + hour;
                var end = moment(this.getDate + " " + hour);
                this.events[eventKey].end = end.add(this.events[eventKey].duration, "minutes").tz('America/Argentina/Buenos_Aires').format("YYYY-MM-DD HH:mm");

                this.updateEvent(this.events[eventKey]);
            },
            getTicketById: function (id) {
                for (var i = 0; i < this.tickets.length; i++) {
                    if (this.tickets[i].id == id) {
                        return this.tickets[i];
                    }
                }
                return null;
            },
            getScrollX: function () {
                return this.$refs.zfcCalendars.scrollTop;
            },
            getScrollY: function () {
                return this.$refs.zfcCalendars.scrollLeft;
            },
            getBodyScrollTop() {
                return window.pageYOffset || document.documentElement.scrollTop;
            },
            getBodyScrollLeft() {
                return window.pageXOffset || document.documentElement.scrollLeft;
            },
        },
        computed: {

            getDate: function () {
                return this.date.tz('America/Argentina/Buenos_Aires').format("YYYY-MM-DD");
            },
            getDay: function () {
                return this.date.day() + 1;
            },
            hasCalendars: function () {
                if (this.calendars != undefined && this.calendars.length > 0) {
                    return true;
                }
                return false;
            },
            getStart: function () {
                var rstart = null;
                if (this.hasCalendars) {
                    for (var index = 0; index < this.calendars.length; ++index) {
                        if (this.calendars[index].schedules != undefined) {
                            for (var i = 0; i < this.calendars[index].schedules.length; ++i) {
                                if (this.calendars[index].schedules[i].day == this.getDay) {
                                    if (this.calendars[index].schedules[i].start < rstart || rstart == null) {
                                        rstart = this.calendars[index].schedules[i].start;
                                    }

                                }
                            }
                        }
                    }
                }
                return rstart;
            },
            getEnd: function () {
                var rend = null;
                if (this.hasCalendars) {
                    for (var index = 0; index < this.calendars.length; ++index) {
                        if (this.calendars[index].schedules != undefined) {
                            for (var i = 0; i < this.calendars[index].schedules.length; ++i) {
                                if (this.calendars[index].schedules[i].day == this.getDay) {
                                    if (this.calendars[index].schedules[i].end > rend || rend == null) {
                                        rend = this.calendars[index].schedules[i].end;
                                    }
                                    4
                                }
                            }
                        }
                    }
                }
                return rend;
            },
            getHours: function () {
                var hours = [];
                if (this.hasCalendars) {
                    var flag = true;
                    var t = moment(this.getStart, "hh:mm");
                    var e = moment(this.getEnd, "hh:mm");
                    while (flag) {
                        hours.push(t.format("hh:mm"));
                        t.add(30, "minutes");
                        if (t >= e) {
                            flag = false;
                        }
                    }
                }
                return hours;
            }

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
