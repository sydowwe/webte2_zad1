<template>
  <h1>Pridať športovca</h1>
  <person-form :isEdit="false" />
</template>
<script>
  import PersonForm from '../components/PersonForm.vue';
  export default {
      components: {
          PersonForm
      }
  }
</script>

<style>
/* Your custom styles */
</style>