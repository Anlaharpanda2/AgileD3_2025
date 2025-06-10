import { createRouter, createWebHistory } from 'vue-router';

import def from '../layouts/DefaultLayout.vue'
import def2 from '../layouts/DefaultLayout2.vue'
import FormImport from '../components/FormTambahDataPelatihan.vue'

// rute login
import LoginMasyarakat from '../views/Login/LoginMasyarakat.vue';
import LoginOperator from '../views/Login/LoginOperator.vue';
import LoginPegawai from '../views/Login/LoginPegawai.vue';


import contoh from '../views/contohdata/contoh.vue';

// rute pengelola data pendaftar
import DataPelatihanView from '../views/PengelolaDataPelatihan/DataPelatihanView.vue';
import DataPelatihanSampahView from '../views/PengelolaDataPelatihan/DataPelatihanSampahView.vue';
import PesanView from '../views/PengelolaPesan/PesanView.vue';

import PrePostTestView from '../views/PengelolaPretestPostest/PrePostTestView.vue';

import NotFound from '../views/NotFound.vue';

const routes = [
  {
    path:'/contoh',
    component : contoh
  },
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
   {
    path:'/pesan',
    component : PesanView
  },


  {
    path: '/preposttest',
    name: 'PrePostTest',
    component: PrePostTestView
  },

  
  {
    path: '/kelolatest',
    name: 'KelolaTest',
    component: PrePostTestView
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