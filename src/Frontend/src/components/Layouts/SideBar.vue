<template>
  <!-- Tombol Toggle -->
  <div class="toggle-button" @click="openSidebar" v-show="!isSidebarVisible">
    <el-icon class="toggle"><icon-menu /></el-icon>
  </div>

  <!-- Overlay -->
  <div v-show="isSidebarVisible" class="overlay" @click="closeSidebar"></div>

  <!-- Sidebar -->
  <transition name="slide">
    <div v-show="isSidebarVisible" class="sidebar-container">
      <div class="close-button" @click="closeSidebar">×</div>

      <el-menu
        class="custom-menu"
        :collapse="isCollapse"
        @open="handleOpen"
        @close="handleClose"
        background-color="transparent"
        text-color="#ffffff"
        active-text-color="#ff69b4"
      >
        <!-- BERANDA -->
        <el-menu-item index="1" @click="navigate('/')">
          <el-icon><HomeFilled /></el-icon>
          <span>BERANDA</span>
        </el-menu-item>

        <!-- DASHBOARD -->
        <el-menu-item index="2" @click="navigate('#')">
          <el-icon><DataBoard /></el-icon>
          <span>DASHBOARD</span>
        </el-menu-item>

        <!-- PRE/POSTTEST -->
        <el-menu-item index="3" @click="navigate('/preposttest')">
          <el-icon><Edit /></el-icon>
          <span>PRE/POSTTEST</span>
        </el-menu-item>

        <!-- PENDAFTAR -->
        <el-menu-item index="4" @click="navigate('/data/pendaftaran')">
          <el-icon><UserFilled /></el-icon>
          <span>PENDAFTAR</span>
        </el-menu-item>

        <!-- PELATIHAN -->
        <el-sub-menu index="5">
          <template #title>
            <el-icon><School /></el-icon>
            <span>PELATIHAN</span>
          </template>
          <el-menu-item index="5-1" @click="navigate('/data/pelatihan')">Data Pelatihan</el-menu-item>
          <el-menu-item index="5-2" @click="navigate('/data/pelatihan/sampah')">Data Pelatihan Sampah</el-menu-item>
        </el-sub-menu>

        <!-- PELAPORAN -->
        <el-sub-menu index="6">
          <template #title>
            <el-icon><Document /></el-icon>
            <span>PELAPORAN</span>
          </template>
          <el-menu-item index="6-1" @click="navigate('/pengaduan')">Pelaporan Pengaduan</el-menu-item>
          <el-menu-item index="6-2" @click="navigate('/pengaduan/status')">Status Pengaduan</el-menu-item>
          <el-menu-item index="6-3" @click="navigate('/pengaduan/buat')">Buat Pengaduan</el-menu-item>
        </el-sub-menu>

        <!-- KELOLA DATA -->
        <el-sub-menu index="7">
          <template #title>
            <el-icon><FolderOpened /></el-icon>
            <span>KELOLA DATA</span>
          </template>
          <el-menu-item index="7-1" @click="navigate('/Kelola/data')">Kelola Data Utama</el-menu-item>
          <el-menu-item index="7-2" @click="navigate('/data/berita')">Data Berita</el-menu-item>
          <el-menu-item index="7-3" @click="navigate('/data/berita/sampah')">Data Berita Sampah</el-menu-item>
        </el-sub-menu>

        <!-- KELOLA AKSES -->
        <el-menu-item index="8" @click="navigate('/kelola/akses')">
          <el-icon><Setting /></el-icon>
          <span>KELOLA AKSES</span>
        </el-menu-item>

        <!-- Divider -->
        <div class="menu-divider"></div>

        <!-- Profile (jika diperlukan) -->
        <el-menu-item index="9" @click="navigate('#')" v-if="showProfile">
          <el-icon><User /></el-icon>
          <span>PROFILE</span>
        </el-menu-item>

        <!-- Logout (jika diperlukan) -->
        <el-menu-item index="10" @click="handleLogout" class="logout-menu">
          <el-icon><SwitchButton /></el-icon>
          <span>LOGOUT</span>
        </el-menu-item>
      </el-menu>
    </div>
  </transition>
</template>

<script lang="ts" setup>
import { ref, computed } from 'vue'
import {
  Document,
  Menu as IconMenu,
  Setting,
  HomeFilled,
  DataBoard,
  Edit,
  UserFilled,
  School,
  FolderOpened,
  User,
  SwitchButton
} from '@element-plus/icons-vue'

const isSidebarVisible = ref(false)
const isCollapse = ref(false)

