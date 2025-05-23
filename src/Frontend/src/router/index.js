import { createRouter, createWebHistory } from 'vue-router';
import LoginMasyarakat from '../views/Login/LoginMasyarakat.vue';
import LoginOperator from '../views/Login/LoginOperator.vue';
import LoginPegawai from '../views/Login/LoginPegawai.vue';
import Home from '../views/Home/HomeView.vue';
import DataPendaftarView from '../views/DataPendaftar/DataPendaftarView.vue';
import NotFound from '../views/NotFound.vue';

import HomeView from '../views/HomeView.vue'
import DataPendaftaranView from '../views/DataPendaftaranView.vue'
import TambahPesertaView from '../views/TambahPesertaView.vue'
import LoginView from '../views/LoginView.vue'
import NotFound from '../views/NotFound.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/login/masyarakat',
    name: 'LoginMasyarakat',
    component: LoginMasyarakat
  },
  {
    path: '/login/pegawai',
    name: 'LoginPegawai',
    component: LoginPegawai
  },
  {
    path: '/login/operator',
    name: 'LoginOperator',
    component: LoginOperator
  },
  {
    path: '/data/pendaftar',
    name: 'DataPendaftar',
    component: DataPendaftarView,
    meta: { requiresAuth: true }
  },
  {
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
];

// Buat dan export router
const router = createRouter({
  history: createWebHistory(),
  routes
});
router.beforeEach((to, from, next) => {
  const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
  if (to.meta.requiresAuth && !isLoggedIn) {
    next({ path: '/login/masyarakat' });
  } else {
    next();
  }
});

export default router;
