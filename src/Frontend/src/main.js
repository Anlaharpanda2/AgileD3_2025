import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import './style.css';
import { MotionPlugin } from '@vueuse/motion'; 
import 'leaflet/dist/leaflet.css';
import * as L from 'leaflet';
window.L = L;

// Import gaya dasar Element Plus dan gaya komponen programatik secara manual
import 'element-plus/theme-chalk/base.css';
import 'element-plus/theme-chalk/el-message-box.css';
import 'element-plus/theme-chalk/el-notification.css';

const app = createApp(App);
app.use(router);
app.use(MotionPlugin);
app.mount('#app');