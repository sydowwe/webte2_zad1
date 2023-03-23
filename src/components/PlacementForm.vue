<template>
  <form @submit.prevent="handleSubmit" id="placementForm">
    <div class="form-group">
      <label for="placement">Umiestnenie</label>
      <input
        type="number"
        class="form-control form-control-sm"
        id="placement"
        v-model="formData.placement"
        min="1"
        max="30"
        required
      />
    </div>
    <div class="form-group">
      <label for="games">Olympíjské hry</label>
      <select
        class="form-control"
        id="games"
        ref="gamesSelect"
        required
      ></select>
    </div>
    <div class="form-group">
      <label for="discipline">Disciplína</label>
      <input
        type="text"
        class="form-control form-control-sm"
        id="discipline"
        v-model="formData.discipline"
        required
      />
    </div>
  </form>
</template>

<script>
export default {
  props: {
    isEdit: {
      type: Boolean,
      required: true,
    },
    id: {
      type: String,
      default: null,
    },
    modalRef: {
      type: Object,
      default: null,
    },
    personId: {
      type: String,
      default: null,
    },
  },
  data() {
    return {
      formData: {
        placement: 0,
        gameId: 0,
        discipline: "",
      },
    };
  },
  created() {
    if (this.isEdit) {
      $.ajax({
        type: "GET",
        contentType: "application/json",
        url: `/api/getPlacementById.php?id=${this.id}`,
      }).done((data) => {
        this.formData.placement = data.placement;
        this.formData.games = data.games;
        this.formData.gameId = data.gameId;
        this.formData.discipline = data.discipline;
      });
    }
  },
  updated() {
    $("#games").select2({
      width: "100%",
      dropdownParent: this.modalRef.$el,
      placeholder: "Select a game",
      allowClear: true,
      ajax: {
        url: "/api/getGames.php",
        dataType: "json",
        processResults: (data) => {
          return {
            results: $.map(data, (item) => {
              return {
                text: item.games,
                id: item.id,
              };
            }),
          };
        },
      },
    });
    $("#games").on("change", (e) => {
      this.formData.gameId = e.target.value;
    });    
  },
  methods: {
    handleSubmit() {
      let myUrl = this.isEdit
        ? `/api/editPlacement.php?id=${this.id}`
        : `/api/addPlacement.php`;
      this.formData.personId = this.personId;
      $.ajax({
        type: "POST",
        contentType: "application/json",
        url: myUrl,
        data: JSON.stringify(this.formData),
        dataType: "json",
      })
        .done((id) => {
          if (id == "edit") {
            alert(`Umiestnenie bol upravené`);
          } else {
            alert(`Umiestnenie bolo pridané`);
          }
          this.$emit("saved");
          this.modalRef.hideModal();
        })
        .fail((error) => {
          alert("Chyba!");
        });

        $.ajax({
          type: "POST",
          contentType: "application/json",
          url: '/api/addAdminLog.php',
          data: JSON.stringify({
            "operation": this.isEdit ? "edit" : "add",
            "table": "Placements",
            "recordId": this.id 
          }),
          dataType: "json",
        })
        .done(data => {    
          console.log('zapisane');      
        })
    },
  },
  watch: {
    isEdit(newVal, oldVal) {
      if (newVal === false) {
        this.formData.placement = 0;
        this.formData.gameID = 0;
        this.formData.discipline = "";
      }
    },
  },
};
</script>
