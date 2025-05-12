// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'

import DataPendaftaranView from '../views/DataPendaftaran/DataPendaftaranView.vue'
import HomeView from '../views/HomeView.vue'
import NotFound from '../views/NotFound.vue'
import LoginView from '../views/LoginView.vue'
import NadyaView from '../views/NadyaView.vue'
import EksporPendaftar from '../views/ekspor/EksporPendaftar.vue'
import ImporPendaftar from '../views/impor/ImporPendaftar.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/pendaftaran',
    name: 'pendaftaran',
    component: DataPendaftaranView
  },
  {
    path: '/login',
    name: 'login',
    component: LoginView
  },
  {
    path: '/nadya',
    name: 'nadya',
    component: NadyaView
  },
  {
    path: '/pendaftar/ekspor',
    name: 'ekspor',
    component: EksporPendaftar
  },
  {
    path: '/pendaftar/impor',
    name: 'impor',
    component: ImporPendaftar
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: NotFound
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
