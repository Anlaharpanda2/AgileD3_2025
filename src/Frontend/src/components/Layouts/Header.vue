<template>
  <header
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 ease-out"
    :class="{ 
      'bg-white/95 backdrop-blur-md shadow-sm border-b border-gray-100': isScrolled, 
      'bg-transparent': !isScrolled 
    }"
  >
    <div class="max-w-screen-xl mx-auto px-8 lg:px-8">
      <div class="flex items-center justify-between h-16">
        
        <!-- Header Kiri - Logo dan Nama Aplikasi -->
        <div class="flex items-center space-x-4 group">
          <!-- Sidebar Component -->
          <sidebar />
          
          <!-- Container Logo dan Text -->
          <div class="flex items-center space-x-3">
            <!-- Logo Container dengan Advanced Effects -->
            <div class="relative">
              <!-- Main Logo Container -->
              <div 
                class="w-12 h-12 flex items-center justify-center rounded-2xl transform hover:scale-110 transition-all duration-500 group-hover:rotate-6"
                :class="isScrolled 
                  ? 'bg-white border border-gray-200/50 hover:border-gray-300/50' 
                  : 'bg-white shadow-lg hover:shadow-2xl border border-pink-400/30 hover:border-pink-400/50'"
              >
                
                <!-- Animated Background Pulse (hanya saat tidak scroll) -->
                <div 
                  class="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 animate-pulse transition-all duration-700"
                  :class="isScrolled ? '' : 'bg-gradient-to-br from-pink-400/30 to-pink-600/30'"
                ></div>
                
                <!-- Multi-layer Shine Effect -->
                <div class="absolute inset-0 bg-gradient-to-tr from-white/30 via-pink-200/20 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="absolute top-1 left-1 w-3 h-3 bg-white/40 rounded-full blur-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <!-- Logo Image -->
                <img 
                  src="/Header/Logo.png" 
                  alt="Pepsiku Burger Logo" 
                  class="w-8 h-8 object-contain relative z-20 filter hover:brightness-110 transition-all duration-300"
                />
                
                <!-- Inner Glow Ring (hanya saat tidak scroll) -->
                <div 
                  class="absolute inset-1 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                  :class="isScrolled ? '' : 'border border-pink-300/40'"
                ></div>
              </div>
              
              <!-- Outer Glow Effects (hanya saat tidak scroll) -->
              <div 
                class="absolute inset-0 rounded-2xl blur-lg opacity-0 group-hover:opacity-70 transition-all duration-500 -z-10 animate-pulse"
                :class="isScrolled ? '' : 'bg-pink-500/40'"
              ></div>
              <div 
                class="absolute -inset-1 rounded-3xl blur-xl opacity-0 group-hover:opacity-50 transition-all duration-700 -z-20"
                :class="isScrolled ? '' : 'bg-gradient-to-br from-pink-400/20 to-pink-600/20'"
              ></div>
            </div>
            
            <!-- Brand Name dengan Advanced Typography -->
            <div class="flex flex-col relative">
              <!-- Background Glow untuk Text (hanya saat tidak scroll) -->
              <div 
                class="absolute inset-0 blur-xl rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-500 -z-10"
                :class="isScrolled ? '' : 'bg-pink-500/10'"
              ></div>
              
              <h1 
                class="text-2xl font-bold tracking-tight leading-none transition-all duration-500 relative"
                :class="isScrolled 
                  ? 'text-gray-900 hover:text-gray-700 hover:drop-shadow-sm' 
                  : 'group-hover:text-pink-500'"
              >
                <!-- Text dengan Conditional Styling -->
                <span 
                  v-if="!isScrolled"
                  class="bg-gradient-to-r from-pink-600 via-pink-500 to-pink-600 bg-clip-text text-transparent font-extrabold"
                >
                  PEPSIKU
                </span>
                <span 
                  v-else
                  class="text-gray-900 font-extrabold"
                >
                  PEPSIKU
                </span>
              </h1>
              
              <span 
                class="text-xs font-semibold tracking-widest uppercase transition-all duration-500 mt-0.5"
                :class="isScrolled  
                  ? 'text-pink-500/95 group-hover:text-pink-400' 
                  : 'text-black-500 group-hover:text-gray-600'"
              >
                <span class="relative">
                  BURGER
                  <!-- Underline Effect (hanya saat tidak scroll) -->
                  <div 
                    v-if="!isScrolled"
                    class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-pink-400 to-pink-600 group-hover:w-full transition-all duration-700"
                  ></div>
                </span>
              </span>
            </div>
          </div>
        </div>

        <!-- Navigasi Desktop -->
        <nav class="hidden lg:block flex-grow">
          <ul class="flex justify-center space-x-2">
            <template v-for="item in navigationMenu" :key="item.name">
              <!-- Item Menu Tunggal -->
              <li 
                v-if="!item.children" 
                class="relative"
                :class="{
                  'rounded-full': true,
                  'px-4 py-2': true,
                  'font-medium text-sm flex items-center h-10 transition-all duration-200 ease-in-out cursor-pointer whitespace-nowrap transform hover:-translate-y-0.5 hover:shadow-md': true,
                  
                  // Gaya umum saat TIDAK SCROLLED (semua item navigasi sama)
                  'bg-pink-500 text-white/90': !isScrolled,
                  'hover:text-white': !isScrolled,

                  // Gaya umum saat SCROLLED (semua item navigasi sama)
                  'text-gray-700': isScrolled,
                  'hover:bg-pink-400 hover:text-white': isScrolled,
                }"
              >
                <router-link :to="item.to" class="flex items-center w-full h-full">
                  <component :is="item.icon" class="w-4 h-4 mr-2" />
                  <span>{{ item.name }}</span>
                </router-link>
              </li>

              <!-- Sub Menu (dengan dropdown) -->
              <li 
                v-else 
                class="relative group"
                @mouseenter="openSubMenu(item.name)"
                @mouseleave="closeSubMenu(item.name)"
                :class="{
                  'rounded-full': true,
                  'px-4 py-2': true,
                  'font-medium text-sm flex items-center h-10 transition-all duration-200 ease-in-out cursor-pointer whitespace-nowrap transform hover:-translate-y-0.5 hover:shadow-md': true,

                  // Gaya saat TIDAK SCROLLED
                  'bg-pink-500 text-white/90': !isScrolled,
                  'hover:text-white': !isScrolled,

                  // Gaya saat SCROLLED
                  'text-gray-700': isScrolled,
                  'group-hover:bg-pink-400 group-hover:text-white': isScrolled,

                  // Gaya ACTIVE (simulasi sub-menu aktif jika salah satu anaknya aktif)
                  'bg-pink-600 text-white shadow-md': isSubMenuActive(item),
                }"
              >
                <div class="flex items-center w-full h-full">
                  <component :is="item.icon" class="w-4 h-4 mr-2" />
                  <span>{{ item.name }}</span>
                  <svg
                    class="ml-2 w-3 h-3 transition-transform duration-200"
                    :class="{ 'rotate-180': openSubMenus[item.name] }"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  >
                    <polyline points="6 9 12 15 18 9"></polyline>
                  </svg>
                </div>

                <!-- Konten Dropdown -->
                <ul 
                  v-show="openSubMenus[item.name]"
                  class="absolute top-full left-1/2 -translate-x-1/2 mt-2
                         bg-white border border-gray-200 rounded-lg shadow-md
                         py-1 z-50 min-w-[160px]
                         transition-all duration-300 ease-out transform origin-top"
                  :class="{
                    'opacity-100 scale-y-100': openSubMenus[item.name],
                    'opacity-0 scale-y-0 pointer-events-none': !openSubMenus[item.name] // Tambah pointer-events-none agar tidak bisa diklik saat tidak terlihat
                  }"
                >
                  <li
                    v-for="child in item.children"
                    :key="child.name"
                    class="px-3 py-2 text-gray-700 hover:bg-pink-500 hover:text-white
                           rounded-md transition-all duration-200 ease-in-out
                           flex items-center"
                    :class="{
                      'bg-pink-500 text-white': $route.path === child.to
                    }"
                  >
                    <router-link :to="child.to" class="flex items-center w-full h-full">
                      <component :is="child.icon" class="w-4 h-4 mr-2" />
                      <span>{{ child.name }}</span>
                    </router-link>
                  </li>
                </ul>
              </li>
            </template>
          </ul>
        </nav>

        <!-- Tombol Avatar -->
        <div class="flex items-center">
          <button class="w-9 h-9 rounded-full focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2">
            <Avatar 
              class="w-9 h-9 rounded-full ring-1 transition-all duration-300" 
              :class="isScrolled ? 'ring-gray-200' : 'ring-white/30'"
            />
          </button>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, onMounted, onUnmounted, shallowRef } from 'vue'
