<template>
    <div class="hello">
        <h1>{{ msg }}</h1>

    </div>
</template>

<script>
  import axios from 'axios'

  export default {
    name: 'HelloWorld',
    data() {
      return {
        api: {
          calendar: {
            list: '/calendar/calendar-api/list'
          }
        },
        calendars: [],
        msg: 'Welcome to Your Vue.js App'
      }
    },
    created: function () {
      this.getCalendars();
    },
    methods: {
      getCalendars: function () {
        axios.get(
          this.api.calendar.list,
          {
            headers: {
              accept: 'application/json'
            }
          }).then(
          (response) => {
            this.calendars = response.data
          })
      }
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    h1, h2 {
        font-weight: normal;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        display: inline-block;
        margin: 0 10px;
    }

    a {
        color: #42b983;
    }
</style>
