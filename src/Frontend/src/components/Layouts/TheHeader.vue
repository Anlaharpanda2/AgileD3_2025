<template>
  <header
    class="top-0 left-0 right-0 z-50 transition-all duration-300 ease-out"
    :class="[
      isHomeRoute ? 'fixed' : 'relative',
      isScrolled 
        ? 'bg-white/95 backdrop-blur-md shadow-md border-b border-gray-100 pt-0' 
        : 'bg-transparent pt-5'
    ]"
  >
    <div class="mx-auto px-8 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <!-- Logo & Branding -->
        <div class="flex items-center space-x-4 group">
          <div class="w-10 h-10">
            <sidebar />
          </div>
          <div class="flex items-center space-x-3">
            <!-- Logo -->
            <div class="relative">
              <div
                class="w-12 h-12 flex items-center justify-center rounded-2xl
                       transform hover:scale-110 transition-all duration-500 group-hover:rotate-6
                       bg-white shadow-lg border border-pink-400/30 hover:shadow-2xl hover:border-pink-400/50"
                :class="isScrolled
                  ? 'bg-white border-gray-200/50 hover:border-gray-300/50 shadow-sm'
                  : ''"
              >
                <img
                  src="/Header/Logo.png"
                  alt="Pepsiku Burger Logo"
                  class="w-8 h-8 object-contain relative z-20 filter
                         hover:brightness-110 transition-all duration-300"
                >
                <!-- Glow effects hanya non-scroll -->
                <div
                  v-if="!isScrolled"
                  class="absolute inset-0 rounded-2xl bg-gradient-to-br
                         from-pink-400/30 to-pink-600/30 opacity-0
                         group-hover:opacity-100 animate-pulse transition-all duration-700"
                />
              </div>
            </div>

            <!-- Brand Text -->
            <div class="flex flex-col relative">
              <h1
                class="text-2xl font-bold tracking-tight leading-none transition-all duration-500"
                :class="isScrolled
                  ? 'text-gray-900 hover:text-gray-700 hover:drop-shadow-sm'
                  : 'group-hover:text-pink-500'"
              >
                <span
                  v-if="!isScrolled"
                  class="bg-clip-text text-transparent bg-gradient-to-r
                             from-pink-600 via-pink-500 to-pink-600 font-extrabold"
                >
                  PEPSIKU
                </span>
                <span
                  v-else
                  class="text-gray-900 font-extrabold"
                >PEPSIKU</span>
              </h1>
              <span
                class="text-xs font-semibold tracking-widest uppercase transition-all duration-500"
                :class="isScrolled
                  ? 'text-pink-500/95 group-hover:text-pink-400'
                  : 'text-black group-hover:text-gray-600'"
              >
                BURGER
              </span>
            </div>
          </div>
        </div>

        <!-- Navigation -->
        <nav class="hidden lg:block max-w-screen-xl">
          <ul
            class="flex justify-center space-x-2"
            style="padding-right: 170px;"
          >
            <template
              v-for="item in navigationMenu"
              :key="item.name"
            >
              <!-- Single Item -->
              <li
                v-if="!item.children"
                class="relative rounded-full px-3 py-1 font-medium text-xs flex items-center h-8
                       transition-all duration-200 ease-in-out cursor-pointer whitespace-nowrap
                       transform hover:-translate-y-0.5 hover:shadow-md
                       hover:bg-pink-500 hover:!text-white"
                :class="{
                  'text-black': !isScrolled,
                  'text-gray-700': isScrolled
                }"
              >
                <router-link
                  :to="item.to"
                  class="flex items-center w-full h-full"
                >
                  <component
                    :is="item.icon"
                    class="w-4 h-4 mr-1"
                  />
                  <span>{{ item.name }}</span>
                </router-link>
              </li>

              <!-- Dropdown Item -->
              <li
                v-else
                class="relative group rounded-full px-3 py-1 font-medium text-xs flex items-center h-8
                       transition-all duration-200 ease-in-out cursor-pointer whitespace-nowrap
                       transform hover:-translate-y-0.5 hover:shadow-md
                       hover:bg-pink-500 hover:!text-white"
                :class="{
                  'text-black': !isScrolled,
                  'text-gray-700': isScrolled,
                  'bg-pink-600 text-white shadow-md': isSubMenuActive(item)
                }"
                @mouseenter="openSubMenu(item.name)"
                @mouseleave="closeSubMenu(item.name)"
              >
                <div class="flex items-center w-full h-full">
                  <component
                    :is="item.icon"
                    class="w-4 h-4 mr-1"
                  />
                  <span>{{ item.name }}</span>
                  <svg
                    class="ml-1 w-3 h-3 transition-transform duration-200"
                    :class="{ 'rotate-180': openSubMenus[item.name] }"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  >
                    <polyline points="6 9 12 15 18 9" />
                  </svg>
                </div>

                <!-- Submenu Dropdown -->
                <ul
                  v-show="openSubMenus[item.name]"
                  class="absolute top-full left-1/2 -translate-x-1/2 mt-2
                         bg-white border border-gray-200 rounded-lg shadow-md
                         py-1 z-50 min-w-[160px]
                         transition-all duration-300 ease-out transform origin-top"
                  :class="{
                    'opacity-100 scale-y-100': openSubMenus[item.name],
                    'opacity-0 scale-y-0 pointer-events-none': !openSubMenus[item.name]
                  }"
                >
                  <li
                    v-for="child in item.children"
                    :key="child.name"
                    class="px-3 py-2 text-gray-700 rounded-md transition-all duration-200 ease-in-out
                           flex items-center text-xs hover:bg-pink-500 hover:text-white"
                    :class="{ 'bg-pink-500 text-white': isChildActive(child, item.name) }"
                  >
                    <router-link
                      :to="child.to"
                      class="flex items-center w-full h-full"
                    >
                      <component
                        :is="child.icon"
                        class="w-4 h-4 mr-1"
                      />
                      <span>{{ child.name }}</span>
                    </router-link>
                  </li>
                </ul>
              </li>
            </template>
          </ul>
        </nav>

        <!-- Avatar Button -->
        <div class="flex items-center">
          <button
            class="w-9 h-9 rounded-full focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2"
          >
            <UserProfileAvatar
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
import { ref, onMounted, onUnmounted, watch, computed } from 'vue'
import { useRoute } from 'vue-router'
import sidebar from './SideBar.vue'
import {
  Home, FileText, BookUser, MessageSquare,
  Pencil, ClipboardCheck, Database, FileQuestion,
  MessageCircle, Users2, UserCog
} from 'lucide-vue-next'
import UserProfileAvatar from './UserProfileAvatar.vue'

