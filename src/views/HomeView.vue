<template>
  <div class="col-12 col-sm-6">
    <main-table class="mb-5"></main-table>
    <top10-table></top10-table>
  </div>
</template>

<script>
import MainTable from "../components/MainTable.vue";
import Top10Table from "../components/Top10Table.vue";
export default {
  components: {
    MainTable,
    Top10Table
  },
};
</script>
