<template>
  <div class="container">
    <h2 class="text-center mb-2">Registrujte sa</h2>
    <form @submit.prevent="handleSubmit" class="d-flex flex-column">
      <div class="form-group mb-2">
        <label for="name" class="form-label">Name</label>
        <input
          type="text"
          class="form-control"
          id="name"
          placeholder="Enter name"
          v-model="formData.name"
          @input="validateTextField"
          data-required
        />
      </div>
      <div class="form-group mb-2">
        <label for="surname" class="form-label">Surname</label>
        <input
          type="text"
          class="form-control"
          id="surname"
          placeholder="Enter surname"
          v-model="formData.surname"
          @input="validateTextField"
          data-required
        />
      </div>
      <div class="form-group mb-2">
        <label for="username" class="form-label">Username</label>
        <input
          type="text"
          class="form-control"
          id="username"
          placeholder="Enter username"
          v-model="formData.username"
          data-required
        />
      </div>
      <div class="form-group mb-2">
        <label for="email" class="form-label">Email</label>
        <input
          type="email"
          class="form-control"
          id="email"
          placeholder="Enter email"
          v-model="formData.email"
          @input="validateEmail"
          data-required
        />
      </div>
      <div class="form-group mb-2">
        <label for="password" class="form-label">Password</label>
        <input
          type="password"
          class="form-control"
          id="password"
          placeholder="Enter password"
          v-model="formData.password"
          data-required
        />
      </div>
      <!-- <div class="form-group mb-3">
        <label for="repeat-password" class="form-label">Repeat Password</label>
        <input
          type="password"
          class="form-control"
          id="repeat-password"
          placeholder="Enter password again"
          v-model="formData.repeatPassword"
          data-required
        />
      </div> -->
      <button type="submit" class="btn btn-primary">Registrovať</button>
    </form>
    <my-modal ref="myModal">
      <template v-slot:modal-body v-if="!isError">
        <div class="d-flex flex-column align-items-center">
          <span id="qrPrompt"
            >Scan QR code with google authentificator app:
          </span>
          <img :src="qrcodeUrl" alt="qr code for 2fa" />
        </div>
      </template>
      <template v-slot:modal-body v-else>
        {{ errorMessage }}
      </template>
      <template v-slot:modal-footer>
        <button type="button" class="btn btn-danger" @click="hideModal">
          Zavrieť
        </button>
        <router-link
          id="redirect"
          class="btn btn-success"
          to="/login"
          v-if="!isError"
          >Prejsť na prihlásenie</router-link
        >
      </template>
    </my-modal>
  </div>
</template>

<script>
import MyModal from "../components/MyModal.vue";
export default {
  components: {
    MyModal,
  },
  data() {
    return {
      formData: {
        name: "",
        surname: "",
        username: "",
        email: "",
        password: "",
        // repeatPassword: "",
      },
      qrcodeUrl: "",
      isError: false,
      errorMessage: "",
      invalidFields: []
    };
  },
  mounted() {
    $("#redirect").on("click", () => {
      this.$refs.myModal.hideModal();
    });
  },
  methods: {
    showModal(title) {
      this.$refs.myModal.title = title;
      this.$refs.myModal.showModal();
    },
    hideModal(){
      this.$refs.myModal.hideModal();
    },
    handleSubmit() {
      if (this.checkFormValidity()) {
        $.ajax({
          type: "POST",
          contentType: "application/json",
          url: "/api/register.php",
          data: JSON.stringify(this.formData),
          dataType: "json",
        })
          .done((data) => {
            this.isError = data.error;
            if (!this.isError) {
              this.qrcodeUrl = data.body;
              this.showModal("QR Code");
            } else {
              this.errorMessage = `User with username: ${data.body.username} or email: ${data.body.email} already exists`;
              this.showModal("Chyba!");
            }
          })
          .fail((error) => {
            console.log(error);
          });
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
    validateEmail(fieldId) {
      const fieldValue = this.formData[fieldId];
      const regex = /^\w{2,}([.-]?\w+)@\w+([.-]?\w+)(.\w{2,4})+$/;
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
    checkFormValidity() {
      const invalidFieldsTexts = [];
      this.$el.querySelectorAll("[data-required]").forEach((field) => {
        if (!field.value.trim()) {
          const label = this.$el.querySelector(
            `label[for=${field.id}]`
          ).textContent;
          invalidFieldsTexts.push(label);
          this.isError = true;
        }
      });

      if (this.invalidFields.length > 0) {
        this.invalidFields.forEach((fieldId) => {
          console.log(fieldId);
          const label = this.$el.querySelector(
            `label[for=${fieldId}]`
          ).textContent;
          invalidFieldsTexts.push(label);
          this.isError = true;
        });
      }

      if (this.isError) {
        this.errorModalMessage = `Nasledujúce polia sú neplatné: ${invalidFieldsTexts.join(
          ", "
        )}. Prosím, opravte ich.`;
        this.showModal("Chyba!");
        return false;
      }
      return true;
    },
  },
};
</script>

<style scoped>
.container {
  max-width: 500px;
}
#qrPrompt {
  font-size: large;
}
</style>
