// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'
import DataPendaftaranView from '../views/Pendaftar/DataPendaftaranView.vue'
import HomeView from '../views/HomeView.vue'
import DataPendaftaranView from '../views/DataPendaftaranView.vue'
import TambahPesertaView from '../views/TambahPesertaView.vue'
import LoginView from '../views/LoginView.vue'
import VaniaView from '../views/vaniaView.vue'
import DataPendaftaran from '../views/PendaftaranBaru/DataPendaftaran.vue';
import DataSampah from '../views/PendaftaranBaru/DataSampah.vue'

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

export default router
