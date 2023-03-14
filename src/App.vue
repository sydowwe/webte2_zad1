<template>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <router-link class="nav-link" to="/">Domov<span class="sr-only">(current)</span></router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/add-person">Pridať športovca</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/login">Prihlásenie</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/register">Registrácia</router-link>
                </li>
            </ul>
        </div>
    </nav>
  </header>
  <router-view class="container-fluid"></router-view>
</template>

<style scoped>

nav a.router-link-exact-active {
  color: var(--color-text);
}
nav a.router-link-exact-active:hover {
  background-color: transparent;
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