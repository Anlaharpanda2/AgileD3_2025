// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'
import DataPendaftaranView from '../views/DataPendaftaranView.vue'
import HomeView from '../views/HomeView.vue'
import NotFound from '../views/NotFound.vue'
import LoginView from '../views/LoginView.vue'
import VaniaView from '../views/VaniaView.vue'
import baru from '../views/baru.vue'
import HapusPendaftarView from '../views/HapusPendaftarView.vue'

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
    path: '/vania',
    name: 'vania',
    component: VaniaView
  },
  {
    path: '/baru',
    name: 'terserah',
    component: baru
  },
  {
    path: '/HapusPendaftarView',
    name: 'hapus',
    component: HapusPendaftarView
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router