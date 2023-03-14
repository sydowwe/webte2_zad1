<template>
  <h1>Pridať športovca</h1>
  <div class="">
      <my-form :isEdit="false" />
  </div>
</template>
<script>
  import PersonForm from '../components/PersonForm.vue';
  export default {
      components: {
          // name: 'AddPerson',//!!!!!
          PersonForm
      }
  }
</script>

<style>
/* Your custom styles */
</style>