const route = useRoute()

const getUserRole = () => localStorage.getItem('role') || ''

// Mendapatkan daftar role efektif (asli + virtual)
const getEffectiveRoles = () => {
  const role = getUserRole()
  const roles = [role]

  // Tambahkan role virtual 'bukanOP' jika bukan operator dan bukan pegawai
  if (role !== 'operator' && role !== 'pegawai') {
    roles.push('bukanOP')
  }

  return roles
}

// Raw menu array dengan pembatasan role
const rawMenu = [
  { name: 'BERANDA', to: '/', icon: Home },

  {
    name: 'TEST', icon: FileText, roles: ['operator', 'pegawai', 'masyarakat'], children: [
      { name: 'Pretest', to: '/pretests', icon: Pencil },
      { name: 'Posttest', to: '/posttests', icon: ClipboardCheck },
      { name: 'Data Nilai', to: '/data/nilai', icon: Database, roles: ['operator', 'pegawai'] },
      { name: 'Data Soal', to: '/data/soal', icon: Database, roles: ['operator', 'pegawai'] },
    ]
  },

  // 👇 hanya untuk masyarakat (atau bukan operator & pegawai)
  { name: 'PELATIHAN', to: '/status-pelatihan', icon: BookUser, roles: ['bukanOP'] },

  {
    name: 'PELATIHAN', icon: BookUser, roles: ['operator', 'pegawai'], children: [
      { name: 'Data Pendaftar', to: '/data/pendaftaran', icon: Users2 },
      { name: 'Data Peserta', to: '/data/pelatihan', icon: UserCog },
    ]
  },

  { name: 'PENGADUAN', to: '/pengaduan/cari', icon: MessageSquare, roles: ['bukanOP'] },
  {
    name: 'PENGADUAN', icon: MessageSquare, roles: ['operator', 'pegawai'], children: [
      { name: 'Cari Pengaduan', to: '/pengaduan/cari', icon: MessageSquare },
      { name: 'Data Pengaduan', to: '/data/pengaduan', icon: FileQuestion },
      { name: 'Data Konsultasi', to: '/data/konsultasi', icon: MessageCircle },
    ]
  },
]

