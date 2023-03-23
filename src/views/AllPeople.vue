<template>
  <div class="col-12 col-sm-8">
    <h2>Všetci naši olympionici</h2>
    <person-table></person-table>
  </div>
</template>
<script>
import PersonTable from "../components/PersonTable.vue";
export default {
  components: {
    PersonTable
  },
};
</script>