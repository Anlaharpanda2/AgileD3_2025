import { createRouter, createWebHistory } from 'vue-router';
import KelolaAksesView from '../views/KelolaAkses/KelolaAksesView.vue';
import def2 from '../layouts/DefaultLayout2.vue';
import FormSortingDataPelatihan from '../components/KelolaDataPelatihan/FormSortingDataPelatihan.vue';
import HomeView from '../views/Home/HomeView.vue';
import LoginMasyarakat from '../views/Login/LoginMasyarakat.vue';
import LoginOperator from '../views/Login/LoginOperator.vue';
import LoginPegawai from '../views/Login/LoginPegawai.vue';
import DataPelatihanView from '../views/PengelolaDataPelatihan/DataPelatihanView.vue';
import DataPelatihanSampahView from '../views/PengelolaDataPelatihan/DataPelatihanSampahView.vue';
import PrePostTestView from '../views/PengelolaPretestPostest/PrePostTestView.vue';
import PelaporanPengaduan from '../views/PengelolaPelaporanPengaduan/PelaporanPengaduan.vue';
import StatusPengaduan from '../views/PengelolaPelaporanPengaduan/StatusPengaduan.vue';
import BuatPengaduanPage from '../views/PengelolaPelaporanPengaduan/BuatPengaduanPage.vue';
import DataBeritaView from '../views/PengelolaDataBerita/DataBeritaView.vue';
import DataBeritaSampahView from '../views/PengelolaDataBerita/DataBeritaSampahView.vue';
import OtpView from '../views/ResetPassword/OtpView.vue';
import ForgotView from '../views/ResetPassword/ForgotView.vue';
import ResetPassword from '../views/ResetPassword/ResetPassword.vue';
import DataPendaftaranView from '../views/PengelolaDataPendaftaran/DataPendaftaranView.vue';
import NotFound from '../views/NotFound.vue';
import Unauthorized from '../views/Unauthorized.vue';
import DaftarMasyarakatView from '../views/DaftarMasyarakat/DaftarMasyarakatView.vue';

const routes = [
  //halaman home
  {path: '/def2',component: def2},
  {path: '/',component: HomeView},
  {path: '/form',component: FormSortingDataPelatihan},
  {path: '/kelola/akses',component: KelolaAksesView},

  //halaman login
  {path: '/login/masyarakat',name: 'LoginMasyarakat',component: LoginMasyarakat},
  {path: '/login/pegawai',name: 'LoginPegawai',component: LoginPegawai},
  {path: '/login/operator',name: 'LoginOperator',component: LoginOperator},

  //halaman daftar masyarakat
  {path: '/daftar/masyarakat',name: 'DaftarMasyarakat',component: DaftarMasyarakatView},

  //halaman lupa password
  {path: '/reset/otp',name: 'resetOperatorOtp',component: OtpView},
  {path: '/reset/forgot',name: 'resetOperatorForgot',component: ForgotView},
  {path: '/reset/password',name: 'resetOperatorPassword',component: ResetPassword},

  //halaman kelola pelatihan
  {path: '/data/pelatihan',name: 'DataPelatihan',component: DataPelatihanView,meta: { requiresAuth: true, role: 'operator' }},
  {path: '/data/Pendaftaran',name: 'DataPendaftaran',component: DataPendaftaranView,meta: { requiresAuth: true, role: 'operator' }},
  {path: '/data/pelatihan/sampah',name: 'DataPelatihanSampah',component: DataPelatihanSampahView,meta: { requiresAuth: true}},
  
  //halaman pretest postest
  {path: '/preposttest',name: 'PrePostTest',component: PrePostTestView},
  {path: '/kelolatest',name: 'KelolaTest',component: PrePostTestView},

  // halaman pelaporan pengaduan
  {path: '/pengaduan',name: 'PelaporanPengaduan',component: PelaporanPengaduan},
  {path: '/pengaduan/status',name: 'StatusPengaduan',component: StatusPengaduan},
  {path: '/pengaduan/buat',name: 'BuatPengaduan',component: BuatPengaduanPage},
  
  // halaman data berita
  {path: '/data/berita/sampah',name: 'DataBeritaSampah',component: DataBeritaSampahView,meta: { requiresAuth: true }},
  {path: '/data/berita',name: 'DataBerita',component: DataBeritaView,meta: { requiresAuth: true }},
  
  //halaman not found dan tidak diizinkan
  {path: '/:pathMatch(.*)*',name: 'NotFound',component: NotFound},
  {path: '/unauthorized',name: 'Unauthorized',component: Unauthorized},
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
