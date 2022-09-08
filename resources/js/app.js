import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import axios from 'axios';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import VueLoading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

window.axios = axios
axios.defaults.baseURL = '/api/'

const app = createApp(App)

app.use(router);
app.use(VueSweetalert2);
app.use(VueLoading);

app.mount('#app');