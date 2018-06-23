import Vue from 'vue'
import Vuex from 'vuex'

import moment from 'moment'
import tz from 'moment-timezone'
import 'moment/locale/es';

import {getters} from './getters'
import {HTTP} from './http-client'
import {ADD_CALENDAR,SET_CALENDARS,SET_PRE_EVENTS} from './mutation-types'

Vue.use(Vuex)


const state = {
  date: moment().tz('America/Argentina/Buenos_Aires').locale('es'),
  calendars: [],
  preEvents: [],
};



const actions = {
  calendarList({commit}) {
    HTTP.get('calendars').then((response) => {
        commit(SET_CALENDARS,  response.data);
    })
  },
  preEventList({commit}) {
    HTTP.get('events?calendar=isNull').then((response) => {
      commit("SET_PRE_EVENTS",response.data);
    })
  },
};

const mutations = {
  [ADD_CALENDAR](state, calendar) {
    state.calendars.push(calendar);
  },
  [SET_CALENDARS](state, calendars) {
    state.calendars = calendars;
  },
  [SET_PRE_EVENTS](state, preEvents) {
    state.preEvents = preEvents;
  }
};


const store = new Vuex.Store({
  state,
  getters,
  actions,
  mutations
});


export default store;