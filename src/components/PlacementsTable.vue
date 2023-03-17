<template>
  <div>
    <h3>Umiestnenia</h3>

    <table id="sportsmanTable" class="table table-striped table-bordered dt-responsive nowrap no-footer dtr-inline collapsed">
      <thead>
        <tr>
          <th>Umiestnenie</th>
          <th>Hry</th>
          <th>Disciplína</th>
          <th>Upraviť</th>
          <th>Odstrániť</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="placement in placements">
          <td>{{ placement.placement }}</td>
          <td>{{ placement.games }}</td>
          <td>{{ placement.discipline }}</td>
          <td>
            <button class="btn btn-primary btn-sm" @click="editRow(placement.id)">
              Upraviť
            </button>
          </td>
          <td>
            <button class="btn btn-danger btn-sm" @click="removeRow(placement.id)">
              Odstrániť
            </button>
          </td>
        </tr>
      </tbody>
      <!-- <button class="btn btn-success" @click="addNew">Pridať umiestnenie</button>
      <tfoot>
        
      </tfoot> -->
    </table>

    <my-modal ref="myModal">    
      <template v-slot:modal-body v-if="isEdit">
        <PlacementForm :isEdit="true" :id="id" @saved="hideModal" />
      </template>
      <template v-slot:modal-body v-else>
        <PlacementForm :isEdit="false" @saved="hideModal" />
      </template>

      <template v-slot:modal-footer>
        <button type="button" class="btn btn-danger" @click="hideModal">Zavrieť</button>
        <button type="submit" class="btn btn-success" form="placementForm">Uložiť</button>
      </template>
    </my-modal>
  </div>
</template>

<script>
import MyModal from './MyModal.vue';
import PlacementForm from './PlacementForm.vue';

export default {
  components: {
    MyModal,
    PlacementForm,
  },
  props: {
    person_id: {
      type: Number,
      default: null,
    },
  },
  data() {
    return {
      isEdit: false,
      table: null,
      placements: [],
      id: 0
    };
  },
  created() {
    $.ajax({
      type: "GET",
      contentType: "application/json",
      url: `/api/getPlacements.php?person_id=${this.person_id}`,
    }).done((placements) => {
      placements.forEach((placement) => {
        this.placements.push({
          id: placement.id,
          placement: placement.placement,
          games: placement.games,
          discipline: placement.discipline,
        });
      });
    });   
    console.log(self);
  },
  mounted(){ 
    this.table = $("#sportsmanTable").DataTable({
      autoWidth: true
    });    
  },
  methods: {
    showModal(title) {
      this.$refs.myModal.title = title;
      this.$refs.myModal.showModal();
    },
    hideModal() {
      this.$refs.myModal.hideModal();
    },
    addNew() {
      this.isEdit = false;
      this.showModal('Pridať umiestnenie');
    },
    editRow(id) {
      this.isEdit = true;
      this.id = id;
      this.showModal('Upraviť umiestnenie');
    },
    deleteRow(id) {
      console.log("delete");
      this.table.row(`[data-id="${id}"]`).remove().draw();
      // $.ajax({
      //   url: `/deletePerson.php?id=${id}`,
      //   type: "GET",
      // });
    },
  },
};
</script>
