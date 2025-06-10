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

//rute reset password
import OtpView from '../views/ResetPassword/OtpView.vue';
import ForgotView from '../views/ResetPassword/ForgotView.vue';
import ResetPassword from '../views/ResetPassword/ResetPassword.vue';

// rute pengelola data pendaftar
import DataPelatihanView from '../views/PengelolaDataPelatihan/DataPelatihanView.vue';
import DataPelatihanSampahView from '../views/PengelolaDataPelatihan/DataPelatihanSampahView.vue';

import NotFound from '../views/NotFound.vue';
import Unauthorized from '../views/Unauthorized.vue'; // Anda perlu membuat ini

const routes = [
  {path: '/home',component: HomeView},
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
