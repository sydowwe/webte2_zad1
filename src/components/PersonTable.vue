<template>
  <div>
    <table
      id="personTable"
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
          <th>
            <router-link to="/add-person" class="btn btn-sm btn-success"
              >Pridať</router-link
            >
          </th>
          <th>            
            Delete 
          </th>
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
      dataTable: null,
    };
  },
  mounted() {
    const self = this;
    this.dataTable = $("#personTable").DataTable({
      scrollX: true,
      responsive: true,
      rowId: "id",
      columnDefs: [
        { targets: [8, 9], orderable: false },
        { className: "text-center", targets: "_all" },
      ],
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
            `<button data-id="${data}" class="editBtn btn btn-primary btn-sm">Edit</button>`,
        },
        {
          data: "id",
          render: (data) =>
            `<button data-id="${data}" class="deleteBtn btn btn-danger btn-sm">Delete</button>`,
        },
      ],
      ajax: {
        url: "/zad1/api/getPeople.php",
        type: "GET",
        dataSrc: "",
      },
      rowCallback: (row, data) => {
        $(row).on("click", (e) => {
          if (e.target.nodeName !== "BUTTON") {
            this.$router.push({ name: "view-person", params: { id: data.id } });
          }
        });
      },
    });
    $("#personTable").on("click", "button.editBtn", function () {
      const id = $(this).attr("data-id");      
      self.$router.push({ name: "edit-person", params: { id: id } });
    });
    $("#personTable").on("click", "button.deleteBtn", function () {
      const id = $(this).attr("data-id");
      $.ajax({
          type: "POST",
          contentType: "application/json",
          url: '/zad1/api/addAdminLog.php',
          data: JSON.stringify({
            "operation": "delete",
            "table": "People",
            "recordId": id 
          }),
          dataType: "json",
        })
        .done(data => {    
          console.log('zapisane');      
        })
      self.dataTable.row(`#${id}`).remove().draw();
      $.ajax({
        url: `/zad1/api/deletePerson.php?id=${id}`,
        type: "POST",
      });
    });
  }  
};
</script>
