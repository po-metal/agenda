<template>
    <div>
        <a class="btn btn-xs material-icons" @click="before"> <i class="material-icons">navigate_before</i></a>
        <input type="date" class="" v-model="date" v-on:change="onChange">
        <a class="btn btn-xs material-icons" @click="next"><i class="material-icons">navigate_next</i></a>
    </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex';

  import moment from 'moment'
  import momenttz from 'moment-timezone'
  import 'moment/locale/es';

  export default {
    name: 'day',
    props: ['value'],
    data() {
      return {
        date: ''
      }
    },
    created: function () {
      this.date = this.value;
    },
    methods: {
      ...mapActions([
        'changeDate'
      ]),
    before: function () {
      var d = moment(this.date)
      d.subtract(1, 'day')
      this.date = d.tz('America/Argentina/Buenos_Aires').format("YYYY-MM-DD")
      this.changeDate(this.date)
    },
    next: function () {
      var d = moment(this.date)
      d.add(1, 'day')
      this.date = d.tz('America/Argentina/Buenos_Aires').format("YYYY-MM-DD")
      console.log(this.date)
      this.changeDate(this.date)
    },
    onChange: function () {
      var d = moment(this.date)
      this.changeDate(d)
    },
    getDate: function () {
      return this.date.tz('America/Argentina/Buenos_Aires').format("YYYY-MM-DD")
    }
  }
  }
</script>

