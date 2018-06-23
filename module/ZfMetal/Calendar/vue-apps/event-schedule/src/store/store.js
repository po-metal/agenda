import Vue from 'vue'
import Vuex from 'vuex'

import moment from 'moment'
import tz from 'moment-timezone'
import 'moment/locale/es';

import {getters} from './getters'
import {HTTP} from './../utils/http-client'
import {calculateEventDuraction} from './../utils/helpers'
import {
  SET_DATE,
  ADD_CALENDAR, SET_CALENDARS, SET_PRE_EVENTS,
  SET_EVENTS, CLEAR_EVENTS, ADD_EVENT, UPDATE_EVENT, REMOVE_PRE_EVENTS, SET_COORDINATE,
  SET_BODY_SCROLL, SET_CALENDAR_SCROLL, SET_CALENDAR_POSITION,
  SET_EVENT_STATES, SET_EVENT_TYPES
} from './mutation-types'

Vue.use(Vuex)


const state = {
  loading: false,
  coordinates: {},
  calendarPosition: {top: 0, left: 0},
  bodyScroll: {top: 0, left: 0},
  calendarScroll: {top: 0, left: 0},
  date: moment().tz('America/Argentina/Buenos_Aires').locale('es'),
  calendars: [],
  preEvents: [],
  events: [],
  eventStates: [],
  eventType: []
};


const actions = {
  changeDate({state, commit, dispatch}, date) {
    console.log(date)
    var newDate = moment(date)
    if (newDate.isValid()) {
      commit('SET_DATE', newDate);
      commit('CLEAR_EVENTS', newDate);
      dispatch('eventList');
    }
  },

  eventStateList({commit}) {
    state.loading = true;
    HTTP.get('event-states').then((response) => {
      commit("SET_EVENT_STATES", response.data);
      state.loading = false;
    })
  },
  eventTypeList({commit}) {
    state.loading = true;
    HTTP.get('event-types').then((response) => {
      commit("SET_EVENT_TYPES", response.data);
      state.loading = false;
    })
  },
  calendarList({state, commit, dispatch}) {
    state.loading = true;
    HTTP.get('calendars').then((response) => {
      commit(SET_CALENDARS, response.data);
      state.loading = false;
      dispatch('eventList');
    })
  },
  preEventList({commit}) {
    state.loading = true;
    HTTP.get('events?calendar=isNull').then((response) => {
      commit("SET_PRE_EVENTS", response.data);
      state.loading = false;
    })
  },
  eventList({state, getters, dispatch}) {
    state.loading = true;
    HTTP.get("events?calendar=isNotNull&start=" + getters.getDate + "<>" + getters.getNextDate
    ).then((response) => {
      for (var i = 0; i < response.data.length; i++) {
        if (response.data[i].calendar != null) {
          dispatch('pushEvent', response.data[i])
        }
      }
      state.loading = false;
    })
  },
  pushEvent({state, commit, getters}, event) {
    event.hour = moment(event.start).tz('America/Argentina/Buenos_Aires').format("HH:mm");
    // event.duration = calculateEventDuraction(event);
    event.top = getters.getCoordinate(event.calendar, event.hour, 'top');
    event.left = getters.getCoordinate(event.calendar, event.hour, 'left');
    state.loading = true;

    HTTP.put("events/" + event.id, event
    ).then((response) => {
      state.loading = false;
      commit('ADD_EVENT', event);
    }).catch((error) => {
      state.loading = false;
    })


  },
  updateEvent({state, commit, getters}, {index, event}) {
    event.top = getters.getCoordinate(event.calendar, event.hour, 'top');
    event.left = getters.getCoordinate(event.calendar, event.hour, 'left');
    state.loading = true;
    HTTP.put("events/" + event.id, event
    ).then((response) => {
      state.loading = false;
      commit(UPDATE_EVENT, {index: index, event: event})
    }).catch((error) => {
      state.loading = false;
    })
  },
  removePreEvent({commit}, index) {
    commit("REMOVE_PRE_EVENTS", index);
  }

};

const mutations = {
  [SET_DATE](state, newDate) {
    state.date = newDate;
  },
  [ADD_CALENDAR](state, calendar) {
    state.calendars.push(calendar);
  },
  [SET_EVENT_STATES](state, eventStates) {
    state.eventStates = eventStates;
  },
  [SET_EVENT_TYPES](state, eventTypes) {
    state.eventTypes = eventTypes;
  },
  [SET_CALENDARS](state, calendars) {
    state.calendars = calendars;
  },
  [SET_PRE_EVENTS](state, preEvents) {
    state.preEvents = preEvents;
  },
  [SET_EVENTS](state, events) {
    state.events = events;
  },
  [CLEAR_EVENTS](state) {
    state.events = []
  },
  [REMOVE_PRE_EVENTS](state, index) {
    state.preEvents.splice(index, 1);
  },
  [ADD_EVENT](state, event) {
    state.events.push(event);
  },
  [UPDATE_EVENT](state, {index, event}) {
    state.events[index] = event;
  },
  [SET_COORDINATE](state, {calendar, hour, type, value}) {
    if (state.coordinates[calendar] == undefined) {
      state.coordinates[calendar] = {};
    }
    if (state.coordinates[calendar][hour] == undefined) {
      state.coordinates[calendar][hour] = {};
    }
    state.coordinates[calendar][hour][type] = value;
  },
  [SET_CALENDAR_POSITION](state, {top, left}) {
    state.calendarPosition.top = top;
    state.calendarPosition.left = left;
  },
  [SET_BODY_SCROLL](state, {top, left}) {
    state.bodyScroll.top = top;
    state.bodyScroll.left = left;
  },
  [SET_CALENDAR_SCROLL](state, {top, left}) {
    state.calendarScroll.top = top;
    state.calendarScroll.left = left;
  }
};


const store = new Vuex.Store({
  state,
  getters,
  actions,
  mutations
});


export default store;