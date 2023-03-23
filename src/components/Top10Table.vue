<template>
  <div>
    <table
      id="top10Table"
      class="table table-striped table-responsive table-bordered no-footer"
    >
      <thead>
        <tr>
          <th>Počet výhier</th>
          <th>Meno a priezvisko</th>
          <th>Roky</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</template>
<script>
export default {
  mounted() {
    this.$nextTick(function () {
      $("#top10Table").DataTable({
        scrollX: true,
        responsive: true,
        paging: false,
        info: false,
        searching: false,
        order: [[0, "desc"]],
        columnDefs: [{ className: "text-center", targets: "_all" }],
        columns: [
          { data: "no_of_wins" },
          { data: "name_surname" },
          { data: "years" },
        ],
        ajax: {
          url: "/zad1/api/getTop10.php",
          type: "GET",
          dataSrc: "",
        },
        rowCallback: (row, data) => {
          $(row).on("click", () => {
            this.$router.push({ name: "view-person", params: { id: data.id } });
          });
        },
      });
    });
  },
};
</script>
