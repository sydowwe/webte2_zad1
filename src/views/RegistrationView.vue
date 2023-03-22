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
      <div class="form-group mb-3">
        <label for="repeat-password" class="form-label">Repeat Password</label>
        <input
          type="password"
          class="form-control"
          id="repeat-password"
          placeholder="Enter password again"
          v-model="formData.repeatPassword"
          data-required
        />
      </div>
      <button type="submit" class="btn btn-primary">Registrovať</button>
    </form>
    <my-modal ref="myModal">
      <template v-slot:modal-body v-if="!isError">
        <div class="d-flex flex-column align-items-center">
          <span id="qrPrompt">Scan QR code with google authentificator app: </span>
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
        <router-link class="btn btn-success" to="/login" v-if="!isError"
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
        repeatPassword: "",
      },
      qrcodeUrl: "",
      isError: false,
      errorMessage:""
    };
  },
  mounted(){
  $('router-link').on('click',() => {
    this.$refs.myModal.hideModal();
  });
  },
  methods: {
    handleSubmit() {
      $.ajax({
        type: "POST",
        contentType: "application/json",
        url: "/api/register.php",
        data: JSON.stringify(this.formData),
        dataType: "json",
      })
        .done((data) => {
          this.isError = data.error;
          if(!this.isError){
            this.qrcodeUrl = data.body;
            this.$refs.myModal.showModal();
          }
          else{
            this.errorMessage = `User with username: ${data.body.username} or email: ${data.body.email} already exists`;
            this.$refs.myModal.showModal();
          }          
        })
        .fail((error) => {
          console.log(error);
        });
    },
  },
};
</script>

<style scoped>
.container {
  max-width: 500px;
}
#qrPrompt{
  font-size: large;
}
</style>
