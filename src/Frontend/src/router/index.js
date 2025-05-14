// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'

// Import semua halaman (views)
import HomeView from '../views/HomeView.vue'
import DataPendaftaranView from '../views/DataPendaftaranView.vue'
import TambahPesertaView from '../views/TambahPesertaView.vue'
import LoginView from '../views/LoginView.vue'
import NotFound from '../views/NotFound.vue'

// Daftar rute
const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/peserta',
    name: 'Peserta',
    component: DataPendaftaranView
  },
  {
    path: '/tambah',
    name: 'TambahPeserta',
    component: TambahPesertaView
  },
  {
    path: '/login',
    name: 'Login',
    component: LoginView
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: NotFound
  }
]

// Buat dan export router
const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
