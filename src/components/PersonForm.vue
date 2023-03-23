<template>
  <div class="container">
    <h3 class="text-center">{{ formData.name }} {{ formData.surname }}</h3>
    <form @submit.prevent="handleSubmit">
      <div class="form-group mb-2">
        <label for="name">Meno</label>
        <input
          type="text"
          class="form-control"
          id="name"
          v-model="formData.name"
          @input="this.validateTextField('name')"
          :class="
            formData.name !== ''
              ? invalidFields.includes('name')
                ? 'is-invalid'
                : 'is-valid'
              : ''
          "
          data-required
        />
        <div v-if="invalidFields.includes('name')" class="invalid-tooltip">
          Neplatné meno zadávajte len písmená alebo "-","."
        </div>
      </div>
      <div class="form-group mb-2">
        <label for="surname">Priezvisko</label>
        <input
          type="text"
          class="form-control"
          id="surname"
          v-model="formData.surname"
          @input="this.validateTextField('surname')"
          :class="
            formData.surname !== ''
              ? invalidFields.includes('surname')
                ? 'is-invalid'
                : 'is-valid'
              : ''
          "
          data-required
        />
        <div v-if="invalidFields.includes('surname')" class="invalid-tooltip">
          Neplatné priezvisko zadávajte len písmená alebo "-","."
        </div>
      </div>
      <div class="form-group mb-2">
        <label for="birthDay">Dátum narodenia</label>
        <input
          type="date"
          class="form-control"
          id="birthDay"
          v-model="formData.birthDay"
          @input="validateDate('birthDay')"
          :class="
            formData.birthDay !== ''
              ? invalidFields.includes('birthDay')
                ? 'is-invalid'
                : 'is-valid'
              : ''
          "
          data-required
        />
        <div v-if="invalidFields.includes('birthDay')" class="invalid-tooltip">
          Neplatný dátum narodenia skontrolujte si rok
        </div>
      </div>
      <div class="form-group mb-2">
        <label for="birthPlace">Miesto narodenia</label>
        <input
          type="text"
          class="form-control"
          id="birthPlace"
          v-model="formData.birthPlace"
          @input="this.validateTextField('birthPlace')"
          :class="
            formData.birthPlace !== ''
              ? invalidFields.includes('birthPlace')
                ? 'is-invalid'
                : 'is-valid'
              : ''
          "
          data-required
        />
        <div
          v-if="invalidFields.includes('birthPlace')"
          class="invalid-tooltip"
        >
          Neplatné mesto zadávajte len písmená alebo "-"
        </div>
      </div>
      <div class="form-group mb-2">
        <label for="birthCountry">Krajina narodenia</label>
        <input
          type="text"
          class="form-control"
          id="birthCountry"
          v-model="formData.birthCountry"
          @input="this.validateTextField('birthCountry')"
          :class="
            formData.birthCountry !== ''
              ? invalidFields.includes('birthCountry')
                ? 'is-invalid'
                : 'is-valid'
              : ''
          "
          data-required
        />
        <div
          v-if="invalidFields.includes('birthCountry')"
          class="invalid-tooltip"
        >
          Neplatné krajina zadávajte len písmená alebo "-"
        </div>
      </div>

      <div class="form-group mb-2">
        <label for="deathDay">Dátum úmrtia</label>
        <input
          type="date"
          class="form-control"
          id="deathDay"
          v-model="formData.deathDay"
          @input="this.validateDate('deathDay')"
          :class="
            formData.deathDay !== ''
              ? invalidFields.includes('deathDay')
                ? 'is-invalid'
                : 'is-valid'
              : ''
          "
        />
        <div v-if="invalidFields.includes('deathDay')" class="invalid-tooltip">
          Neplatný dátum úmrtia skontrolujte si rok
        </div>
      </div>
      <div class="form-group mb-2">
        <label for="deathPlace">Miesto úmrtia</label>
        <input
          type="text"
          class="form-control"
          id="deathPlace"
          v-model="formData.deathPlace"
          @input="this.validateTextField('deathPlace')"
          :class="
            formData.deathPlace !== ''
              ? invalidFields.includes('deathPlace')
                ? 'is-invalid'
                : 'is-valid'
              : ''
          "
        />
        <div
          v-if="invalidFields.includes('deathPlace')"
          class="invalid-tooltip"
        >
          Neplatné mesto zadávajte len písmená alebo "-"
        </div>
      </div>
      <div class="form-group mb-3">
        <label for="deathCountry">Krajina úmrtia</label>
        <input
          type="text"
          class="form-control"
          id="deathCountry"
          v-model="formData.deathCountry"
          @input="this.validateTextField('deathCountry')"
          :class="
            formData.deathCountry !== ''
              ? invalidFields.includes('deathCountry')
                ? 'is-invalid'
                : 'is-valid'
              : ''
          "
        />
        <div
          v-if="invalidFields.includes('deathCountry')"
          class="invalid-tooltip"
        >
          Neplatné krajina zadávajte len písmená alebo "-"
        </div>
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-primary w-100">
          {{ this.isEdit ? "Uložiť" : "Pridať" }}
        </button>
      </div>
    </form>
    <my-modal ref="myModal">
      <template v-slot:modal-body>
        {{ errorModalMessage }}
      </template>
      <template v-slot:modal-footer>
        <button type="button" class="btn btn-danger" @click="hideModal">
          Zavrieť
        </button>
      </template>
    </my-modal>
  </div>
