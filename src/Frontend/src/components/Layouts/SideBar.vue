<template>
  <!-- Tombol Toggle Sidebar -->
  <button
    class="fixed z-[10001] p-2 text-gray-600 bg-white rounded-xl shadow-lg hover:shadow-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-opacity-50 transition-all duration-300 group"
    @click="openSidebar"
    v-show="!isSidebarVisible"
  >
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 group-hover:text-pink-500 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
    </svg>
  </button>

  <!-- Overlay dan Sidebar -->
  <teleport to="body">
    <!-- Overlay -->
    <div
      v-show="isSidebarVisible"
      class="fixed inset-0 z-[10000] bg-black/60 backdrop-blur-sm"
      @click="closeSidebar"
    ></div>

    <!-- Sidebar -->
    <transition name="slide">
      <div
        v-show="isSidebarVisible"
        class="fixed top-0 left-0 h-screen w-80 bg-white shadow-2xl z-[10001] flex flex-col"
      >
        <!-- Header Sidebar -->
        <div class="bg-gradient-to-r from-pink-500 to-pink-600 p-6 text-white relative overflow-hidden">
          <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>
          <div class="relative z-10 flex justify-between items-center">
            <div>
              <h2 class="text-xl font-bold mb-1">Admin Panel</h2>
              <p class="text-pink-100 text-sm">Sistem Manajemen</p>
            </div>
            <button 
              class="p-2 text-pink-100 hover:text-white hover:bg-white/20 rounded-lg transition-all duration-300" 
              @click="closeSidebar"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Menu Navigation -->
        <div class="flex-1 overflow-y-auto py-4 px-3">
          <nav class="space-y-2">
            <!-- Beranda -->
            <div
              class="group flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-gray-50 hover:text-pink-600 cursor-pointer transition-all duration-300"
              :class="{ 'bg-pink-50 text-pink-600 shadow-sm': activeIndex === '1' }"
              @click="navigate('/', '1')"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 group-hover:text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
              </svg>
              <span class="font-medium">Beranda</span>
            </div>

            <!-- Dashboard -->
            <div
              class="group flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-gray-50 hover:text-pink-600 cursor-pointer transition-all duration-300"
              :class="{ 'bg-pink-50 text-pink-600 shadow-sm': activeIndex === '2' }"
              @click="navigate('/dashboard', '2')"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 group-hover:text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
              <span class="font-medium">Dashboard</span>
            </div>

            <!-- Test Section -->
            <div class="mb-2">
              <div
                class="group flex items-center justify-between px-4 py-3 text-gray-700 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-300"
                @click="toggleSubmenu('test')"
              >
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 group-hover:text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                  <span class="font-medium">Test</span>
                </div>
                <svg 
                  xmlns="http://www.w3.org/2000/svg" 
                  class="w-4 h-4 transition-transform duration-300"
                  :class="{ 'rotate-180': openSubmenus.test }"
                  fill="none" 
                  viewBox="0 0 24 24" 
                  stroke="currentColor"
                >
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
              <transition name="submenu">
                <div v-show="openSubmenus.test" class="ml-8 mt-1 space-y-1">
                  <div
                    class="flex items-center px-4 py-2 text-gray-600 rounded-lg hover:bg-pink-50 hover:text-pink-600 cursor-pointer transition-all duration-300"
                    :class="{ 'bg-pink-50 text-pink-600': activeIndex === '3-1' }"
                    @click="navigate('/test/pretest', '3-1')"
                  >
                    <div class="w-2 h-2 bg-gray-400 rounded-full mr-3"></div>
                    <span class="text-sm font-medium">Pretest</span>
                  </div>
                  <div
                    class="flex items-center px-4 py-2 text-gray-600 rounded-lg hover:bg-pink-50 hover:text-pink-600 cursor-pointer transition-all duration-300"
                    :class="{ 'bg-pink-50 text-pink-600': activeIndex === '3-2' }"
                    @click="navigate('/test/posttest', '3-2')"
                  >
                    <div class="w-2 h-2 bg-gray-400 rounded-full mr-3"></div>
                    <span class="text-sm font-medium">Posttest</span>
                  </div>
                  <div
                    class="flex items-center px-4 py-2 text-gray-600 rounded-lg hover:bg-pink-50 hover:text-pink-600 cursor-pointer transition-all duration-300"
                    :class="{ 'bg-pink-50 text-pink-600': activeIndex === '3-3' }"
                    @click="navigate('/test/data-nilai', '3-3')"
                  >
                    <div class="w-2 h-2 bg-gray-400 rounded-full mr-3"></div>
                    <span class="text-sm font-medium">Data Nilai</span>
                  </div>
                </div>
              </transition>
            </div>

            <!-- Pelatihan Section -->
            <div class="mb-2">
              <div
                class="group flex items-center justify-between px-4 py-3 text-gray-700 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-300"
                @click="toggleSubmenu('pelatihan')"
              >
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 group-hover:text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                  </svg>
                  <span class="font-medium">Pelatihan</span>
                </div>
                <svg 
                  xmlns="http://www.w3.org/2000/svg" 
                  class="w-4 h-4 transition-transform duration-300"
                  :class="{ 'rotate-180': openSubmenus.pelatihan }"
                  fill="none" 
                  viewBox="0 0 24 24" 
                  stroke="currentColor"
                >
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
              <transition name="submenu">
                <div v-show="openSubmenus.pelatihan" class="ml-8 mt-1 space-y-1">
                  <div
                    class="flex items-center px-4 py-2 text-gray-600 rounded-lg hover:bg-pink-50 hover:text-pink-600 cursor-pointer transition-all duration-300"
                    :class="{ 'bg-pink-50 text-pink-600': activeIndex === '4-1' }"
                    @click="navigate('/pelatihan/pendaftar', '4-1')"
                  >
                    <div class="w-2 h-2 bg-gray-400 rounded-full mr-3"></div>
                    <span class="text-sm font-medium">Data Pendaftar</span>
                  </div>
                  <div
                    class="flex items-center px-4 py-2 text-gray-600 rounded-lg hover:bg-pink-50 hover:text-pink-600 cursor-pointer transition-all duration-300"
                    :class="{ 'bg-pink-50 text-pink-600': activeIndex === '4-2' }"
                    @click="navigate('/pelatihan/peserta', '4-2')"
                  >
                    <div class="w-2 h-2 bg-gray-400 rounded-full mr-3"></div>
                    <span class="text-sm font-medium">Data Peserta Pelatihan</span>
                  </div>
                </div>
              </transition>
            </div>

            <!-- Pengaduan Section -->
            <div class="mb-2">
              <div
                class="group flex items-center justify-between px-4 py-3 text-gray-700 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-300"
                @click="toggleSubmenu('pengaduan')"
              >
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 group-hover:text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                  </svg>
                  <span class="font-medium">Pengaduan</span>
                </div>
                <svg 
                  xmlns="http://www.w3.org/2000/svg" 
                  class="w-4 h-4 transition-transform duration-300"
                  :class="{ 'rotate-180': openSubmenus.pengaduan }"
                  fill="none" 
                  viewBox="0 0 24 24" 
                  stroke="currentColor"
                >
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
              <transition name="submenu">
                <div v-show="openSubmenus.pengaduan" class="ml-8 mt-1 space-y-1">
                  <div
                    class="flex items-center px-4 py-2 text-gray-600 rounded-lg hover:bg-pink-50 hover:text-pink-600 cursor-pointer transition-all duration-300"
                    :class="{ 'bg-pink-50 text-pink-600': activeIndex === '5-1' }"
                    @click="navigate('/pengaduan/data', '5-1')"
                  >
                    <div class="w-2 h-2 bg-gray-400 rounded-full mr-3"></div>
                    <span class="text-sm font-medium">Data Pengaduan</span>
                  </div>
                  <div
                    class="flex items-center px-4 py-2 text-gray-600 rounded-lg hover:bg-pink-50 hover:text-pink-600 cursor-pointer transition-all duration-300"
                    :class="{ 'bg-pink-50 text-pink-600': activeIndex === '5-2' }"
                    @click="navigate('/pengaduan/konsultasi', '5-2')"
                  >
                    <div class="w-2 h-2 bg-gray-400 rounded-full mr-3"></div>
                    <span class="text-sm font-medium">Data Konsultasi</span>
                  </div>
                </div>
              </transition>
            </div>

            <!-- Kelola Data -->
            <div
              class="group flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-gray-50 hover:text-pink-600 cursor-pointer transition-all duration-300"
              :class="{ 'bg-pink-50 text-pink-600 shadow-sm': activeIndex === '6' }"
              @click="navigate('/kelola-data', '6')"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 group-hover:text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
              </svg>
              <span class="font-medium">Kelola Data</span>
            </div>

            <!-- Kelola Akses -->
            <div
              class="group flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-gray-50 hover:text-pink-600 cursor-pointer transition-all duration-300"
              :class="{ 'bg-pink-50 text-pink-600 shadow-sm': activeIndex === '7' }"
              @click="navigate('/kelola-akses', '7')"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 group-hover:text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
              <span class="font-medium">Kelola Akses</span>
            </div>
          </nav>
        </div>

        <!-- Footer Sidebar -->
        <div class="border-t border-gray-100 p-4">
          <div
            class="group flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-red-50 hover:text-red-600 cursor-pointer transition-all duration-300"
            @click="handleLogout"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 group-hover:text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span class="font-medium">Logout</span>
          </div>
        </div>
      </div>
    </transition>
  </teleport>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue';
