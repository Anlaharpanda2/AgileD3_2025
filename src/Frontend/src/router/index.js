import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/Home/HomeView.vue';
import SimpleLayout from '../layouts/SimpleLayout.vue';
import FormSortingDataPelatihan from '../components/KelolaDataPelatihan/FormSortingDataPelatihan.vue';
import DashboardView from '../views/dashboard/DashboardView.vue';
import DataAksesView from '../views/KelolaAkses/DataAksesView.vue';
import LoginMasyarakat from '../views/Login/LoginMasyarakat.vue';
import LoginPegawai from '../views/Login/LoginPegawai.vue';
import LoginOperator from '../views/Login/LoginOperator.vue';
import DaftarMasyarakatView from '../views/DaftarMasyarakat/DaftarMasyarakatView.vue';
import IkutPelatihanView from '../views/DaftarMasyarakat/IkutPealtihanView.vue';
import OtpView from '../views/ResetPassword/OtpView.vue';
import ForgotView from '../views/ResetPassword/ForgotView.vue';
import ResetPassword from '../views/ResetPassword/ResetPassword.vue';
import KelolaDataView from '../views/KelolaData/KelolaDataView.vue';
import DataPelatihanView from '../views/PengelolaDataPelatihan/DataPelatihanView.vue';
import DataPelatihanSampahView from '../views/PengelolaDataPelatihan/DataPelatihanSampahView.vue';
import DataStrukturPegawaiView from '../views/PengelolaStrukturPegawai/DataStrukturPegawaiView.vue';
import DataStrukturPegawaiSampahView from '../views/PengelolaStrukturPegawai/DataStrukturPegawaiSampahView.vue';
import DataKonsultasiView from '../views/PengelolaDataKonsultasi/DataKonsultasiView.vue';
import DataKonsultasiSampahView from '../views/PengelolaDataKonsultasi/DataKonsultasiSampahView.vue';
import DataPengaduanView from '../views/PengelolaDataPengaduan/DataPengaduanView.vue';
import DataPengaduanSampahView from '../views/PengelolaDataPengaduan/DataPengaduanSampahView.vue';
import DataPanitiaView from '../views/PengelolaDataPanitia/DataPanitiaView.vue';
import DataPanitiaSampahView from '../views/PengelolaDataPanitia/DataPanitiaSampahView.vue';
import DataFasilitasView from '../views/PengelolaDataFasilitas/DataFasilitasView.vue';
import DataFasilitasSampahView from '../views/PengelolaDataFasilitas/DataFasilitasSampahView.vue';
import AdminProfile from '../views/AdminProfile.vue';
import MyScoresView from '../views/Profile/MyScoresView.vue';
import ProfileMasyarakat from '../views/Profile/ProfileMasyarakat.vue';
import StatusPelatihanView from '../views/StatusPelatihanView.vue';
import DataPendaftaranView from '../views/PengelolaDataPendaftaran/DataPendaftaranView.vue';
import TaskManagementView from '../views/PengelolaDataTest/TaskManagementView.vue';
import CreatePretestView from '../views/PengelolaDataTest/CreatePretestView.vue';
import EditPretestView from '../views/PengelolaDataTest/EditPretestView.vue';
import PretestDetailView from '../views/PengelolaDataTest/PretestDetailView.vue';
import TakePretestView from '../views/PengelolaDataTest/TakePretestView.vue';
import CreatePosttestView from '../views/PengelolaDataTest/CreatePosttestView.vue';
import EditPosttestView from '../views/PengelolaDataTest/EditPosttestView.vue';
// Assumed correction from PretestDetailView for PosttestDetail
import PosttestDetailView from '../views/PengelolaDataTest/PretestDetailView.vue';
import TakePosttestView from '../views/PengelolaDataTest/TakePosttestView.vue';
import DataNilaiView from '../views/DataNilai/DataNilaiView.vue';
import BuatPengaduanView from '../views/PengelolaDataPengaduan/BuatPengaduanView.vue';
import KonfirmasiPengaduanView from '../views/PengelolaDataPengaduan/KonfirmasiPengaduanView.vue';
import StatusPengaduan from '../views/PengelolaDataPengaduan/StatusPengaduan.vue';
import SearchPengaduan from '@/components/Pengaduan/SearchPengaduan.vue';
import DataBeritaSampahView from '../views/PengelolaDataBerita/DataBeritaSampahView.vue';
import DataBeritaView from '../views/PengelolaDataBerita/DataBeritaView.vue';
import DetailDataBeritaView from '../views/PengelolaDataBerita/DetailDataBeritaView.vue';
import DetailDataPengumumanView from '../views/PengelolaDataBerita/DetailDataPengumumanView.vue';
import NotFound from '../views/NotFound.vue';
import Unauthorized from '../views/Unauthorized.vue';
import Konsultasi from '../views/Footer/Konsultasi.vue';
import ProgramPelatihan from '../views/Footer/ProgramPelatihan.vue';
import Pendampingan from '../views/Footer/Pendampingan.vue';
import InfoPengaduan from '../views/Footer/InfoPengaduan.vue';
import PusatBantuan from '../views/Footer/PusatBantuan.vue';
import FAQ from '../views/Footer/FAQ.vue';
import HubungiKami from '../views/Footer/HubungiKami.vue';
import Feedback from '../views/Footer/Feedback.vue';