import { useRoute } from 'vue-router' // Import useRoute untuk akses path saat ini
import { Sidebar } from 'lucide-vue-next'

// Import ikon dari Lucide
import { Home, FileText, BookUser, MessageSquare, Pencil, ClipboardCheck, Database, FileQuestion, MessageCircle, Users2, UserCog } from 'lucide-vue-next'
// Asumsi path komponen Avatar
// Pastikan Anda memiliki komponen Avatar di '@/components/layouts/Avatar.vue'
// Jika tidak, ganti atau buat placeholder seperti yang ada di contoh React sebelumnya.
import Avatar from '@/components/layouts/Avatar.vue' 

const route = useRoute() // Dapatkan objek rute saat ini

// DATA MENU (Struktur data sudah diubah)
const navigationMenu = shallowRef([
  { name: 'BERANDA', to: '/', icon: Home},
  { name: 'TEST', icon: FileText, children: [
    { name: 'Pretest', to: '/data/pelatihan', icon: Pencil },
    { name: 'Posttest', to: '/posttest', icon: ClipboardCheck },
    { name: 'Data Nilai', to: '/data-nilai', icon: Database },
  ]},
  { name: 'PELATIHAN', icon: BookUser, children: [
    { name: 'Data Pendaftar', to: '/data-pendaftar', icon: Users2 },
    { name: 'Data Peserta', to: '/data-peserta', icon: UserCog },
  ]},
  { name: 'PENGADUAN', icon: MessageSquare, children: [
    { name: 'Data Pengaduan', to: '/data-pengaduan', icon: FileQuestion },
    { name: 'Data Konsultasi', to: '/data-konsultasi', icon: MessageCircle },
  ]},
]);

