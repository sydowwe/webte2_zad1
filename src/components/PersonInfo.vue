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
            @input="this.validateTextField('name')"
            :class="{ 'is-invalid': invalidFields.includes('name') }"
            :required="!isEdit"
            />
          <div v-if="invalidFields.includes('name')" class="invalid-tooltip">
            Neplatné meno zadávajte len písmená alebo "-","."
          </div>
        </div>
        <div class="form-group">
          <label for="surname">Priezvisko</label>
          <input
            type="text"
            class="form-control"
            id="surname"
            v-model="formData.surname"
            @input="this.validateTextField('surname')"
            :class=" formData.surname!=='' ? (invalidFields.includes('surname') ? 'is-invalid' : 'is-valid') : '' "
            :required="!isEdit"
            />
          <div v-if="invalidFields.includes('surname')" class="invalid-tooltip">
            Neplatné priezvisko zadávajte len písmená alebo "-","."
          </div>
        </div>
        <div class="form-group">
          <label for="birthDay">Dátum narodenia</label>
          <input
            type="date"
            class="form-control"
            id="birthDay"
            v-model="formData.birthDay"
            @input="validateDate('birthDay')"
            :class="{ 'is-invalid': invalidFields.includes('birthDay') }"
            :required="!isEdit"
          />
          <div v-if="invalidFields.includes('birthDay')" class="invalid-tooltip">
            Neplatný dátum narodenia skontrolujte si rok
          </div>
        </div>
        <div class="form-group">
          <label for="birthPlace">Miesto narodenia</label>
          <input
            type="text"
            class="form-control"
            id="birthPlace"
            v-model="formData.birthPlace"
            @input="this.validateTextField('birthPlace')"
            :class="{ 'is-invalid': invalidFields.includes('birthPlace') }"
            :required="!isEdit"
            />
          <div v-if="invalidFields.includes('birthPlace')" class="invalid-tooltip">
            Neplatné mesto zadávajte len písmená alebo "-"
          </div>
        </div>
        <div class="form-group">
          <label for="birthCountry">Krajina narodenia</label>
          <input
            type="text"
            class="form-control"
            id="birthCountry"
            v-model="formData.birthCountry"
            @input="this.validateTextField('birthCountry')"
            :class="{ 'is-invalid': invalidFields.includes('birthCountry') }"
            :required="!isEdit"
            />
          <div v-if="invalidFields.includes('birthCountry')" class="invalid-tooltip">
            Neplatné krajina zadávajte len písmená alebo "-"
          </div>
        </div>
        <div class="form-group">
          <label for="deathDay">Dátum úmrtia</label>
          <input
            type="date"
            class="form-control"
            id="deathDay"
            v-model="formData.deathDay"
            @input="this.validateDate('deathDay')"
            :class="{ 'is-invalid': invalidFields.includes('deathDay') }"
          />
          <div v-if="invalidFields.includes('deathDay')" class="invalid-tooltip">
            Neplatný dátum úmrtia skontrolujte si rok
          </div>
        </div>
        <div class="form-group">
          <label for="deathPlace">Miesto úmrtia</label>
          <input
            type="text"
            class="form-control"
            id="deathPlace"
            v-model="formData.deathPlace"
            @input="this.validateTextField('deathPlace')"
            :class="{ 'is-invalid': invalidFields.includes('deathPlace') }"
            />
          <div v-if="invalidFields.includes('deathPlace')" class="invalid-tooltip">
            Neplatné mesto zadávajte len písmená alebo "-"
          </div>
        </div>
        <div class="form-group">
          <label for="deathCountry">Krajina úmrtia</label>
          <input
            type="text"
            class="form-control"
            id="deathCountry"
            v-model="formData.deathCountry"
            @input="this.validateTextField('deathCountry')"
            :class="{ 'is-invalid': invalidFields.includes('deathCountry') }"
            />
          <div v-if="invalidFields.includes('deathCountry')" class="invalid-tooltip">
            Neplatné krajina zadávajte len písmená alebo "-"
          </div>
        </div>
        <button type="submit" class="btn btn-primary">
          {{ this.isEdit ? "Uložiť" : "Pridať" }}
        </button>
      </form>
      <div
        class="modal fade"
        id="errorModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="errorModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="errorModalLabel">Chyba!</h5>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              {{ errorModalMessage }}
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-dismiss="modal"
              >
                Zavrieť
              </button>
            </div>
          </div>
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
          name: "",
          surname: "",
          birthDay: "",
          birthPlace: "",
          birthCountry: "",
          deathDay: "",
          deathPlace: "",
          deathCountry: "",
        },
        invalidFields: [""],
        errorModalMessage: "",
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
          this.formData.birthDay = data.birth_day;
          this.formData.birthPlace = data.birth_place;
          this.formData.birthCountry = data.birth_country;
          this.formData.deathDay = data.death_day;
          this.formData.deathPlace = data.death_place;
          this.formData.deathCountry = data.death_country;
        });
      }
    },
    methods: {
      checkFormValidity() {
        const invalidFieldsTexts = [];
        if (this.invalidFields.length > 0) {
          this.invalidFields.forEach((fieldId) => {
            const label = this.$el.querySelector(
              `label[for=${fieldId}]`
            ).textContent;
            invalidFieldsTexts.push(label);
          });
          this.errorModalMessage = `Nasledujúce polia sú neplatné: ${invalidFieldsTexts.join(
            ", "
          )}. Prosím, opravte ich.`;
          $("#errorModal").modal("show");
          return false;
        }
        return true;
      },
      handleSubmit() {
        if (this.checkFormValidity()) {
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
        }
      },
      validateDate(fieldId) {
        const fieldDate = new Date(this.formData[fieldId]);
        if (
          fieldDate.getFullYear() < 1800 ||
          fieldDate.getFullYear() > new Date().getFullYear()
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
      }
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
  