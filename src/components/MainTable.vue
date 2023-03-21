<template>
  <div>
    <table
      id="mainTable"
      class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer"
    >
      <thead>
        <tr>
          <th>Meno</th>
          <th>Priezvisko</th>
          <th id="typ">Typ</th>
          <th>Rok</th>
          <th>Mesto</th>
          <th>Disciplína</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
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
    this.table = $("#mainTable").DataTable({
      responsive: true,
      columnDefs: [{ className: "text-center", targets: "_all" }],
      columns: [
        { data: "name" },
        { data: "surname" },
        { data: "type" },
        { data: "year" },
        { data: "city" },
        { data: "discipline" },
      ],
      ajax: {
        url: "/api/getTableData.php",
        type: "GET",
        dataSrc: "",
      },
      rowCallback: (row, data) => {
        $(row).on("click", () => {
          this.$router.push({ name: "view-person", params: { id: data.id } });
        });
      },
    });
  },
};
</script>
