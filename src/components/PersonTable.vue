<template>
  <div>
    <table
      id="mainTable"
      class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed"
    >
      <thead>
        <tr>
          <th>Meno</th>
          <th>Priezvisko</th>
          <th>Dátum narodenia</th>
          <th>Miesto narodenia</th>
          <th>Krajina narodenia</th>
          <th>Dátum úmrtia</th>
          <th>Miesto úmrtia</th>
          <th>Krajina úmrtia</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody>       
      </tbody>
    </table>
    <router-link to="/add-person" class="btn btn-success">Pridať</router-link>
  </div>
</template>

<script>
export default {
  data() {
    return {
      table: null,
    };
  },
  mounted() {
    const table = $("#mainTable").DataTable({
      columns: [
        { data: "name" },
        { data: "surname" },
        { data: "birth_day" },
        { data: "birth_place" },
        { data: "birth_country" },
        { data: "death_day" },
        { data: "death_place" },
        { data: "death_country" },
        {
          data: "id",
          render: (data) =>
            `<button class="btn btn-primary btn-sm" @click="editRow(${data})">Edit</button>`,
        },
        {
          data: "id",
          render: (data) =>
            `<button class="btn btn-danger btn-sm" @click="deleteRow(${data})">Delete</button>`,
        }
      ],
      ajax: {
        url: "/api/getPeople.php",
        type: "GET",
        dataSrc: "",
      },
      rowCallback: (row, data) => {
        $(row).on("click", () => {
          console.log(data.id);
          this.$router.push({ name: "view-person", query: { id: data.id } });
        });
      },
    });
    this.table = table;
  },
  methods: { 
    editRow(id) {
      this.$router.push({ name: "edit-person", params: id });
    },
    deleteRow(id) {
      this.table.row(`[data-id="${id}"]`).remove().draw();
      $.ajax({
        url: `/deletePerson.php?id=${id}`,
        type: "POST",
        data: id,
      });
    },
  },
};
</script>