// Filter menu berdasarkan role user
const navigationMenu = computed(() => {
  const effectiveRoles = getEffectiveRoles()

  const filterMenu = (item) => {
    // Cek role utama
    if (item.roles && !item.roles.some(r => effectiveRoles.includes(r))) return false

    // Filter children (submenu)
    if (item.children) {
      const filteredChildren = item.children.filter(child =>
        !child.roles || child.roles.some(r => effectiveRoles.includes(r))
      )
      if (filteredChildren.length === 0) return false
      return { ...item, children: filteredChildren }
    }

    return item
  }

  return rawMenu.map(filterMenu).filter(Boolean)
})

const isScrolled = ref(false)
const isHomeRoute = ref(route.path === '/')
const openSubMenus = ref({})
let subMenuTimeout = null

function openSubMenu(name) {
  clearTimeout(subMenuTimeout)
  Object.keys(openSubMenus.value).forEach(k => openSubMenus.value[k] = false)
  openSubMenus.value[name] = true
}

function closeSubMenu(name) {
  subMenuTimeout = setTimeout(() => openSubMenus.value[name] = false, 150)
}

function isSubMenuActive(item) {
  return item.children?.some(c => route.path === c.to) || false
}

function isChildActive(child) {
  return route.path === child.to
}

watch(() => route.path, (newPath) => {
  isHomeRoute.value = newPath === '/'
  isScrolled.value = newPath !== '/' || window.scrollY > 20
})

onMounted(() => {
  isHomeRoute.value = route.path === '/'
  isScrolled.value = route.path !== '/' || window.scrollY > 20
  window.addEventListener('scroll', handleScroll)

  // Preload rute-rute yang didefinisikan di rawMenu berdasarkan role pengguna
  setTimeout(() => {
    const role = getUserRole()
    const routesToPreload = []

    // Rute umum (tanpa batasan role)
    routesToPreload.push(
      () => import('../../views/Home/HomeView.vue'), // untuk '/'
      () => import('../../views/PengelolaDataTest/TakePretestView.vue'), // untuk '/pretests'
      () => import('../../views/PengelolaDataTest/TakePosttestView.vue') // untuk '/posttests'
    )

    // Rute untuk role 'operator' atau 'pegawai'
    if (['operator', 'pegawai'].includes(role)) {
      routesToPreload.push(
        () => import('../../views/DataNilai/DataNilaiView.vue'), // untuk '/data/nilai'
        () => import('../../views/PengelolaDataTest/TaskManagementView.vue'), // untuk '/data/soal'
        () => import('../../views/PengelolaDataPendaftaran/DataPendaftaranView.vue'), // untuk '/data/pendaftaran'
        () => import('../../views/PengelolaDataPelatihan/DataPelatihanView.vue'), // untuk '/data/pelatihan'
        () => import('../../views/PengelolaDataPengaduan/DataPengaduanView.vue'), // untuk '/data/pengaduan'
        () => import('../../views/PengelolaDataKonsultasi/DataKonsultasiView.vue'), // untuk '/data/konsultasi'
        () => import('../../components/Pengaduan/SearchPengaduan.vue') // untuk '/pengaduan/cari'
      )
    }

    // Rute untuk role 'masyarakat'
    if (role === 'masyarakat') {
      routesToPreload.push(
        () => import('../../views/DaftarMasyarakat/IkutPealtihanView.vue'), // untuk '/pelatihan' (diasumsikan '/Daftar/Pelatihan')
        () => import('../../views/PengelolaDataPengaduan/BuatPengaduanView.vue') // untuk '/pengaduan' (diasumsikan '/pengaduan/buat')
      )
    }

    routesToPreload.forEach((loadRoute) => {
      loadRoute().catch((err) => {
        console.warn('Gagal preload rute:', err)
      })
    })
  }, 1000) // Penundaan 1 detik untuk memastikan muat awal selesai
})

onUnmounted(() => window.removeEventListener('scroll', handleScroll, { passive: true }))

function handleScroll() {
  if (isHomeRoute.value) {
    isScrolled.value = window.scrollY > 20
  } else {
    isScrolled.value = true
  }
}
</script>

<style scoped>
/* Semua styling sudah menggunakan Tailwind */
</style>