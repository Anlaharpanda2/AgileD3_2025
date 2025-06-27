<template>
  <!-- Tombol Toggle -->
  <button
    class="fixed top-4 left-4 z-50 p-2 text-gray-700 bg-white rounded shadow hover:bg-gray-200 focus:outline-none"
    @click="openSidebar"
    v-show="!isSidebarVisible"
  >
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
    </svg>
  </button>

  <!-- Overlay -->
  <div
    v-show="isSidebarVisible"
    class="fixed inset-0 z-40 bg-black bg-opacity-50"
    @click="closeSidebar"
  ></div>

  <!-- Sidebar -->
  <transition name="slide">
    <div
      v-show="isSidebarVisible"
      class="fixed inset-y-0 left-0 z-50 w-64 p-4 overflow-y-auto bg-white shadow-lg"
    >
      <div class="flex justify-end">
        <button class="p-2 text-gray-700 hover:text-pink-500 focus:outline-none" @click="closeSidebar">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <el-menu
        class="mt-4 border-none"
        :default-active="activeIndex"
        @open="handleOpen"
        @close="handleClose"
        background-color="#ffffff"
        text-color="#333333"
        active-text-color="#ff69b4"
      >
        <!-- BERANDA -->
        <el-menu-item index="1" @click="navigate('/')">
          <template #title>
            <span class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
              </svg>
              BERANDA
            </span>
          </template>
        </el-menu-item>

        <!-- DASHBOARD -->
        <el-menu-item index="2" @click="navigate('#')">
          <template #title>
            <span class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
              DASHBOARD
            </span>
          </template>
        </el-menu-item>

        <!-- PRE/POSTTEST -->
        <el-menu-item index="3" @click="navigate('/preposttest')">
          <template #title>
            <span class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
              PRE/POSTTEST
            </span>
          </template>
        </el-menu-item>

        <!-- PENDAFTAR -->
        <el-menu-item index="4" @click="navigate('/data/pendaftaran')">
          <template #title>
            <span class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
              </svg>
              PENDAFTAR
            </span>
          </template>
        </el-menu-item>

        <!-- PELATIHAN -->
        <el-sub-menu index="5">
          <template #title>
            <span class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.247 18 16.5 18s-3.332.477-4.5 1.253" />
              </svg>
              PELATIHAN
            </span>
          </template>
          <el-menu-item index="5-1" @click="navigate('/data/pelatihan')">Data Pelatihan</el-menu-item>
          <el-menu-item index="5-2" @click="navigate('/data/pelatihan/sampah')">Data Pelatihan Sampah</el-menu-item>
        </el-sub-menu>

        <!-- PELAPORAN -->
        <el-sub-menu index="6">
          <template #title>
            <span class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
              </svg>
              PELAPORAN
            </span>
          </template>
          <el-menu-item index="6-1" @click="navigate('/pengaduan')">Pelaporan Pengaduan</el-menu-item>
          <el-menu-item index="6-2" @click="navigate('/pengaduan/status')">Status Pengaduan</el-menu-item>
          <el-menu-item index="6-3" @click="navigate('/pengaduan')">Buat Pengaduan</el-menu-item>
        </el-sub-menu>

        <!-- KELOLA DATA -->
        <el-sub-menu index="7">
          <template #title>
            <span class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 16h14m-7-8l7 7-7 7" />
              </svg>
              KELOLA DATA
            </span>
          </template>
          <el-menu-item index="7-1" @click="navigate('/Kelola/data')">Kelola Data Utama</el-menu-item>
          <el-menu-item index="7-2" @click="navigate('/data/berita')">Data Berita</el-menu-item>
          <el-menu-item index="7-3" @click="navigate('/data/berita/sampah')">Data Berita Sampah</el-menu-item>
          <el-menu-item index="7-4" @click="navigate('/data/konsultasi')">Data Konsultasi</el-menu-item>
          <el-menu-item index="7-5" @click="navigate('/data/konsultasi/sampah')">Data Konsultasi Sampah</el-menu-item>
          <el-menu-item index="7-6-1" @click="navigate('/data/strukturpegawai')">Data Struktur Pegawai</el-menu-item>
          <el-menu-item index="7-6-2" @click="navigate('/data/strukturpegawai/sampah')">Data Struktur Pegawai Sampah</el-menu-item>
        </el-sub-menu>

        <!-- KELOLA AKSES -->
        <el-menu-item index="8" @click="navigate('/kelola/akses')">
          <template #title>
            <span class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              KELOLA AKSES
            </span>
          </template>
        </el-menu-item>

        <!-- Divider -->
        <div class="my-4 border-t border-gray-200"></div>

        <!-- Profile -->
        <el-menu-item index="9" @click="navigateProfile" v-if="showProfile">
          <template #title>
            <span class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
              PROFILE
            </span>
          </template>
        </el-menu-item>

        <!-- Logout -->
        <el-menu-item index="10" @click="handleLogout" class="logout-menu">
          <template #title>
            <span class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
              </svg>
              LOGOUT
            </span>
          </template>
        </el-menu-item>
      </el-menu>
    </div>
  </transition>
</template>

<script lang="ts" setup>
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';

const isSidebarVisible = ref(false);
const activeIndex = ref('1');
const router = useRouter();

const props = defineProps({
  userRole: {
    type: String,
    default: 'masyarakat'
  }
});

const showProfile = computed(() => {
  return props.userRole === 'masyarakat';
});

const handleOpen = (key: string, keyPath: string[]) => {
  console.log('open', key, keyPath);
};

const handleClose = (key: string, keyPath: string[]) => {
  console.log('close', key, keyPath);
};

const openSidebar = () => {
  isSidebarVisible.value = true;
};

const closeSidebar = () => {
  isSidebarVisible.value = false;
};

const navigate = (url: string) => {
  if (url === '#') {
    console.log('Navigation not implemented for this route, or it is a placeholder.');
    closeSidebar();
    return;
  }
  closeSidebar();
  router.push(url);
};

const navigateProfile = () => {
  closeSidebar();
  const userId = localStorage.getItem('savedNIK');
  if (userId) {
    router.push(`/masyarakat/${userId}`);
  } else {
    console.warn('User ID not found for profile navigation. Redirecting to login.');
    router.push('/login/masyarakat');
  }
};

const handleLogout = () => {
  localStorage.removeItem('isLoggedIn');
  localStorage.removeItem('role');
  localStorage.removeItem('savedNIK');
  router.push('/login/masyarakat');
};
</script>

<style scoped>
.slide-enter-active,
.slide-leave-active {
  transition: transform 0.3s ease;
}

.slide-enter-from,
.slide-leave-to {
  transform: translateX(-100%);
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateX(-20px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

.sidebar-container {
  animation: fadeIn 0.5s ease;
}
</style>
