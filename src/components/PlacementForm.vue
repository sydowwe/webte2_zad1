<template>
  <form @submit.prevent="handleSubmit" id="placementForm">
    <div class="form-group">
      <label for="placement">Umiestnenie</label>
      <input
        type="number"
        class="form-control form-control-sm"
        id="placement"
        v-model="formData.placement"
        min="0"
        max="30"
      />
    </div>
    <div class="form-group">
      <label for="games">Olympíjské hry</label>
      <select class="form-control" id="games" v-model="formData.gamesId"></select>
    </div>
    <div class="form-group">
      <label for="discipline">Disciplína</label>
      <input
        type="text"
        class="form-control form-control-sm"
        id="discipline"
        v-model="formData.discipline"
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
  },
  data() {
    return {
      formData: {
        personId: this.id,
        placement: 0,
        gamesId: 0,
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
        this.formData.gamesId = data.gamesId;
        this.formData.discipline = data.discipline;
      });
    }
  },
  mounted() {
    console.log(this.$refs.myModal);
    $("#games").select2({
      dropdownParent: this.$refs.myModal,
      width: '100%',
      placeholder: 'Select a game',
      allowClear: true,
      ajax: {
        url: "/api/getGames.php",
        dataType: "json",
        processResults: data => {
          return {
            results: $.map(data, item => {
              return {
                text: item.games,
                id: item.gamesId,
              };
            }),
          };
        },
      }
    });
  },
  methods: {
    handleSubmit() {
      let myUrl = this.isEdit
        ? `/api/editPlacement.php?id=${id}`
        : `/api/addPlacement.php`;
      $.ajax({
        type: "POST",
        contentType: "application/json",
        url: myUrl,
        data: JSON.stringify(this.formData),
        dataType: "json",
      }).done((data) => {
        console.log("Placement saved!");
        this.$emit("saved");
      });
    },
  },
  watch: {
    isEdit(newVal, oldVal) {
      if (newVal === false) {
        this.formData.placement = 0;
        this.formData.gamesID = 0;
        this.formData.discipline = "";
      }
    },
  },
};
</script>