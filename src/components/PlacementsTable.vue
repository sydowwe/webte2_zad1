<template>
  <div>
    <h3 class="text-center">Umiestnenia</h3>
    <table
      id="placementsTable"
      class="table table-striped table-bordered dt-responsive nowrap no-footer"
    >
      <thead>
        <tr>
          <th>Umiestnenie</th>
          <th>Hry</th>
          <th>Disciplína</th>
          <th>
            <button class="btn btn-sm btn-success" @click="addNew">Add</button>
          </th>
          <th>
            <button class="btn btn-sm btn-warning" @click="deleteAll">
              Delete All
            </button>
          </th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>

    <my-modal ref="myModal">
      <template v-slot:modal-body v-if="isEdit">
        <PlacementForm
          :isEdit="true"
          :id="id"
          @saved="redrawTable"
          :modalRef="modalRef"
          :personId="person_id"
        />
      </template>
      <template v-slot:modal-body v-else>
        <PlacementForm
          :isEdit="false"
          @saved="redrawTable"
          :modalRef="modalRef"
          :personId="person_id"
        />
      </template>

      <template v-slot:modal-footer>
        <button type="button" class="btn btn-danger" @click="hideModal">
          Zavrieť
        </button>
        <button type="submit" class="btn btn-success" form="placementForm">
          Uložiť
        </button>
      </template>
    </my-modal>
  </div>
</template>

<script>
import MyModal from "./MyModal.vue";
import PlacementForm from "./PlacementForm.vue";

export default {
  components: {
    MyModal,
    PlacementForm,
  },
  props: {
    person_id: {
      type: String,
      default: null,
    },
  },
  data() {
    return {
      modalRef: null,
      isEdit: false,
      id: "",
      dataTable: null,
    };
  },
  mounted() {
    this.modalRef = this.$refs.myModal;
    const vue = this;
    this.dataTable = $("#placementsTable").DataTable({
      scrollX: true,
      responsive: true,
      rowId: "id",
      columnDefs: [
        { targets: [3, 4], orderable: false },
        { className: "text-center", targets: "_all" },
      ],
      ajax: {
        url: `/api/getPlacements.php?person_id=${this.person_id}`,
        type: "GET",
        dataSrc: "",
      },
      columns: [
        { data: "placement" },
        { data: "games" },
        { data: "discipline" },
        {
          data: "id",
          render: (data) =>
            `<button data-id="${data}" class="editBtn btn btn-primary btn-sm">Edit</button>`,
        },
        {
          data: "id",
          render: (data) =>
            `<button data-id="${data}" class="deleteBtn btn btn-danger btn-sm">Delete</button>`,
        },
      ],
    });
    $("#placementsTable").on("click", "button.editBtn", function () {
      const id = $(this).attr("data-id");
      vue.isEdit = true;
      vue.id = id;
      vue.showModal("Upraviť umiestnenie");
    });
    $("#placementsTable").on("click", "button.deleteBtn", function () {
      const id = $(this).attr("data-id");
      vue.dataTable.row(`#${id}`).remove().draw();
      $.ajax({
        url: `/api/deletePlacement.php?id=${id}`,
        type: "POST",
      });
    });
  },
  methods: {
    redrawTable() {
      this.dataTable.ajax.reload(null, false);
    },
    showModal(title) {
      this.$refs.myModal.title = title;
      this.$refs.myModal.showModal();
    },
    hideModal() {
      this.$refs.myModal.hideModal();
    },
    addNew() {
      this.isEdit = false;
      this.showModal("Pridať umiestnenie");
    },
    deleteAll() {
      this.dataTable.clear().draw();
      $.ajax({
        url: `/api/deleteAllPlacements.php?person_id=${this.person_id}`,
        type: "POST",
      });
    },
  },
};
</script>
