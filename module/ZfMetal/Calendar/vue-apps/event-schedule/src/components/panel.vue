<template>
    <div>

        <vue-tabs>
            <v-tab title="P">
                <h3>Pendientes</h3>
                <preEvent v-if="getPreEvents" v-for="(preEvent,index) in getPreEvents" :preEvent="preEvent"
                          :key="preEvent.id" :index="index">
                </preEvent>
            </v-tab>

            <v-tab title="C">
                Calendars
            </v-tab>

            <v-tab title="Z">
                Zonas
            </v-tab>
        </vue-tabs>



    </div>

</template>

<script>
  import {mapGetters, mapActions} from 'vuex';
  import preEvent from "./preEvent.vue";
  import {VueTabs, VTab} from 'vue-nav-tabs'
  //you can also import this in your style tag
  import 'vue-nav-tabs/themes/vue-tabs.css'

  export default {
    name: 'panel',
    components: {preEvent,VueTabs,VTab},
    computed: {
      ...mapGetters([
        'getPreEvents',
      ]),
    },
  }
</script>