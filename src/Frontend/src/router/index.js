import { createRouter, createWebHistory } from 'vue-router';
import KelolaAksesView from '../views/KelolaAkses/KelolaAksesView.vue';
import def2 from '../layouts/Layout2.vue';
import FormSortingDataPelatihan from '../components/KelolaDataPelatihan/FormSortingDataPelatihan.vue';
import HomeView from '../views/Home/HomeView.vue';
import LoginMasyarakat from '../views/Login/LoginMasyarakat.vue';
import LoginOperator from '../views/Login/LoginOperator.vue';
import LoginPegawai from '../views/Login/LoginPegawai.vue';
import DataPelatihanView from '../views/PengelolaDataPelatihan/DataPelatihanView.vue';
import DataPelatihanSampahView from '../views/PengelolaDataPelatihan/DataPelatihanSampahView.vue';
import DataPengaduanView from '../views/PengelolaDataPengaduan/DataPengaduanView.vue';
import DataPengaduanSampahView from '../views/PengelolaDataPengaduan/DataPengaduanSampahView.vue';
import DataPanitiaView from '../views/PengelolaDataPanitia/DataPanitiaView.vue';
import DataPanitiaSampahView from '../views/PengelolaDataPanitia/DataPanitiaSampahView.vue';
import DataKonsultasiView from '../views/PengelolaDataKonsultasi/DataKonsultasiView.vue';
import DataKonsultasiSampahView from '../views/PengelolaDataKonsultasi/DataKonsultasiSampahView.vue';
import PrePostTestView from '../views/PengelolaPretestPostest/PrePostTestView.vue';
import PretestManagementView from '../views/PengelolaDataTest/PretestManagementView.vue';
import CreatePretestView from '../views/PengelolaDataTest/CreatePretestView.vue';
import EditPretestView from '../views/PengelolaDataTest/EditPretestView.vue';
import PretestDetailView from '../views/PengelolaDataTest/PretestDetailView.vue';
import TakePretestView from '../views/PengelolaDataTest/TakePretestView.vue';
import DataNilaiView from '../views/DataNilai/DataNilaiView.vue';
//pengaduan
import BuatPengaduanView from '../views/PengelolaDataPengaduan/BuatPengaduanView.vue';
import KonfirmasiPengaduanView from '../views/PengelolaDataPengaduan/KonfirmasiPengaduanView.vue';
import StatusPengaduan from '../views/PengelolaDataPengaduan/StatusPengaduan.vue';

//Berita
import DataBeritaView from '../views/PengelolaDataBerita/DataBeritaView.vue';
import DataBeritaSampahView from '../views/PengelolaDataBerita/DataBeritaSampahView.vue';
import DetailDataPengumumanView from '@/views/PengelolaDataBerita/DetailDataPengumumanView.vue';

//Fasilitas
import DataFasilitasSampahView from '@/views/PengelolaDataFasilitas/DataFasilitasSampahView.vue';
import DataFasilitasView from '@/views/PengelolaDataFasilitas/DataFasilitasView.vue';

import OtpView from '../views/ResetPassword/OtpView.vue';
import ForgotView from '../views/ResetPassword/ForgotView.vue';
import ResetPassword from '../views/ResetPassword/ResetPassword.vue';
import DatapendaftaranView from '../views/PengelolaDataPendaftaran/DataPendaftaranView.vue';
import NotFound from '../views/NotFound.vue';
import Unauthorized from '../views/Unauthorized.vue';
import DaftarMasyarakatView from '../views/DaftarMasyarakat/DaftarMasyarakatView.vue';
import IkutPealtihanView from '@/views/DaftarMasyarakat/IkutPealtihanView.vue';
import ProfileMasyarakat from '../views/Profile/ProfileMasyarakat.vue';
import KelolaDataView from '../views/KelolaData/KelolaDataView.vue';
import DataStrukturPegawaiView from '../views/KelolaStrukturPegawai/DataStrukturPegawaiView.vue';
import DataStrukturPegawaiSampahView from '../views/KelolaStrukturPegawai/DataStrukturPegawaiSampahView.vue';

