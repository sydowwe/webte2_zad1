<template>
  <div
    id="formModal"
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-labelledby="formModal"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <form @submit.prevent="handleSubmit">
          <div class="modal-header">
            <h5 class="modal-title text-center" id="formModalTitle">
              {{ this.isEdit ? "Upraviť umiestnenie" : "Pridať umiestnenie" }}
            </h5>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="placement">Umiestnenie</label>
              <input
                type="number"
                class="form-control"
                id="placement"
                v-model="formData.placement"
              />
            </div>
            <div class="form-group">
              <label for="games">Olympíjské hry</label>
              <select
                class="form-control"
                id="games"
                v-model="formData.gamesID"
              >
                <option value="soccer">Soccer</option>
                <option value="basketball">Basketball</option>
                <option value="tennis">Tennis</option>
              </select>
            </div>
            <div class="form-group">
              <label for="discipline">Disciplína</label>
              <input
                type="text"
                class="form-control"
                id="discipline"
                v-model="formData.discipline"
              />
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Close
            </button>
            <button type="submit" class="btn btn-primary">
              {{ this.isEdit ? "Uložiť" : "Pridať" }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    isEdit: {
      type: Boolean,
      required: true,
    },
    id: {
      type: Number,
      default: null,
    },
  },
  data() {
    return {
      formData: {
        personId: this.id,
        placement: 0,
        gamesID: 0,
        discipline: "",
      },
    };
  },
  created() {
    if (this.isEdit) {
      $.ajax({
        type: "GET",
        contentType: "application/json",
        url: `/getPlacement.php?id=${this.id}`,
      }).done((data) => {
        this.formData.placement = data.placement;
        this.formData.gamesID = data.gamesID;
        this.formData.discipline = data.discipline;
      });
    }
  },
  methods: {
    handleSubmit() {
      if (this.isEdit) {
        $.ajax({
          type: "POST",
          contentType: "application/json",
          url: `/editPlacement.php?id=${id}`,
          data: JSON.stringify(this.formData),
          dataType: "json",
        }).done((data) => {
          console.log("Placement edited!");
        });
      } else {
        $.ajax({
          type: "POST",
          contentType: "application/json",
          url: `/addPlacement.php`,
          data: JSON.stringify(this.formData),
          dataType: "json",
        }).done((data) => {
          console.log("Placement added!");
        });
      }
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
