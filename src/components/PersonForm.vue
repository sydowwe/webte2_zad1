<template>
  <div>
    <form @submit.prevent="handleSubmit">
      <div class="form-group">
        <label for="name">Meno</label>
        <input
          type="text"
          class="form-control"
          id="name"
          v-model="formData.name"
        />
      </div>
      <div class="form-group">
        <label for="surname">Priezvisko</label>
        <input
          type="text"
          class="form-control"
          id="surname"
          v-model="formData.surname"
        />
      </div>
      <div class="form-group">
        <label for="type">Typ</label>
        <select class="form-control" id="type" v-model="formData.type">
          <option value="zoh">ZOH</option>
          <option value="loh">LOH</option>
        </select>
      </div>
      <div class="form-group">
        <label for="year">Rok</label>
        <input
          type="number"
          class="form-control"
          id="year"
          v-model="formData.year"
        />
      </div>
      <div class="form-group">
        <label for="city">Mesto</label>
        <input
          type="text"
          class="form-control"
          id="city"
          v-model="formData.city"
        />
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
      <button type="submit" class="btn btn-primary">
        {{ this.isEdit ? "Uložiť" : "Pridať" }}
      </button>
    </form>
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
        name: "",
        surname: "",
        type: "",
        year: "",
        city: "",
        discipline: "",
      },
    };
  },
  created() {
    if (this.isEdit) {
      $.ajax({
        type: "GET",
        contentType: "application/json",
        url: `/getPerson.php?id=${this.id}`,
      }).done((data) => {
        this.formData.name = data.name;
        this.formData.surname = data.surname;
        this.formData.type = data.type;
        this.formData.year = data.year;
        this.formData.city = data.city;
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
          url: `/editPerson.php?id=${id}`,
          data: JSON.stringify(this.formData),
          dataType: "json",
        }).done((data) => {
          console.log("User edited!");
        });
      } else {
        $.ajax({
          type: "POST",
          contentType: "application/json",
          url: `/addPerson.php`,
          data: JSON.stringify(this.formData),
          dataType: "json",
        }).done((data) => {
          console.log("User added!");
        });
      }
    },
  },
  watch: {
    isEdit(newVal, oldVal) {
      if (newVal === false) {
        this.formData.name = "";
        this.formData.surname = "";
        this.formData.type = "";
        this.formData.year = "";
        this.formData.city = "";
        this.formData.discipline = "";
      }
    },
  },
};
</script>