import { useRouter } from 'vue-router';

// Tipe union untuk submenu key
type MenuKey = 'test' | 'pelatihan' | 'pengaduan';

const isSidebarVisible = ref(false);
const activeIndex = ref('1');
const router = useRouter();

// Menentukan reaktifitas dan tipe yang tepat untuk submenu
const openSubmenus = reactive<Record<MenuKey, boolean>>({
  test: false,
  pelatihan: false,
  pengaduan: false
});

// Toggle submenu dengan tipe yang aman
const toggleSubmenu = (menu: MenuKey) => {
  openSubmenus[menu] = !openSubmenus[menu];
};

const openSidebar = () => {
  isSidebarVisible.value = true;
};

const closeSidebar = () => {
  isSidebarVisible.value = false;
};

const navigate = (url: string, index?: string) => {
  if (index) {
    activeIndex.value = index;
  }
  closeSidebar();
  router.push(url);
};

const handleLogout = () => {
  localStorage.clear();
  router.push('/login/masyarakat');
};
</script>

<style scoped>
.slide-enter-active,
.slide-leave-active {
  transition: transform 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.slide-enter-from,
.slide-leave-to {
  transform: translateX(-100%);
}

.submenu-enter-active,
.submenu-leave-active {
  transition: all 0.3s ease;
  transform-origin: top;
}

.submenu-enter-from,
.submenu-leave-to {
  opacity: 0;
  transform: scaleY(0);
}
</style>