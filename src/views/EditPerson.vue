<template>
  <div class="col-12 col-sm-6">
    <person-form :isEdit="true" :id="id" class="mb-3" />
    <placements-table :person_id="id" :canEdit="true"></placements-table>
  </div>
</template>
<script>
import PersonForm from "../components/PersonForm.vue";
import PlacementsTable from "../components/PlacementsTable.vue";
export default {
  components: {
    PersonForm,
    PlacementsTable,
  },
  data() {
    return {
      id: "",
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
