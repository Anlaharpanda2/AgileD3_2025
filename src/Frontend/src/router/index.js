import { createRouter, createWebHistory } from 'vue-router';

import KelolaAksesView from '../views/KelolaAkses/KelolaAksesView.vue';
import def2 from '../layouts/DefaultLayout2.vue';
import FormSortingDataPelatihan from '../components/KelolaDataPelatihan/FormSortingDataPelatihan.vue';

// halaman home
import HomeView from '../views/Home/HomeView.vue';

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

//rute pengelola pelaporan pengaduan
import PelaporanPengaduan from '../views/PengelolaPelaporanPengaduan/PelaporanPengaduan.vue';
import StatusPengaduan from '../views/PengelolaPelaporanPengaduan/StatusPengaduan.vue';
import BuatPengaduanPage from '../views/PengelolaPelaporanPengaduan/BuatPengaduanPage.vue';

//rute pengelola data berita
import DataBeritaView from '../views/PengelolaDataBerita/DataBeritaView.vue';
import DataBeritaSampahView from '../views/PengelolaDataBerita/DataBeritaSampahView.vue';
//rute reset password
import OtpView from '../views/ResetPassword/OtpView.vue';
import ForgotView from '../views/ResetPassword/ForgotView.vue';
import ResetPassword from '../views/ResetPassword/ResetPassword.vue';

// rute pengelola data pelatihan
import DataPelatihanView from '../views/PengelolaDataPelatihan/DataPelatihanView.vue';
import DataPelatihanSampahView from '../views/PengelolaDataPelatihan/DataPelatihanSampahView.vue';
import DataPendaftaranView from '../views/PengelolaDataPendaftaran/DataPendaftaranView.vue';

import NotFound from '../views/NotFound.vue';
import Unauthorized from '../views/Unauthorized.vue'; // Anda perlu membuat ini

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
  // halaman pelaporan pengaduan
  {
    path: '/pengaduan',
    name: 'PelaporanPengaduan',
    component: PelaporanPengaduan
  },
  
  {
  path: '/pengaduan/status',
  name: 'StatusPengaduan',
  component: StatusPengaduan
  },

  {
  path: '/pengaduan/buat',
  name: 'BuatPengaduan',
  component: BuatPengaduanPage
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
  },
  {path: '/',component: HomeView},
  {path: '/form',component: FormSortingDataPelatihan},
  {path: '/kelola/akses',component: KelolaAksesView},
  {path: '/def2',component: def2},
  {path: '/login/masyarakat',name: 'LoginMasyarakat',component: LoginMasyarakat},
  {path: '/login/pegawai',name: 'LoginPegawai',component: LoginPegawai},
  {path: '/login/operator',name: 'LoginOperator',component: LoginOperator},
  {path: '/reset/otp',name: 'resetOperatorOtp',component: OtpView},
  {path: '/reset/forgot',name: 'resetOperatorForgot',component: ForgotView},
  {path: '/reset/password',name: 'resetOperatorPassword',component: ResetPassword},
  {path: '/data/pelatihan',name: 'DataPelatihan',component: DataPelatihanView,meta: { requiresAuth: true, role: 'operator' }},
  {path: '/data/Pendaftaran',name: 'DataPendaftaran',component: DataPendaftaranView,meta: { requiresAuth: true, role: 'operator' }},
  {path: '/data/pelatihan/sampah',name: 'DataPelatihanSampah',component: DataPelatihanSampahView,meta: { requiresAuth: true}},
  {path: '/unauthorized',name: 'Unauthorized',component: Unauthorized},
  {path: '/:pathMatch(.*)*',name: 'NotFound',component: NotFound}
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

router.beforeEach((to, from, next) => {
  const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
  const userRole = localStorage.getItem('role');

  if (to.meta.requiresAuth) {
    if (!isLoggedIn) {
      next({ path: '/login/masyarakat' });
    } else if (to.meta.role && to.meta.role !== userRole) {
      next({ path: '/unauthorized' });
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router;