const routes = [
  // Halaman home
  { path: '/def2', component: SimpleLayout },
  { path: '/', component: HomeView },
  { path: '/form', component: FormSortingDataPelatihan },

  // Halaman Dashboard
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: DashboardView,
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] }
  },
  
  // Halaman kelola akses
  { 
    path: '/data/akses', 
    name: 'DataAkses', 
    component: DataAksesView, 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  
  // Halaman login
  { path: '/login/masyarakat', name: 'LoginMasyarakat', component: LoginMasyarakat },
  { path: '/login/pegawai', name: 'LoginPegawai', component: LoginPegawai },
  { path: '/login/operator', name: 'LoginOperator', component: LoginOperator },

  // Halaman daftar masyarakat
  { path: '/daftar/masyarakat', name: 'DaftarMasyarakat', component: DaftarMasyarakatView },
  { path: '/Daftar/Pelatihan', name: 'IkutPelatihan', component: IkutPelatihanView },

  // Halaman lupa password
  { path: '/reset/otp', name: 'resetOperatorOtp', component: OtpView },
  { path: '/reset/forgot', name: 'resetOperatorForgot', component: ForgotView },
  { path: '/reset/password', name: 'resetOperatorPassword', component: ResetPassword },

  // Kelola data
  { 
    path: '/Kelola/data', 
    name: 'KelolaData', 
    component: KelolaDataView, 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },

  // Halaman kelola pelatihan
  { 
    path: '/data/pelatihan', 
    name: 'DataPelatihan', 
    component: DataPelatihanView, 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { 
    path: '/data/pelatihan/sampah', 
    name: 'DataPelatihanSampah', 
    component: DataPelatihanSampahView, 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },

  // Halaman kelola struktur pegawai
  { 
    path: '/data/struktur-pegawai', 
    name: 'DataStrukturPegawai', 
    component: DataStrukturPegawaiView, 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { 
    path: '/data/struktur-pegawai/sampah', 
    name: 'DataStrukturPegawaiSampah', 
    component: DataStrukturPegawaiSampahView, 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },

  // Halaman kelola konsultasi
  { 
    path: '/data/konsultasi', 
    name: 'DataKonsultasi', 
    component: DataKonsultasiView, 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { 
    path: '/data/konsultasi/sampah', 
    name: 'DataKonsultasiSampah', 
    component: DataKonsultasiSampahView, 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },

  // Halaman kelola pengaduan
  { 
    path: '/data/pengaduan', 
    name: 'DataPengaduan', 
    component: DataPengaduanView, 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { 
    path: '/data/pengaduan/sampah', 
    name: 'DataPengaduanSampah', 
    component: DataPengaduanSampahView, 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },

  // Halaman kelola panitia
  { 
    path: '/data/panitia', 
    name: 'DataPanitia', 
    component: DataPanitiaView, 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { 
    path: '/data/panitia/sampah', 
    name: 'DataPanitiaSampah', 
    component: DataPanitiaSampahView, 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },

  // Halaman kelola fasilitas
  { 
    path: '/data/fasilitas', 
    name: 'DataFasilitas', 
    component: DataFasilitasView, 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { 
    path: '/data/fasilitas/sampah', 
    name: 'DataFasilitasSampah', 
    component: DataFasilitasSampahView, 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },

  // Profile
  { 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { 
    path: '/admin/:id', 
    name: 'AdminProfile', 
    component: AdminProfile, 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { 
    path: '/Test', 
    name: 'MyScores', 
    component: MyScoresView, 
    meta: { requiresAuth: true, role: ['masyarakat'] } 
  },
  {
    path: '/masyarakat/:id',
    name: 'DetailMasyarakat',
    component: ProfileMasyarakat,
    meta: { requiresAuth: true, role: ['operator', 'pegawai', 'masyarakat'] }
  },
  {
    path: '/status-pelatihan',
    name: 'StatusPelatihan',
    component: StatusPelatihanView,
    meta: { requiresAuth: true }
  },

  // Halaman kelola pendaftaran
  { 
    path: '/data/pendaftaran', 
    name: 'Datapendaftaran', 
    component: DataPendaftaranView, 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },

  // Halaman pretest posttest
  { 
    path: '/data/soal', 
    name: 'TaskManagement', 
    component: TaskManagementView, 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { 
    path: '/pretests/create', 
    name: 'CreatePretest', 
    component: CreatePretestView, 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { 
    path: '/pretests/:id/edit', 
    name: 'EditPretest', 
    component: EditPretestView, 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { path: '/pretests/:id', name: 'PretestDetail', component: PretestDetailView },
  { path: '/pretests', name: 'TakePretest', component: TakePretestView },
  { 
    path: '/posttests/create', 
    name: 'CreatePosttest', 
    component: CreatePosttestView, 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { 
    path: '/posttests/:id/edit', 
    name: 'EditPosttest', 
    component: EditPosttestView, 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },
  { 
    path: '/posttests/:id', 
    name: 'PosttestDetail', 
    component: PosttestDetailView
  },
  { path: '/posttests', name: 'TakePosttest', component: TakePosttestView },

  // Halaman Data Nilai
  { 
    path: '/data/nilai', 
    name: 'DataNilai', 
    component: DataNilaiView, 
    meta: { requiresAuth: true, role: ['operator', 'pegawai'] } 
  },

  // Halaman pelaporan pengaduan
  { path: '/pengaduan/buat', name: 'BuatPengaduan', component: BuatPengaduanView },
  { path: '/pengaduan/konfirmasi', name: 'KonfirmasiPengaduan', component: KonfirmasiPengaduanView },
  { path: '/pengaduan/status/:id', name: 'StatusPengaduan', component: StatusPengaduan },
  { path: '/pengaduan/cari', name: 'CariPengaduan', component: SearchPengaduan },

  // Halaman data berita
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
  { path: '/berita/:id', name: 'DetailBerita', component: DetailDataBeritaView },
  { path: '/pengumuman/:id', name: 'DetailPengumuman', component: DetailDataPengumumanView },

  // Halaman not found dan tidak diizinkan
  { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound },
  { path: '/unauthorized', name: 'Unauthorized', component: Unauthorized },

  // Footer
  { 
    path: '/info/konsultasi', 
    name: 'infoKonsultasi', 
    component: Konsultasi, 
    meta: { requiresAuth: true, role: ['operator'] } 
  },
  { 
    path: '/info/pelatihan', 
    name: 'infoProgramPelatihan', 
    component: ProgramPelatihan, 
    meta: { requiresAuth: true, role: ['operator'] } 
  },
  { 
    path: '/info/pendampingan', 
    name: 'infoPendampingan', 
    component: Pendampingan, 
    meta: { requiresAuth: true, role: ['operator'] } 
  },
  { 
    path: '/info/pengaduan', 
    name: 'infoPengaduan', 
    component: InfoPengaduan, 
    meta: { requiresAuth: true, role: ['operator'] } 
  },
  { 
    path: '/bantuan', 
    name: 'PusatBantuan', 
    component: PusatBantuan, 
    meta: { requiresAuth: true, role: ['operator'] } 
  },
  { 
    path: '/faq', 
    name: 'FAQ', 
    component: FAQ, 
    meta: { requiresAuth: true, role: ['operator'] } 
  },
  { 
    path: '/kontak', 
    name: 'HubungiKami', 
    component: HubungiKami, 
    meta: { requiresAuth: true, role: ['operator'] } 
  },
  { 
    path: '/feedback', 
    name: 'Feedback', 
    component: Feedback, 
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
