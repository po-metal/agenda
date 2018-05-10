<template>
    <drag @drop="drogTicket" :transfer-data="obj.id">
        <div class="ticket">
            {{obj.id}} - {{obj.subject}}
        </div>
    </drag>
</template>

<script>

    import {Drag, Drop} from 'vue-drag-drop';

    export default {
        name: 'ticket',
        props: ['ticket'],
        components: {Drag, Drop},
        data() {
            return {
                obj: {
                    id: '',
                    subject: '',
                    time: 60
                }
            }
        },
        created: function () {
            this.obj = this.ticket;
        },
        methods: {
            drogTicket: function (data) {
                console.log(data);
            }
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.ticket{
    border:1px solid #8B8986;
}
</style>
