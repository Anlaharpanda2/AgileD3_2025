import { createApp } from 'vue'
import { Vue3Lottie } from 'vue3-lottie';
import App from './App.vue';
import router from './router';
import ElementPlus from 'element-plus'; 
import vuetify from './plugins/vuetify';
import 'element-plus/dist/index.css'; 
import './assets/style.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';


const app = createApp(App);

app.component('Vue3Lottie', Vue3Lottie)
app.use(router);
app.use(ElementPlus);
app.use(vuetify);
app.mount('#app');