const isScrolled = ref(false)

// State untuk melacak sub-menu mana yang terbuka
const openSubMenus = ref({});
let subMenuTimeout = null;

// Fungsi untuk membuka sub-menu
const openSubMenu = (menuName) => {
  clearTimeout(subMenuTimeout);
  Object.keys(openSubMenus.value).forEach(key => {
    if (key !== menuName) {
      openSubMenus.value[key] = false; // Tutup sub-menu lain
    }
  });
  openSubMenus.value[menuName] = true;
};

// Fungsi untuk menutup sub-menu dengan sedikit penundaan
const closeSubMenu = (menuName) => {
  subMenuTimeout = setTimeout(() => {
    openSubMenus.value[menuName] = false;
  }, 150); // Penundaan 150ms
};

// Fungsi untuk mengecek apakah sub-menu aktif (jika salah satu anaknya aktif)
const isSubMenuActive = (menuItem) => {
  if (menuItem.children) {
    return menuItem.children.some(child => route.path === child.to);
  }
  return false;
};

// Handle scroll event
const handleScroll = () => {
  isScrolled.value = window.scrollY > 20
}

// Lifecycle hooks
onMounted(() => {
  window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<style scoped>
/*
  Tidak ada gaya CSS kustom di sini yang memerlukan :deep atau !important.
  Semua styling kini ditangani langsung oleh kelas Tailwind CSS di template.
  
  Animasi dropdown ditangani dengan kelas transisi Tailwind:
  opacity-0 scale-y-0 transform origin-top group-hover:opacity-100 group-hover:scale-y-100
  Ini membuat transisi muncul dan menghilang yang serupa dengan Element Plus.
*/
</style>
