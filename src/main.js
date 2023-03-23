import { createApp } from 'vue'
// import $ from "jquery";
// window.jQuery = $;
// window.$ = $;
// import "bootstrap";
// import "datatables.net";
// import "datatables.net-bs5";
// import 'select2';

import App from './App.vue'
import router from './router'
import './assets/main.css'

const app = createApp(App)

app.use(router)


app.mount('#app')