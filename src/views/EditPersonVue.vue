<template>
  <div>
      <person-form :isEdit="true" :id="id" class="mb-3" />
      <placements-table :person_id="id"></placements-table>
  </div>
</template>
<script>
  import PersonForm from './PersonForm.vue';
  import PlacementsTable from './PlacementsTable.vue'
  export default {
      components: {
          PersonForm,
          PlacementsTable
      },
      data() {
          return {
              id: null,
          };
      },
      created() {
          const params = new URLSearchParams(window.location.search);
          const id = params.get('id');
          if (this.id == null) {
              console.log('!!!chybajuce ID!!!');
              throw new Error("Param not found");
          }
      }
  }
</script>

<style>
/* Your custom styles */
</style>