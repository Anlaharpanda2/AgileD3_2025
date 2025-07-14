import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/Home/HomeView.vue';


const routes = [
  // Halaman home
  { path: '/def2', component: () => import('../layouts/SimpleLayout.vue') },
  { path: '/', component: HomeView },
  { path: '/form', component: () => import('../components/KelolaDataPelatihan/FormSortingDataPelatihan.vue') },

  // Halaman Dashboard
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: () => import('../views/dashboard/DashboardView.vue'),
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] }
  },
  
  // Halaman kelola akses
  { 
    path: '/data/akses', 
    name: 'DataAkses', 
    component: () => import('../views/KelolaAkses/DataAksesView.vue'), 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  
  // Halaman login
  { path: '/login/masyarakat', name: 'LoginMasyarakat', component: () => import('../views/Login/LoginMasyarakat.vue') },
  { path: '/login/pegawai', name: 'LoginPegawai', component: () => import('../views/Login/LoginPegawai.vue') },
  { path: '/login/operator', name: 'LoginOperator', component: () => import('../views/Login/LoginOperator.vue') },

  // Halaman daftar masyarakat
  { path: '/daftar/masyarakat', name: 'DaftarMasyarakat', component: () => import('../views/DaftarMasyarakat/DaftarMasyarakatView.vue') },
  { path: '/Daftar/Pelatihan', name: 'IkutPelatihan', component: () => import('../views/DaftarMasyarakat/IkutPealtihanView.vue') },

  // Halaman lupa password
  { path: '/reset/otp', name: 'resetOperatorOtp', component: () => import('../views/ResetPassword/OtpView.vue') },
  { path: '/reset/forgot', name: 'resetOperatorForgot', component: () => import('../views/ResetPassword/ForgotView.vue') },
  { path: '/reset/password', name: 'resetOperatorPassword', component: () => import('../views/ResetPassword/ResetPassword.vue') },

  // Kelola data
  { 
    path: '/Kelola/data', 
    name: 'KelolaData', 
    component: () => import('../views/KelolaData/KelolaDataView.vue'), 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },

  // Halaman kelola pelatihan
  { 
    path: '/data/pelatihan', 
    name: 'DataPelatihan', 
    component: () => import('../views/PengelolaDataPelatihan/DataPelatihanView.vue'), 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { 
    path: '/data/pelatihan/sampah', 
    name: 'DataPelatihanSampah', 
    component: () => import('../views/PengelolaDataPelatihan/DataPelatihanSampahView.vue'), 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },

  // Halaman kelola struktur pegawai
  { 
    path: '/data/struktur-pegawai', 
    name: 'DataStrukturPegawai', 
    component: () => import('../views/PengelolaStrukturPegawai/DataStrukturPegawaiView.vue'), 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { 
    path: '/data/struktur-pegawai/sampah', 
    name: 'DataStrukturPegawaiSampah', 
    component: () => import('../views/PengelolaStrukturPegawai/DataStrukturPegawaiSampahView.vue'), 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },

  // Halaman kelola konsultasi
  { 
    path: '/data/konsultasi', 
    name: 'DataKonsultasi', 
    component: () => import('../views/PengelolaDataKonsultasi/DataKonsultasiView.vue'), 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { 
    path: '/data/konsultasi/sampah', 
    name: 'DataKonsultasiSampah', 
    component: () => import('../views/PengelolaDataKonsultasi/DataKonsultasiSampahView.vue'), 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },

  // Halaman kelola pengaduan
  { 
    path: '/data/pengaduan', 
    name: 'DataPengaduan', 
    component: () => import('../views/PengelolaDataPengaduan/DataPengaduanView.vue'), 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { 
    path: '/data/pengaduan/sampah', 
    name: 'DataPengaduanSampah', 
    component: () => import('../views/PengelolaDataPengaduan/DataPengaduanSampahView.vue'), 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },

  // Halaman kelola panitia
  { 
    path: '/data/panitia', 
    name: 'DataPanitia', 
    component: () => import('../views/PengelolaDataPanitia/DataPanitiaView.vue'), 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { 
    path: '/data/panitia/sampah', 
    name: 'DataPanitiaSampah', 
    component: () => import('../views/PengelolaDataPanitia/DataPanitiaSampahView.vue'), 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },

  // Halaman kelola fasilitas
  { 
    path: '/data/fasilitas', 
    name: 'DataFasilitas', 
    component: () => import('../views/PengelolaDataFasilitas/DataFasilitasView.vue'), 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { 
    path: '/data/fasilitas/sampah', 
    name: 'DataFasilitasSampah', 
    component: () => import('../views/PengelolaDataFasilitas/DataFasilitasSampahView.vue'), 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },

  // Profile
  { 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { 
    path: '/admin/:id', 
    name: 'AdminProfile', 
    component: () => import('../views/AdminProfile.vue'), 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { 
    path: '/Test', 
    name: 'MyScores', 
    component: () => import('../views/Profile/MyScoresView.vue'), 
    meta: { requiresAuth: true, role: ['masyarakat'] } 
  },
  {
    path: '/masyarakat/:id',
    name: 'DetailMasyarakat',
    component: () => import('../views/Profile/ProfileMasyarakat.vue'),
    meta: { requiresAuth: true, role: ['operator', 'pegawai', 'masyarakat'] }
  },
  {
    path: '/status-pelatihan',
    name: 'StatusPelatihan',
    component: () => import('../views/StatusPelatihanView.vue'),
    meta: { requiresAuth: true }
  },

  // Halaman kelola pendaftaran
  { 
    path: '/data/pendaftaran', 
    name: 'Datapendaftaran', 
    component: () => import('../views/PengelolaDataPendaftaran/DataPendaftaranView.vue'), 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },

  // Halaman pretest posttest
  { 
    path: '/data/soal', 
    name: 'TaskManagement', 
    component: () => import('../views/PengelolaDataTest/TaskManagementView.vue'), 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { 
    path: '/pretests/create', 
    name: 'CreatePretest', 
    component: () => import('../views/PengelolaDataTest/CreatePretestView.vue'), 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { 
    path: '/pretests/:id/edit', 
    name: 'EditPretest', 
    component: () => import('../views/PengelolaDataTest/EditPretestView.vue'), 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { path: '/pretests/:id', name: 'PretestDetail', component: () => import('../views/PengelolaDataTest/PretestDetailView.vue') },
  { path: '/pretests', name: 'TakePretest', component: () => import('../views/PengelolaDataTest/TakePretestView.vue') },
  { 
    path: '/posttests/create', 
    name: 'CreatePosttest', 
    component: () => import('../views/PengelolaDataTest/CreatePosttestView.vue'), 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { 
    path: '/posttests/:id/edit', 
    name: 'EditPosttest', 
    component: () => import('../views/PengelolaDataTest/EditPosttestView.vue'), 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { 
    path: '/posttests/:id', 
    name: 'PosttestDetail', 
    component: () => import('../views/PengelolaDataTest/PretestDetailView.vue') // Assumed correction from PretestDetailView
  },
  { path: '/posttests', name: 'TakePosttest', component: () => import('../views/PengelolaDataTest/TakePosttestView.vue') },

  // Halaman Data Nilai
  { 
    path: '/data/nilai', 
    name: 'DataNilai', 
    component: () => import('../views/DataNilai/DataNilaiView.vue'), 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },

  // Halaman pelaporan pengaduan
  { path: '/pengaduan/buat', name: 'BuatPengaduan', component: () => import('../views/PengelolaDataPengaduan/BuatPengaduanView.vue') },
  { path: '/pengaduan/konfirmasi', name: 'KonfirmasiPengaduan', component: () => import('../views/PengelolaDataPengaduan/KonfirmasiPengaduanView.vue') },
  { path: '/pengaduan/status/:id', name: 'StatusPengaduan', component: () => import('../views/PengelolaDataPengaduan/StatusPengaduan.vue') },
  { path: '/pengaduan/cari', name: 'CariPengaduan', component: () => import('@/components/Pengaduan/SearchPengaduan.vue') },

  // Halaman data berita
  { 
    path: '/data/berita/sampah', 
    name: 'DataBeritaSampah', 
    component: () => import('../views/PengelolaDataBerita/DataBeritaSampahView.vue'), 
    meta: { requiresAuth: true } 
  },
  { 
    path: '/data/berita', 
    name: 'DataBerita', 
    component: () => import('../views/PengelolaDataBerita/DataBeritaView.vue'), 
    meta: { requiresAuth: true } 
  },
  { path: '/berita/:id', name: 'DetailBerita', component: () => import('../views/PengelolaDataBerita/DetailDataBeritaView.vue') },
  { path: '/pengumuman/:id', name: 'DetailPengumuman', component: () => import('../views/PengelolaDataBerita/DetailDataPengumumanView.vue') },

  // Halaman not found dan tidak diizinkan
  { path: '/:pathMatch(.*)*', name: 'NotFound', component: () => import('../views/NotFound.vue') },
  { path: '/unauthorized', name: 'Unauthorized', component: () => import('../views/Unauthorized.vue') },

  // Footer
  { 
    path: '/info/konsultasi', 
    name: 'infoKonsultasi', 
    component: () => import('../views/Footer/Konsultasi.vue'), 
    meta: { requiresAuth: true, role: ['operator'] } 
  },
  { 
    path: '/info/pelatihan', 
    name: 'infoProgramPelatihan', 
    component: () => import('../views/Footer/ProgramPelatihan.vue'), 
    meta: { requiresAuth: true, role: ['operator'] } 
  },
  { 
    path: '/info/pendampingan', 
    name: 'infoPendampingan', 
    component: () => import('../views/Footer/Pendampingan.vue'), 
    meta: { requiresAuth: true, role: ['operator'] } 
  },
  { 
    path: '/info/pengaduan', 
    name: 'infoPengaduan', 
    component: () => import('../views/Footer/InfoPengaduan.vue'), 
    meta: { requiresAuth: true, role: ['operator'] } 
  },
  { 
    path: '/bantuan', 
    name: 'PusatBantuan', 
    component: () => import('../views/Footer/PusatBantuan.vue'), 
    meta: { requiresAuth: true, role: ['operator'] } 
  },
  { 
    path: '/faq', 
    name: 'FAQ', 
    component: () => import('../views/Footer/FAQ.vue'), 
    meta: { requiresAuth: true, role: ['operator'] } 
  },
  { 
    path: '/kontak', 
    name: 'HubungiKami', 
    component: () => import('../views/Footer/HubungiKami.vue'), 
    meta: { requiresAuth: true, role: ['operator'] } 
  },
  { 
    path: '/feedback', 
    name: 'Feedback', 
    component: () => import('../views/Footer/Feedback.vue'), 
    meta: { requiresAuth: true, role: ['operator'] } 
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition;
    } else {
      return { top: 0, behavior: 'smooth' };
    }
  },
});

router.beforeEach((to, from, next) => {
  const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
  const userRole = localStorage.getItem('role');
  const userId = localStorage.getItem('savedNIK');

  if (to.meta.requiresAuth) {
    if (!isLoggedIn) {
      return next({ path: '/login/masyarakat' });
    }

    const allowedRoles = to.meta.role;

    if (allowedRoles) {
      const isAllowedRole = Array.isArray(allowedRoles)
        ? allowedRoles.includes(userRole)
        : allowedRoles === userRole;

      const isSelfAccess =
        to.params.id && userId && String(to.params.id) === String(userId);

      if (!isAllowedRole && !isSelfAccess) {
        return next({ path: '/unauthorized' });
      }
    }
  }

  next();
});

export default router;