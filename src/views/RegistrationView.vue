<template>
  <div class="container">
    <h2 class="text-center mb-2">Registrujte sa</h2>
    <form @submit.prevent="handleSubmit" class="d-flex flex-column">
      <div class="form-group mb-2">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" placeholder="Enter name" v-model="name">
      </div>
      <div class="form-group mb-2">
        <label for="surname" class="form-label">Surname</label>
        <input type="text" class="form-control" id="surname" placeholder="Enter surname" v-model="surname">
      </div>
      <div class="form-group mb-2">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" placeholder="Enter username" v-model="username">
      </div>
      <div class="form-group mb-2">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" placeholder="Enter email" v-model="email">
      </div>
      <div class="form-group mb-2">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Enter password" v-model="password">
      </div>
      <div class="form-group mb-3">
        <label for="repeat-password" class="form-label">Repeat Password</label>
        <input type="password" class="form-control" id="repeat-password" placeholder="Enter password again" v-model="repeatPassword">
      </div>
      <button type="submit" class="btn btn-primary">Registrovať</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: '',
      surname: '',
      username: '',
      email: '',
      password: '',
      repeatPassword: '',
    }
  }
}
</script>

<style scoped>
.container {
  max-width: 500px;
}
</style>
