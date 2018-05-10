<template>
    <div>
        <div class="text-center">
            <day v-model="getDate"></day>
        </div>
        <div class="clearfix"></div>
        <div>
            <table class="table">
                <tr>
                    <td>Hora</td>
                </tr>

                <tr v-for="hour in getHours" v-bind:key="hour">

                    <td>{{hour}}</td>

                </tr>

            </table>
        </div>

        <calendar v-for="calendar in calendars" :calendar="calendar" :key="calendar.id">
        </calendar>
    </div>
</template>

<script>
  import axios from 'axios'
  import day from './day.vue'
  import calendar from './calendar.vue'
  import moment from 'moment'
  import 'moment/locale/es';

  const http = axios.create({
    baseURL: '/calendar/api/',
    timeout: 5000,
    headers: {
      accept: 'application/json'
    }
  });

  export default {
    name: 'calendars',
    components: {day, calendar},
    data() {
      return {
        calendars: [],
        date: moment().locale('es')
      }
    },
    created: function () {
      this.apiList();
    },
    methods: {
      apiList: function () {
        http.get('list').then((response) => {
          if (response.data.success) {
            this.calendars = response.data.data;

          }
        })
      },
      getCalendarScheduleByDay: function (calendar, day) {
        for (index = 0; index < this.calendars.length; ++index) {
          console.log(a[index]);
        }
      },
      dateToYMD(date) {
        var d = date.getDate();
        var m = date.getMonth() + 1; //Month from 0 to 11
        var y = date.getFullYear();
        return '' + y + '-' + (m <= 9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d);
      }
    },
    computed: {
      getDate: function () {
        return this.date.format("YYYY-MM-DD");
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
            if (this.calendars[index].schedules.collection != undefined) {
              for (var i = 0; i < this.calendars[index].schedules.collection.length; ++i) {
                if (this.calendars[index].schedules.collection[i].day == this.getDay) {
                  if (this.calendars[index].schedules.collection[i].start < rstart || rstart == null) {
                    rstart = this.calendars[index].schedules.collection[i].start;
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
            if (this.calendars[index].schedules.collection != undefined) {
              for (var i = 0; i < this.calendars[index].schedules.collection.length; ++i) {
                if (this.calendars[index].schedules.collection[i].day == this.getDay) {
                  if (this.calendars[index].schedules.collection[i].end > rend || rend == null) {
                    rend = this.calendars[index].schedules.collection[i].end;
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
</style>
