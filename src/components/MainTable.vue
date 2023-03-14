<template>
  <table
    id="mainTable"
    class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed"
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
  <button class="btn btn-primary" @click="addRow">Add</button>
</template>
<script>
import ''
export default {
  data() {
    return {
      table: null,
      currentRow: null,
      editMode: false,
    };
  },
  mounted() {
    const table = $("#mainTable").DataTable({
      columns: [
        { data: "name" },
        { data: "surname" },
        { data: "type" },
        { data: "year" },
        { data: "city" },
        { data: "discipline" },
        {
          render: (data, type, row) =>
            `<button class="btn btn-primary btn-sm" data-row="${JSON.stringify(
              row
            )}" data-mode="edit">Edit</button>
            <button class="btn btn-danger btn-sm" data-row="${JSON.stringify(
              row
            )}" data-mode="delete">Delete</button>`,
        },
      ],
      ajax: {
        url: '../../api/getTableData.php',
        type: "GET",
        dataSrc: "",
      },
      methods: {
        addRow() {
          // redirect to add page
          window.location.href = "/add_row.php";
        },
        editRow(row) {
          // redirect to edit page with row data
          window.location.href = `/edit_row.php?id=${row.id}`;
        },
        deleteRow(row) {
          // confirm deletion using Bootstrap modal
          $("#deleteModal").modal("show");
          this.currentRow = row;
        },
        confirmDelete() {
          // delete row from table and server
          this.table.row(`[data-id="${this.currentRow.id}"]`).remove().draw();
          $.ajax({
            url: "/delete_row.php", // replace with your server endpoint
            type: "POST",
            data: { id: this.currentRow.id },
            success: () => {
              $("#deleteModal").modal("hide");
            },
          });
        },
      },
    });
  },
};
</script>
