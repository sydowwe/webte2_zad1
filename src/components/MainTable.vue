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
          <th id="typ">Typ</th>
          <th>Rok</th>
          <th>Mesto</th>
          <th>Disciplína</th>          
        </tr>
      </thead>
      <tbody></tbody>
    </table>
    <router-link to="/add-person" class="btn btn-primary">Add</router-link>
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
        { data: "type" },
        { data: "year" },
        { data: "city" },
        { data: "discipline" }
      ],
      ajax: {
        url: "../../api/getTableData.php",
        type: "GET",
        dataSrc: "",
      },
      rowCallback: (row, data)=> {
        $(row).on("click", ()=>{
          this.$router.push({ name: "view-person", query: { id: data.id } });
        });
      },
    });
    this.table = table;
  }  
};
</script>
