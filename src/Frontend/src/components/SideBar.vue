<template>
  <!-- Tombol Toggle -->
  <div class="toggle-button" @click="openSidebar" v-show="!isSidebarVisible">
    <el-icon class = "toggle"><icon-menu /></el-icon>
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
        <el-menu-item index="1" @click="navigate('#')">
          <el-icon><icon-menu /></el-icon>
          <span>Beranda</span>
        </el-menu-item>

        <el-sub-menu index="2">
          <template #title>
            <el-icon><Document /></el-icon>
            <span>Pendaftaran</span>
          </template>
          <el-menu-item index="2-1" @click="navigate('#')">Data 1</el-menu-item>
          <el-menu-item index="2-2" @click="navigate('#')">Data 2</el-menu-item>
          <el-menu-item index="2-3" @click="navigate('#')">Data 3</el-menu-item>
        </el-sub-menu>

        <el-sub-menu index="3">
          <template #title>
            <el-icon><Document /></el-icon>
            <span>Pelatihan</span>
          </template>
          <el-menu-item index="3-1" @click="navigate('/data/pelatihan')">Data Pelatihan</el-menu-item>
          <el-menu-item index="3-2" @click="navigate('/data/pelatihan/sampah')">Data Pelatihan Sampah</el-menu-item>
        </el-sub-menu>

        <el-sub-menu index="4">
          <template #title>
            <el-icon><Document /></el-icon>
            <span>Pelaporan</span>
          </template>
          <el-menu-item index="4-1" @click="navigate('#')">Data 1</el-menu-item>
          <el-menu-item index="4-2" @click="navigate('#')">Data 2</el-menu-item>
          <el-menu-item index="4-3" @click="navigate('#')">Data 3</el-menu-item>
        </el-sub-menu>

        <el-sub-menu index="5">
          <template #title>
            <el-icon><Document /></el-icon>
            <span>Kelola Data</span>
          </template>
          <el-menu-item index="5-1" @click="navigate('#')">Data 1</el-menu-item>
          <el-menu-item index="5-2" @click="navigate('#')">Data 2</el-menu-item>
          <el-menu-item index="5-3" @click="navigate('#')">Data 3</el-menu-item>
        </el-sub-menu>

        <el-menu-item index="6" @click="navigate('#')">
          <el-icon><Document /></el-icon>
          <span>Pesan</span>
        </el-menu-item>

        <el-menu-item index="7" @click="navigate('#')">
          <el-icon><Setting /></el-icon>
          <span>Kelola Akses</span>
        </el-menu-item>

        <el-menu-item index="8" @click="navigate('#')">
          <el-icon><Setting /></el-icon>
          <span>Pengaturan</span>
        </el-menu-item>
      </el-menu>
    </div>
  </transition>
</template>

<script lang="ts" setup>
import { ref } from 'vue'
import {
  Document,
  Menu as IconMenu,
  Setting
} from '@element-plus/icons-vue'

const isSidebarVisible = ref(false)
const isCollapse = ref(false)

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
  window.location.href = url
}
</script>

<style scoped>
.toggle-button {
  position: absolute;
  top: 10px;
  left: 20px;
  z-index: 1000;
  cursor: pointer;
  background: #C80970;
  border-radius: 4px;
  padding: 8px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
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
  width: 240px;
  height: 100vh;
  background: linear-gradient(180deg, #C80970, #29223F);
  box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
  z-index: 1000;
  overflow-y: auto;
  color: white;
  transition: all 0.3s ease;
}

.toggle{
  color:rgb(218, 218, 218);
}

.close-button {
  font-size: 24px;
  font-weight: bold;
  padding: 10px 16px;
  cursor: pointer;
  text-align: right;
  color: white;
}

.slide-enter-active,
.slide-leave-active {
  transition: transform 0.3s ease;
}
.slide-enter-from,
.slide-leave-to {
  transform: translateX(-100%);
}

/* Custom menu item hover style */
.custom-menu >>> .el-menu-item,
.custom-menu >>> .el-sub-menu__title {
  transition: background-color 0.3s ease;
}

.custom-menu >>> .el-menu-item:hover,
.custom-menu >>> .el-sub-menu__title:hover {
  background-color: #ff69b4 !important; /* pink */
  color: white !important;
}
</style>