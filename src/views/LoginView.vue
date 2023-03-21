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
          v-model="login"
        />
      </div>

      <div class="form-group mb-3">
        <label class="form-label" for="password">Heslo</label>
        <input
          type="password"
          id="password"
          class="form-control form-control-lg"
          v-model="password"
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
  </div>
</template>
<script>
export default {
  data() {
    return {
      login: "",
      password: "",
    };
  },
  created() {},
  methods: {
    handleSubmit() {},
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
