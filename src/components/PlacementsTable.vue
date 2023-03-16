<template>
  <div>
    <h1>Sportsman Placements</h1>

    <button class="btn btn-success btn-sm" @click="addNew">Pridať</button>
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
    </table>
  </div>
</template>

<script>
export default {
  props: {
    person_id: {
      type: Number,
      default: null,
    },
  },
  data() {
    return {
      table: null,
      placements: [],
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
      console.log(placements);
    });
   
  },
  mounted(){ 
    this.table = $("#sportsmanTable").DataTable({
      autoWidth: true
    });
  },
  methods: {
    addNew() {
      console.log("add");
    },
    editRow(id) {
      console.log(id);
      // this.$router.push({ name: "edit-person", params: id });
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
