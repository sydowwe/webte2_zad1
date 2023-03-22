<template>
  <div class="col-12 col-sm-6">
    <h2 id="name">meno</h2>
    <placements-table :person_id="id"></placements-table>
  </div>
</template>
<script>
import PlacementsTable from "../components/PlacementsTable.vue";
export default {
  components: {
    PlacementsTable,
  },
  data() {
    return {
      id: null,
    };
  },
  created() {
    const params = new URLSearchParams(window.location.search);
    this.id = parseInt(params.get("id"));
    if (this.id == null) {
      console.log("!!!chybajuce ID!!!");
      throw new Error("Param not found");
    }
  },
};
</script>
