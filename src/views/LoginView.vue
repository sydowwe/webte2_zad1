<template>
  <div class="container">
    <h2 class="text-center mb-2">Prihláste sa</h2>
    <form @submit.prevent="handleSubmit" class="d-flex flex-column">
      <div class="form-group mb-2">
        <label class="form-label" for="login">Používateľské meno / Email</label>
        <input
          type="text"
          id="login"
          class="form-control form-control-lg"
          v-model="formData.login"
          data-required
        />
      </div>

      <div class="form-group mb-3">
        <label class="form-label" for="password">Heslo</label>
        <input
          type="password"
          id="password"
          class="form-control form-control-lg"
          v-model="formData.password"
          data-required
        />
      </div>

      <button type="submit" class="btn btn-success btn-lg mb-2">
        Prihlásiť
      </button>

      <div class="mb-2">
        Nemáte účet?
        <router-link to="/register">Registrovať</router-link>
      </div>

      <div class="divider d-flex align-items-center mb-3">
        <span class="text-center fw-bold mx-3 mb-0 text-muted">OR</span>
      </div>

      <a
        class="btn btn-primary btn-lg"
        href="/api/google.php?action=login"
        role="button"
      >
        Continue with Google
      </a>
    </form>
    <my-modal ref="myModal">
      <template v-slot:modal-body v-if="!isError && body">
        <verify-qr-code :personData="body" ref="verifyQrCode" :modalRef="modalRef"></verify-qr-code>
      </template>
      <template v-slot:modal-body v-else>
        {{ errorMessage }}
      </template>
      <template v-slot:modal-footer>
        <button type="button" class="btn btn-danger" @click="hideModal">
          Zavrieť
        </button>
        <button
          type="button"
          class="btn btn-success"
          v-if="!isError"
          @click="sumbitQR"
        >
          Odoslať
        </button>
      </template>
    </my-modal>
  </div>
</template>
<script>
import MyModal from "../components/MyModal.vue";
import VerifyQrCode from "../components/VerifyQrCode.vue";
export default {
  components: {
    MyModal,
    VerifyQrCode,
  },
  data() {
    return {
      modalRef: null,
      formData: {
        login: "",
        password: "",
      },
      isError: false,
      errorMessage: "",
      body: null
    };
  },
  mounted() {
    this.modalRef = this.$refs.myModal;
  },
  methods: {
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
      if (this.isError) {
        this.errorMessage = `Prosím, vyplňte nasledujúce polia: ${invalidFieldsTexts.join(
          ", "
        )}`;
        this.showModal("Chyba!");
        return false;
      }
      return true;
    },
    showModal(title) {
      this.$refs.myModal.title = title;
      this.$refs.myModal.showModal();
    },
    hideModal(){
      this.$refs.myModal.hideModal();
    },
    handleSubmit() {
      $.ajax({
        type: "POST",
        contentType: "application/json",
        url: "/zad1/api/login.php",
        data: JSON.stringify(this.formData),
        dataType: "json",
      })
        .done((data) => {
          this.isError = data.error;
          if (!this.isError) {
            this.body = data.body;
            this.showModal("Google authenticator");
          } else {
            this.errorMessage = data.body;
            this.showModal("Chyba!");
          }
        })
        .fail((error) => {
          console.log(error);
        });
    },
    sumbitQR() {
      const verifyQrCode = this.$refs.verifyQrCode;
      verifyQrCode.handleSubmit();
    },
  },
};
</script>
<style scoped>
.container {
  max-width: 500px;
}
.divider:after,
.divider:before {
  content: "";
  flex: 1;
  height: 1px;
  background: #eee;
}
</style>
