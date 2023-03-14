import { createApp } from 'vue'
import { createPinia } from 'pinia'
import $ from "jquery";
import "bootstrap";
import "datatables.net";
import "datatables.net-bs5";

import App from './App.vue'
import router from './router'

import './assets/main.css'

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.mount('#app')
