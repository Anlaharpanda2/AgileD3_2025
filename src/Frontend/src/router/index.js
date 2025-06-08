import { createRouter, createWebHistory } from 'vue-router';

import def from '../layouts/DefaultLayout.vue'
import def2 from '../layouts/DefaultLayout2.vue'
import FormImport from '../components/FormTambahDataPelatihan.vue'

// rute login
import LoginMasyarakat from '../views/Login/LoginMasyarakat.vue';
import LoginOperator from '../views/Login/LoginOperator.vue';
import LoginPegawai from '../views/Login/LoginPegawai.vue';

// rute pengelola data pendaftar
import DataPelatihanView from '../views/PengelolaDataPelatihan/DataPelatihanView.vue';
import DataPelatihanSampahView from '../views/PengelolaDataPelatihan/DataPelatihanSampahView.vue';

//rute pengelola data berita
import DataBeritaView from '../views/PengelolaDataBerita/DataBeritaView.vue';
import DataBeritaSampahView from '../views/PengelolaDataBerita/DataBeritaSampahView.vue';

import NotFound from '../views/NotFound.vue';

const routes = [
  {
    path:'/form',
    component : FormImport
  },
  {
    path:'/def',
    component : def
  },
  {
    path:'/def2',
    component : def2
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

  // halaman data pelatihan
  {
    path: '/data/pelatihan',
    name: 'DataPenlatihan',
    component: DataPelatihanView,
    meta: { requiresAuth: true }
  },
  {
    path: '/data/pelatihan/sampah',
    name: 'DataPenlatihanSampah',
    component: DataPelatihanSampahView,
    meta: { requiresAuth: true }
  },

  // halaman data berita
  {
    path: '/data/berita/sampah',
    name: 'DataBeritaSampah',
    component: DataBeritaSampahView,
    meta: { requiresAuth: true }
  },
  {
    path: '/data/berita',
    name: 'DataBerita',
    component: DataBeritaView,
    meta: { requiresAuth: true }
  },

  // halaman tidak ditemukan
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: NotFound
  }
];

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