// Props untuk menentukan role user
const props = defineProps({
  userRole: {
    type: String,
    default: 'masyarakat'
  }
})

// Computed untuk menampilkan profile berdasarkan role
const showProfile = computed(() => {
  return props.userRole === 'masyarakat'
})

const handleOpen = (key: string, keyPath: string[]) => {
  console.log('open', key, keyPath)
}

const handleClose = (key: string, keyPath: string[]) => {
  console.log('close', key, keyPath)
}

const openSidebar = () => {
  isSidebarVisible.value = true
}

const closeSidebar = () => {
  isSidebarVisible.value = false
}

const navigate = (url: string) => {
  if (url === '#') {
    console.log('Navigation not implemented for this route')
    return
  }
  
  // Tutup sidebar setelah navigasi
  closeSidebar()
  
  // Navigate menggunakan Vue Router jika tersedia
  if (window.location.pathname !== url) {
    window.location.href = url
  }
}

const handleLogout = () => {
  // Implementasi logout
  localStorage.removeItem('isLoggedIn')
  localStorage.removeItem('role')
  localStorage.removeItem('savedNIK')
  
  // Redirect ke halaman login
  window.location.href = '/login/masyarakat'
}
</script>

<style scoped>
.toggle-button {
  position: absolute;
  display: flex;
  align-items: center;
  top: 10px;
  left: 20px;
  z-index: 1000;
  height: 32px;
  width: 32px;
  cursor: pointer;
  background: #4a9b98;
  border-radius: 4px;
  padding: 8px;
  transition: all 0.3s ease;
}

.toggle-button:hover {
  background: #3d7d7a;
  transform: scale(1.05);
}

.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.4);
  z-index: 999;
}

.sidebar-container {
  position: fixed;
  top: 0;
  left: 0;
  width: 260px;
  height: 100vh;
  background: linear-gradient(180deg, #FF5E93, #29223F);
  box-shadow: 2px 0 8px rgba(0, 0, 0, 0.3);
  z-index: 1000;
  overflow-y: auto;
  color: white;
  transition: all 0.3s ease;
}

.toggle {
  align-items: center;
  color: rgb(218, 218, 218);
}

.close-button {
  font-size: 24px;
  font-weight: bold;
  padding: 15px 20px;
  cursor: pointer;
  text-align: right;
  color: white;
  transition: color 0.3s ease;
}

.close-button:hover {
  color: #ff69b4;
}

.menu-divider {
  height: 1px;
  background-color: rgba(255, 255, 255, 0.2);
  margin: 10px 20px;
}

.slide-enter-active,
.slide-leave-active {
  transition: transform 0.3s ease;
}

.slide-enter-from,
.slide-leave-to {
  transform: translateX(-100%);
}

/* Custom menu styling */
.custom-menu {
  border: none;
  padding: 0 10px;
}

.custom-menu :deep(.el-menu-item),
.custom-menu :deep(.el-sub-menu__title) {
  transition: all 0.3s ease;
  border-radius: 8px;
  margin: 2px 0;
  padding: 0 20px;
  height: 45px;
  line-height: 45px;
}

.custom-menu :deep(.el-menu-item:hover),
.custom-menu :deep(.el-sub-menu__title:hover) {
  background-color: rgba(255, 105, 180, 0.2) !important;
  color: #ff69b4 !important;
  transform: translateX(5px);
}

.custom-menu :deep(.el-menu-item.is-active) {
  background-color: #ff69b4 !important;
  color: white !important;
}

.custom-menu :deep(.el-sub-menu .el-menu-item) {
  padding-left: 40px;
  font-size: 13px;
  height: 40px;
  line-height: 40px;
}

.custom-menu :deep(.el-sub-menu .el-menu-item:hover) {
  background-color: rgba(255, 105, 180, 0.3) !important;
  border-left: 3px solid #ff69b4;
}

/* Logout menu styling */
.logout-menu:hover {
  background-color: rgba(255, 0, 0, 0.2) !important;
  color: #ff4444 !important;
}

/* Scrollbar styling */
.sidebar-container::-webkit-scrollbar {
  width: 6px;
}

.sidebar-container::-webkit-scrollbar-track {
  background: rgba(255, 255, 255, 0.1);
}

.sidebar-container::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.3);
  border-radius: 3px;
}

.sidebar-container::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 255, 255, 0.5);
}

/* Responsive */
@media (max-width: 768px) {
  .sidebar-container {
    width: 280px;
  }
}

@media (max-width: 480px) {
  .sidebar-container {
    width: 70vw;
  }
}
</style>