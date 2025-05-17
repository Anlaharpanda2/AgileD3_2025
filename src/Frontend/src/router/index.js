// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'
import DataPendaftaranView from '../views/DataPendaftaranView.vue'
import HomeView from '../views/HomeView.vue'
import NotFound from '../views/NotFound.vue'
import LoginView from '../views/LoginView.vue'
import VaniaView from '../views/vaniaView.vue'
import DataPendaftaran from '../views/PendaftaranBaru/DataPendaftaran.vue';
import DataSampah from '../views/PendaftaranBaru/DataSampah.vue'

const routes = [
  {
    path: '/Pendaftaran',
    name: 'Pendaftaran',
    component: DataPendaftaranView
  },
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: NotFound
  },
  {
    path: '/login',
    name: 'login',
    component: LoginView
  },
  {
    path: '/anla',
    name: 'vania',
    component: VaniaView
  },
  {
    path: '/hapusedit',
    name: 'hapusedit',
    component: DataPendaftaran
  },
  {
  path: '/pendaftaran/terhapus',
  name: 'DataSampah',
  component: DataSampah
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
