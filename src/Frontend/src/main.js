import { createApp } from 'vue';
import { Vue3Lottie } from 'vue3-lottie';
import App from './App.vue';
import router from './router';
import ElementPlus from 'element-plus';
import './style.css';
import vuetify from './plugins/vuetify';
import 'element-plus/dist/index.css';
import { MotionPlugin } from '@vueuse/motion'; 
import 'leaflet/dist/leaflet.css';
import '@fortawesome/fontawesome-free/css/all.min.css';
import * as L from 'leaflet';
window.L = L 

const app = createApp(App);
app.component('Vue3Lottie', Vue3Lottie)
app.use(router);
app.use(ElementPlus);
app.use(vuetify)
app.use(MotionPlugin); 
app.mount('#app');