//footer
import Konsultasi from '../views/Footer/Konsultasi.vue';
import ProgramPelatihan from '../views/Footer/ProgramPelatihan.vue';
import Pendampingan from '../views/Footer/Pendampingan.vue';
import PusatBantuan from '../views/Footer/PusatBantuan.vue';
import FAQ from '../views/Footer/FAQ.vue';
import HubungiKami from '../views/Footer/HubungiKami.vue';
import Feedback from '../views/Footer/Feedback.vue';
import DetailDataBeritaView from '../views/PengelolaDataBerita/DetailDataBeritaView.vue';
import InfoPengaduan from '@/views/Footer/InfoPengaduan.vue';

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
  {path: '/Daftar/Pelatihan',name: 'IkutPelatihan',component: IkutPealtihanView},

  //halaman lupa password
  {path: '/reset/otp',name: 'resetOperatorOtp',component: OtpView},
  {path: '/reset/forgot',name: 'resetOperatorForgot',component: ForgotView},
  {path: '/reset/password',name: 'resetOperatorPassword',component: ResetPassword},

  //Kelola data
  {path: '/Kelola/data',name: 'KelolaData',component: KelolaDataView,meta: { requiresAuth: true, role: ['operator', 'pegawai'] }},

  //halaman kelola pelatihan
  {path: '/data/pelatihan',name: 'DataPelatihan',component: DataPelatihanView,meta: { requiresAuth: true, role: ['operator', 'pegawai'] }},
  {path: '/data/pelatihan/sampah',name: 'DataPelatihanSampah',component: DataPelatihanSampahView,meta: { requiresAuth: true, role: ['operator', 'pegawai']}},

  //halaman kelola pengaduan
  {path: '/data/pengaduan',name: 'DataPengaduan',component: DataPengaduanView,meta: { requiresAuth: true, role: ['operator', 'pegawai'] }},
  {path: '/data/pengaduan/sampah',name: 'DataPengaduanSampah',component: DataPengaduanSampahView,meta: { requiresAuth: true, role: ['operator', 'pegawai']}},

  //halaman kelola panitia
  {path: '/data/panitia',name: 'DataPanitia',component: DataPanitiaView,meta: { requiresAuth: true, role: ['operator', 'pegawai'] }},
  {path: '/data/panitia/sampah',name: 'DataPanitiaSampah',component: DataPanitiaSampahView,meta: { requiresAuth: true, role: ['operator', 'pegawai']}},

  //halaman kelola fasilitas
  {path: '/data/fasilitas',name: 'DataFasilitas',component: DataFasilitasView,meta: { requiresAuth: true, role: ['operator', 'pegawai'] }},
  {path: '/data/fasilitas/sampah',name: 'DataFasilitasSampah',component: DataFasilitasSampahView,meta: { requiresAuth: true, role: ['operator', 'pegawai']}},

  //profile
  {path: '/masyarakat/:id',name: 'DetailMasyarakat',component: ProfileMasyarakat,meta: { requiresAuth: true, role: ['operator', 'pegawai'] }},
  
  //halaman kelola pendaftaran
  {path: '/data/pendaftaran',name: 'Datapendaftaran',component: DatapendaftaranView,meta: { requiresAuth: true, role: ['operator', 'pegawai'] }},
  
  //halaman pretest postest
  {path: '/preposttest',name: 'PrePostTest',component: PrePostTestView},
  {path: '/kelolatest',name: 'KelolaTest',component: PrePostTestView},
  {path: '/pretests',name: 'PretestManagement',component: PretestManagementView, meta: { requiresAuth: true, role: ['operator', 'pegawai'] }},
  {path: '/pretests/create',name: 'CreatePretest',component: CreatePretestView, meta: { requiresAuth: true, role: ['operator', 'pegawai'] }},
  {path: '/pretests/:id/edit',name: 'EditPretest',component: EditPretestView, meta: { requiresAuth: true, role: ['operator', 'pegawai'] }},
  {path: '/pretests/:id',name: 'PretestDetail',component: PretestDetailView},
  {path: '/pretests/:id/take',name: 'TakePretest',component: TakePretestView},

  // Halaman Data Nilai
  {path: '/data/nilai',name: 'DataNilai',component: DataNilaiView, meta: { requiresAuth: true, role: ['operator', 'pegawai'] }},

  // halaman pelaporan pengaduan
  {path: '/pengaduan/buat',name: 'BuatPengaduan',component: BuatPengaduanView},
  {path: '/pengaduan/konfirmasi',name: 'KonfirmasiPengaduan',component: KonfirmasiPengaduanView},
  {path: '/pengaduan/status/:id',name: 'StatusPengaduan',component: StatusPengaduan},
  
  // halaman data berita
  {path: '/data/berita/sampah',name: 'DataBeritaSampah',component: DataBeritaSampahView,meta: { requiresAuth: true }},
  {path: '/data/berita',name: 'DataBerita',component: DataBeritaView,meta: { requiresAuth: true }},
  {path: '/berita/:id',name: 'DetailBerita',component: DetailDataBeritaView},
  {path: '/pengumuman/:id',name: 'DetailPengumuman',component: DetailDataPengumumanView},

  //halaman kelola konsultasi
  {path: '/data/konsultasi', name: 'DataKonsultasi', component: DataKonsultasiView, meta: { requiresAuth: true, role: ['operator', 'pegawai'] } },
  { path: '/data/konsultasi/sampah', name: 'DataKonsultasiSampah', component: DataKonsultasiSampahView, meta: { requiresAuth: true, role: ['operator', 'pegawai'] } },

  
  // halaman kelola struktur pegawai
  { path: '/data/strukturpegawai', name: 'DataStrukturPegawai', component: DataStrukturPegawaiView, meta: { requiresAuth: true, role: ['operator'] } },
  { path: '/data/strukturpegawai/sampah', name: 'DataStrukturPegawaiSampah', component: DataStrukturPegawaiSampahView, meta: { requiresAuth: true, role: ['operator'] } },
  
  
  //halaman not found dan tidak diizinkan
  {path: '/:pathMatch(.*)*',name: 'NotFound',component: NotFound},
  {path: '/unauthorized',name: 'Unauthorized',component: Unauthorized},
  
  //footer
  { path: '/info/konsultasi', name: 'infoKonsultasi', component: Konsultasi, meta: { requiresAuth: true, role: ['operator'] } },
  { path: '/info/pelatihan', name: 'infoProgramPelatihan', component: ProgramPelatihan, meta: { requiresAuth: true, role: ['operator'] } },
  { path: '/info/pendampingan', name: 'infoPendampingan', component: Pendampingan, meta: { requiresAuth: true, role: ['operator'] } },
  { path: '/info/pengaduan', name: 'infoPengaduan', component: InfoPengaduan, meta: { requiresAuth: true, role: ['operator'] } },
  { path: '/bantuan', name: 'PusatBantuan', component: PusatBantuan, meta: { requiresAuth: true, role: ['operator'] } },
  { path: '/faq', name: 'FAQ', component: FAQ, meta: { requiresAuth: true, role: ['operator'] } },
  { path: '/kontak', name: 'HubungiKami', component: HubungiKami, meta: { requiresAuth: true, role: ['operator'] } },
  { path: '/feedback', name: 'Feedback', component: Feedback, meta: { requiresAuth: true, role: ['operator'] } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  // --- TAMBAHKAN BAGIAN scrollBehavior INI ---
  scrollBehavior(to, from, savedPosition) {
    // Jika ada savedPosition (misal dari tombol back/forward browser), gunakan itu
    if (savedPosition) {
      return savedPosition;
    } else {
      // Gulir ke bagian atas halaman untuk rute baru
      return { top: 0, behavior: 'smooth' }; // 'smooth' untuk animasi gulir yang halus
    }
  },
  // ------------------------------------------
});

router.beforeEach((to, from, next) => {
  const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
  const userRole = localStorage.getItem('role');
  const userId = localStorage.getItem('savedNIK'); // pastikan disimpan saat login

  if (to.meta.requiresAuth) {
    if (!isLoggedIn) {
      return next({ path: '/login/masyarakat' });
    }

    // Role dari meta
    const allowedRoles = to.meta.role;

    // Cek apakah role dibatasi
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
