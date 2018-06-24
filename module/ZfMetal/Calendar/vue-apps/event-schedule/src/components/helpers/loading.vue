<template>
   <div class="zfc-loading" v-if="isLoading">
       <img src="../../assets/blocks-loading.gif" />
   </div>
</template>

<script>
export default {
  name: 'loading',
  props: ['isLoading']
}
</script>


<style scoped>
    .zfc-loading{
        position:absolute;
        top:0;
        left:0;
        z-index: 100;
    }
</style>