</template>

<script>
import MyModal from "./MyModal.vue";
export default {
  components: {
    MyModal,
  },
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
        name: "",
        surname: "",
        birthDay: "",
        birthPlace: "",
        birthCountry: "",
        deathDay: "",
        deathPlace: "",
        deathCountry: "",
      },
      invalidFields: [],
      errorModalMessage: "",
    };
  },
  created() {
    if (this.isEdit) {
      $.ajax({
        type: "GET",
        contentType: "application/json",
        url: `/zad1/api/getPerson.php?id=${this.id}`,
      }).done((data) => {
        this.formData.name = data.name;
        this.formData.surname = data.surname;
        this.formData.birthDay = data.birth_day;
        this.formData.birthPlace = data.birth_place;
        this.formData.birthCountry = data.birth_country;
        this.formData.deathDay = data.death_day ?? "";
        this.formData.deathPlace = data.death_place ?? "";
        this.formData.deathCountry = data.death_country ?? "";
      });
    }
  },
  methods: {
    showModal(title) {
      this.$refs.myModal.title = title;
      this.$refs.myModal.showModal();
    },
    hideModal(){
      this.$refs.myModal.hideModal();
    },
    checkFormValidity() {
      const invalidFieldsTexts = [];
      let hasInvalidFields = false;

      this.$el.querySelectorAll("[data-required]").forEach((field) => {
        if (!field.value.trim()) {
          const label = this.$el.querySelector(
            `label[for=${field.id}]`
          ).textContent;
          invalidFieldsTexts.push(label);
          hasInvalidFields = true;
        }
      });

      if (this.invalidFields.length > 0) {
        this.invalidFields.forEach((fieldId) => {
          console.log(fieldId);
          const label = this.$el.querySelector(
            `label[for=${fieldId}]`
          ).textContent;
          invalidFieldsTexts.push(label);
          hasInvalidFields = true;
        });
      }

      if (hasInvalidFields) {
        this.errorModalMessage = `Nasledujúce polia sú neplatné: ${invalidFieldsTexts.join(
          ", "
        )}. Prosím, opravte ich.`;
        this.showModal("Chyba!");
        return false;
      }
      return true;
    },
    handleSubmit() {
      if (this.checkFormValidity()) {
        let myUrl = this.isEdit
          ? `/zad1/api/editPerson.php?id=${this.id}`
          : `/zad1/api/addPerson.php`;
        $.ajax({
          type: "POST",
          contentType: "application/json",
          url: myUrl,
          data: JSON.stringify(this.formData),
          dataType: "json",
        })
          .done((id) => {
            if (id == "edit") {
              this.errorModalMessage = `Používateľ bol upravený`;
              this.showModal("Hotovo");
            } else {
              this.$router.push({ name: "edit-person", params: { id: id } });
            }
          })
          .fail((error) => {
            console.log(error);
            this.errorModalMessage = `Používateľ už existuje`;
            this.showModal("Chyba!");
          });


          $.ajax({
          type: "POST",
          contentType: "application/json",
          url: '/zad1/api/addAdminLog.php',
          data: JSON.stringify({
            "operation": this.isEdit ? "edit" : "add",
            "table": "People",
            "recordId": this.id 
          }),
          dataType: "json",
        })
        .done(data => {    
          console.log(data);      
        })
      }
    },
    validateDate(fieldId) {
      const fieldDate = new Date(this.formData[fieldId]);
      if (
        fieldDate.getFullYear() < 1800 ||
        fieldDate > new Date() ||
        new Date($("#deathDay").val()) < new Date($("#birthDay").val())
      ) {
        if (!this.invalidFields.includes(fieldId)) {
          this.invalidFields.push(fieldId);
        }
      } else {
        const index = this.invalidFields.indexOf(fieldId);
        if (index > -1) {
          this.invalidFields.splice(index, 1);
        }
      }
    },
    validateTextField(fieldId) {
      const fieldValue = this.formData[fieldId];
      const regex = /^[A-Za-z]+([ -.]?[A-Za-z]+)*$/;
      if (!regex.test(fieldValue)) {
        if (!this.invalidFields.includes(fieldId)) {
          this.invalidFields.push(fieldId);
        }
      } else {
        const index = this.invalidFields.indexOf(fieldId);
        if (index !== -1) {
          this.invalidFields.splice(index, 1);
        }
      }
    },
  },
  watch: {
    isEdit(newVal, oldVal) {
      if (newVal === false) {
        this.formData.name = "";
        this.formData.surname = "";
        this.formData.birthDay = "";
        this.formData.birthPlace = "";
        this.formData.birthCountry = "";
        this.formData.deathDay = "";
        this.formData.deathPlace = "";
        this.formData.deathCountry = "";
      }
    },
  },
};
</script>
<style scoped>
.container {
  max-width: 500px;
}
.form-check-label {
  font-size: 1.2em; /* Increase label font size */
  margin-left: 10px; /* Add some space between label and checkbox */
}

.form-check-input[type="checkbox"] {
  width: 1.5em; /* Increase checkbox width */
  height: 1.5em; /* Increase checkbox height */
}
</style>
