<template>
  <div class="col-12 col-sm-6">
    <person-info :id="id"></person-info>
    <placements-table :person_id="id" :canEdit="false"></placements-table>
  </div>
</template>
<script>
import PlacementsTable from "../components/PlacementsTable.vue";
import PersonInfo from "@/components/PersonInfo.vue";
export default {
  components: {
    PlacementsTable,
    PersonInfo
  },
  data() {
    return {
      id: null,
    };
  },
  created() {
    this.id = this.$route.params.id;
    if (this.id == -1) {
      console.log("!!!chybajuce ID!!!");
      throw new Error("Param not found");
    }
  },
};
</script>
