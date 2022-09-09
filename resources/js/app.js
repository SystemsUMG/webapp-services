import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import axios from 'axios';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import VueLoading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

window.axios = axios

const token = localStorage.getItem('token')
axios.defaults.baseURL = '/api/'
if (token){
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
}

const app = createApp(App)

app.use(router);
app.use(VueSweetalert2);
app.use(VueLoading);

app.mount('#app');