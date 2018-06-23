import moment from 'moment'
import tz from 'moment-timezone'
import 'moment/locale/es';

export const getters = {
  getCoordinates: state => {
    return state.coordinates;
  },
  getCoordinate: (state) => (calendar,hour,type) => {
    if(state.coordinates[calendar][hour] == undefined){
      return state.coordinates[calendar]['fb'][type];
    }
    return state.coordinates[calendar][hour][type];
  },
  getLoading: state => {
    return state.loading;
  },
  getCalendars: state => {
    return state.calendars;
  },
  getPreEvents: state => {
    return state.preEvents;
  },
  getEvents: state => {
    return state.events;
  },
  getEventByKey: (state) => (key) => {
    return state.events[key];
  },
  getDate: state => {
    return state.date.format("YYYY-MM-DD");
  },
  getNextDate: (state, getters) => {
    var nextDate = tz(getters.getDate);
    return nextDate.add(1, 'day').format("YYYY-MM-DD");
  },
  getDay: state => {
    return state.date.day() + 1;
  },
  hasCalendars: (state) => {
    if (state.calendars != undefined && state.calendars.length > 0) {
      return true;
    }
    return false;
  },
  getStart: (state, getters) => {
    var rstart = null;
    if (getters.hasCalendars) {
      for (var index = 0; index < state.calendars.length; ++index) {
        if (state.calendars[index].schedules != undefined) {
          for (var i = 0; i < state.calendars[index].schedules.length; ++i) {
            if (state.calendars[index].schedules[i].day == getters.getDay) {
              if (state.calendars[index].schedules[i].start < rstart || rstart == null) {
                rstart = state.calendars[index].schedules[i].start;
              }
            }
          }
        }
      }
    }
    return rstart;
  },
  getEnd: (state, getters) => {
    var rend = null;
    if (getters.hasCalendars) {
      for (var index = 0; index < state.calendars.length; ++index) {
        if (state.calendars[index].schedules != undefined) {
          for (var i = 0; i < state.calendars[index].schedules.length; ++i) {
            if (state.calendars[index].schedules[i].day == getters.getDay) {
              if (state.calendars[index].schedules[i].end > rend || rend == null) {
                rend = state.calendars[index].schedules[i].end;
              }
            }
          }
        }
      }
    }
    return rend;
  },
  getHours: (state, getters) => {
    var hours = [];
    if (getters.hasCalendars) {
      var flag = true;
      var t = moment(getters.getStart, "HH:mm");
      var e = moment(getters.getEnd, "HH:mm");
      while (flag) {
        hours.push(t.format("HH:mm"));
        t.add(30, "minutes");
        if (t >= e) {
          flag = false;
        }
      }
    }
    return hours;
  }

};