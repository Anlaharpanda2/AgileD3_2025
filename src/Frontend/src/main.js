import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import './style.css';
import { MotionPlugin } from '@vueuse/motion'; 
import 'leaflet/dist/leaflet.css';
import * as L from 'leaflet';
window.L = L 

const app = createApp(App);
app.use(router);
app.use(MotionPlugin); 
app.mount('#app');