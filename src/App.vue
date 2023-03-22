<template>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <span class="navbar-brand">Olympic Games</span>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <router-link class="nav-link" to="/">Domov</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/all-people"
              >Všetci športovci</router-link
            >
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/add-person"
              >Pridať športovca</router-link
            >
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/login">Prihlásenie</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/register"
              >Registrácia</router-link
            >
          </li>
          <!-- <li class="nav-item">
            <router-link class="nav-link" to="/logout" hidden
              >Odhlásiť sa</router-link
            >
          </li> -->
        </ul>
      </div>
    </nav>
  </header>
  <div class="container-fluid">
    <router-view></router-view>
  </div>
</template>

<style scoped>
.container-fluid {
  min-height: 100vh;
  height: 100%;
  padding-top: 88px;
  display: flex;
  flex-direction: column;
  align-items: center;
  background-color: rgba(164, 158, 240, 0.5);
}
nav a.router-link-exact-active {
  color: hsla(160, 100%, 37%, 1);
}
nav a.router-link-exact-active:hover {
  background-color: transparent;
}

.navbar-brand {
  display: inline-block;
  padding-left: 1rem;
}
nav a {
  display: inline-block;
  padding-left: 1rem;
  border-left: 1px solid var(--color-border);
}

nav a:first-of-type {
  border: 0;
}
</style>