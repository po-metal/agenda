<template>
    <div class="col-lg-4 col-lg-offset-4">
        <div class="row">
            <div class="col-xs-3">
                <button class="btn material-icons">navigate_before</button>
            </div>

            <div class="col-xs-6">
            <input type="date" class="form-control" v-model="day">
            </div>
            <div class="col-xs-3">
                <button class="btn material-icons">navigate_next</button>
            </div>
        </div>
    </div>
</template>

<script>

  export default {
    name: 'day',
    props: ['value'],
    data() {
      return {
        day: ''
      }
    },
    created: function(){
      console.log( this.value);
      this.day = this.value;
    }
  }
</script>

