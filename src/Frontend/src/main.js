// src/main.js
import { createApp } from 'vue'
import App from './App.vue';
import router from './router';
import ElementPlus from 'element-plus';      // Import Element Plus
import 'element-plus/dist/index.css'; // Import Element Plus CSS

const app = createApp(App);
app.use(router);
app.use(ElementPlus); // Gunakan Element Plus
app.mount('#app');
   



createApp(App).use(router).mount('#app')

