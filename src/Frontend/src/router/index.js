// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'
import DataPendaftaranView from '../views/DataPendaftaranView.vue'
import HomeView from '../views/HomeView.vue'
import NotFound from '../views/NotFound.vue'

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
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router