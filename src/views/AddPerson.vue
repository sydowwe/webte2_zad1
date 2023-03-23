<template>
  <h2>Pridať športovca</h2>
  <person-form :isEdit="false" />
</template>
<script>
import PersonForm from "../components/PersonForm.vue";
export default {
  components: {
    PersonForm
  },
};
</script>