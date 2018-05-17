<template>

    <div :id="modalId" class="modal fade " :class="[ modalClass ? modalClass : '' ]" tabindex="-1" role="dialog">
        <div class="modal-dialog" :class="[ modalSize ? modalSize : 'modal-sm' ]" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ title }}

                    </h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <slot></slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'modal',
    props: ['modalId', 'modalClass', 'modalSize', 'title'],
    data: function () {
      return {}
    }
  }
</script>
