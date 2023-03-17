<template>
  <form @submit.prevent="handleSubmit">
    <div class="form-group">
      <label class="form-label" for="login"
        >Používateľské meno / Email</label
      >
      <input
        type="text"
        id="login"
        class="form-control form-control-lg"
        v-model="login"
      />
    </div>

    <div class="form-group">
      <label class="form-label" for="password">Heslo</label>
      <input
        type="password"
        id="password"
        class="form-control form-control-lg"
        v-model="password"
      />
    </div>
    <button
      type="submit"
      class="btn btn-success btn-lg"
    >
      Prihlásiť
    </button>

    <hr>

    <a
      class="btn btn-primary btn-lg"
      href="https://site215.webte.fei.stuba.sk/zad1/api/google.php?action=login"
      role="button"
    >
      Continue with Google
    </a>
  </form>
</template>
<script>
export default {
  data() {
    return {
      login: '',
      password: ''
    };
  },
  created() {
    
  },
  methods: {
    handleSubmit(){

    }
  },
};
</script>
<style scoped>
.container {
  max-width: 500px;
}
</style>
