// src/main.js
import { createApp } from 'vue'
import App from './App.vue'
import router from './router' // <- ini penting

createApp(App).use(router).mount('#app')
