// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'
import DataPendaftaranView from '../views/DataPendaftaranView.vue'
import HomeView from '../views/HomeView.vue'
import NotFound from '../views/NotFound.vue'
import LoginView from '../views/LoginView.vue'
import DaftarView from '../views/DaftarView.vue'
import RapidAPI from '../views/RapidAPI.vue'

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
    path: '/rapidapi',
    name: 'premierleague',
    component: RapidAPI
  },
  {
    path: '/Daftar',
    name: 'Daftar',
    component: DaftarView
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router