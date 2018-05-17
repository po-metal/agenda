<template>
    <form method="POST" name="EventForm" v-on:submit.prevent="save">

        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="form-group">
                <label class="control-label">Titulo</label>
                <saveStatus :isSaved="h.isSaved"></saveStatus>
                <div class="input-group">
                    <span class="input-group-addon"><i class="material-icons">title</i></span>
                    <input type="text" name="title" class=" form-control" v-model="entity.title"
                           @keydown="unsaved">
                </div>
                <fe :errors="errors.title"/>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="form-group">
                <label class="control-label">Descripcion</label>
                <input type="textarea" name="description" class=" form-control" v-model="entity.description"
                       @keydown="unsaved">
                <fe :errors="errors.description"/>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="form-group">
                <label class="control-label">Inicio</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="material-icons">date_range</i></span>
                    <input type="datetime" name="start" class=" form-control" v-model="entity.start" @keydown="unsaved">
                </div>
                <fe :errors="errors.start"/>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="form-group">
                <label class="control-label">Fin</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="material-icons">date_range</i></span>
                    <input type="datetime" name="end" class=" form-control" v-model="entity.end" @keydown="unsaved">
                </div>
                <fe :errors="errors.end"/>
            </div>
        </div>

        <div class="col-lg-12 col-xs-12">
            <button name="submitbtn" class="btn" :class="submitClass" v-if="!h.isSaved"
                    :disabled="h.submitInProgress"> {{submitValue}}
            </button>
        </div>
    </form>
</template>


<script>
    import fe from '../helpers/form-errors.vue'
    import saveStatus from '../helpers/save-status.vue'

    export default {
        name: 'form-event',
        props: ['value', 'isSaved'],
        components: {fe, saveStatus},
        data() {
            return {
                errors: [],
                h: {
                    loading: false,
                    isSaved: true,
                    submitInProgress: false
                },
                entity: {}
            }
        },
        methods: {
            populate: function (data) {
                this.entity.id = data.id
                this.entity.title = data.title
                this.entity.description = data.description
                this.entity.start = data.start
                this.entity.end = data.end
                this.entity.calendar = data.calendar
            },
            unsaved: function(){
              //TODO
            },
            save: function () {
                this.errors = ''
                this.h.submitInProgress = true
                if(this.entity.id){this.update()}else{this.create()}
            },
            create: function(){
                axios.post("/zfmc/api/event", this.entity
                ).then((response) => {
                    this.entity.id = response.data.id
                    this.h.submitInProgress = false
                    this.$emit("eventCreate",this.entity)
                }).catch((error) => {
                    this.errors = error.response.data.errors
                    this.h.submitInProgress = false
                })
            },
            update: function(){
                axios.put("/zfmc/api/event", this.entity
                ).then((response) => {
                    this.h.submitInProgress = false
                    this.$emit("eventUpdate",this.entity)
                }).catch((error) => {
                    this.errors = error.response.data.errors
                    this.h.submitInProgress = false
                })
            }
        },
        created: function () {
            this.entity = this.value
        },
    }
</script>
