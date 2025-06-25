<template>
  <div class="min-h-screen flex flex-col bg-white font-sans">
    <!-- Header -->
    <header 
      class="sticky top-0 z-50 transition-all duration-300 ease-in-out"
      :class="isScrolled ? 'bg-white/95 backdrop-blur-xl shadow-lg shadow-slate-200/50' : 'bg-white/95 backdrop-blur-xl'"
    >
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
          <!-- Logo -->
          <div class="flex items-center space-x-2">
            <div class="flex flex-col">
              <h1 class="text-xl font-black text-pink-500 leading-tight">DP3AP2KB</h1>
              <span class="text-xs text-slate-500 font-medium -mt-1">Pemberdayaan Perempuan</span>
            </div>
          </div>

          <!-- Desktop Navigation -->
          <nav class="hidden md:flex items-center space-x-1">
            <div 
              v-for="item in menuItems" 
              :key="item.index"
              class="relative group"
            >
              <button
                class="flex items-center px-4 py-2 text-sm font-medium text-slate-600 hover:text-pink-500 hover:bg-pink-50 rounded-lg transition-all duration-200 ease-in-out group-hover:bg-pink-50"
                :class="{ 'text-pink-500 bg-pink-50': activeIndex === item.index }"
                @click="handleSelect(item.index)"
              >
                <component :is="item.icon" class="w-4 h-4 mr-2" />
                {{ item.label }}
                <svg 
                  v-if="item.dropdown" 
                  class="w-4 h-4 ml-1 transition-transform duration-200 group-hover:rotate-180" 
                  fill="none" 
                  stroke="currentColor" 
                  viewBox="0 0 24 24"
                >
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </button>

              <!-- Dropdown Menu -->
              <div 
                v-if="item.dropdown"
                class="absolute left-0 mt-2 w-56 bg-white rounded-xl shadow-xl shadow-slate-200/50 border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 ease-in-out transform translate-y-2 group-hover:translate-y-0"
              >
                <div class="py-2">
                  <a
                    v-for="subItem in item.dropdown"
                    :key="subItem.name"
                    :href="subItem.href"
                    class="flex items-center px-4 py-3 text-sm text-slate-700 hover:text-pink-500 hover:bg-pink-50 transition-colors duration-150"
                  >
                    <component :is="subItem.icon" class="w-4 h-4 mr-3 text-slate-400" />
                    <div>
                      <div class="font-medium">{{ subItem.name }}</div>
                      <div class="text-xs text-slate-500 mt-0.5">{{ subItem.description }}</div>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </nav>

          <!-- Mobile menu button -->
          <button
            @click="toggleSidebar"
            class="md:hidden p-2 rounded-lg text-slate-600 hover:text-pink-500 hover:bg-pink-50 transition-colors duration-200"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>
      </div>
    </header>

    <!-- Mobile Sidebar -->
    <div 
      v-if="sidebarVisible"
      class="fixed inset-0 z-50 md:hidden"
      @click="sidebarVisible = false"
    >
      <div class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
      <div class="fixed left-0 top-0 h-full w-80 bg-white shadow-2xl transform transition-transform duration-300 ease-in-out">
        <div class="flex items-center justify-between p-4 border-b border-slate-200">
          <div class="flex flex-col">
            <h2 class="text-lg font-black text-pink-500">DP3AP2KB</h2>
            <span class="text-xs text-slate-500 font-medium">Menu Navigasi</span>
          </div>
          <button
            @click="sidebarVisible = false"
            class="p-2 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors duration-200"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        
        <nav class="p-4 space-y-2">
          <div v-for="item in menuItems" :key="item.index">
            <button
              class="w-full flex items-center px-4 py-3 text-sm font-medium text-slate-700 hover:text-pink-500 hover:bg-pink-50 rounded-lg transition-all duration-200"
              :class="{ 'text-pink-500 bg-pink-50': activeIndex === item.index }"
              @click="toggleMobileDropdown(item.index)"
            >
              <component :is="item.icon" class="w-5 h-5 mr-3" />
              {{ item.label }}
              <svg 
                v-if="item.dropdown"
                class="w-4 h-4 ml-auto transition-transform duration-200"
                :class="{ 'rotate-180': mobileDropdownOpen === item.index }"
                fill="none" 
                stroke="currentColor" 
                viewBox="0 0 24 24"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            
            <!-- Mobile Dropdown -->
            <div 
              v-if="item.dropdown && mobileDropdownOpen === item.index"
              class="ml-4 mt-2 space-y-1 border-l-2 border-pink-100 pl-4"
            >
              <a
                v-for="subItem in item.dropdown"
                :key="subItem.name"
                :href="subItem.href"
                class="flex items-center px-3 py-2 text-sm text-slate-600 hover:text-pink-500 hover:bg-pink-50 rounded-lg transition-colors duration-150"
                @click="sidebarVisible = false"
              >
                <component :is="subItem.icon" class="w-4 h-4 mr-3 text-slate-400" />
                <div>
                  <div class="font-medium">{{ subItem.name }}</div>
                  <div class="text-xs text-slate-500">{{ subItem.description }}</div>
                </div>
              </a>
            </div>
          </div>
        </nav>
      </div>
    </div>

    <!-- Main Content -->
    <main class="flex-1">
      <slot />
    </main>

    <!-- Footer -->
    <footer class="bg-slate-800 text-slate-300 mt-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-12 mb-12">
          <!-- Brand Section -->
          <div class="lg:col-span-2">
            <div class="mb-6">
              <h3 class="text-2xl font-black text-pink-400 mb-3">DP3AP2KB</h3>
              <p class="text-slate-300 text-base leading-relaxed mb-4">
                Dinas Pemberdayaan Perempuan, Perlindungan Anak dan Keluarga Berencana
              </p>
              <p class="text-pink-300 italic text-sm font-medium">
                "Membangun Indonesia yang Adil Gender dan Ramah Anak"
              </p>
            </div>
            
            <!-- Social Media -->
            <div class="flex space-x-4">
              <a 
                v-for="social in socialLinks" 
                :key="social.name"
                :href="social.href"
                class="w-10 h-10 bg-slate-700 hover:bg-pink-500 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110"
              >
                <component :is="social.icon" class="w-5 h-5" />
              </a>
            </div>
          </div>

          <!-- Quick Links -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-8 lg:col-span-2">
            <div v-for="column in footerColumns" :key="column.title">
              <h4 class="text-white font-bold text-lg mb-6 relative">
                {{ column.title }}
                <span class="absolute bottom-0 left-0 w-8 h-0.5 bg-pink-400 rounded-full"></span>
              </h4>
              <ul class="space-y-3">
                <li v-for="link in column.links" :key="link.name">
                  <a 
                    :href="link.href"
                    class="text-slate-400 hover:text-pink-300 transition-colors duration-200 flex items-center group"
                  >
                    <svg class="w-3 h-3 mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    {{ link.name }}
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Contact Info -->
        <div class="border-t border-slate-700 pt-8 mb-8">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="flex items-center space-x-3">
              <div class="w-10 h-10 bg-pink-500 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </div>
              <div>
                <p class="text-white font-semibold">Alamat</p>
                <p class="text-slate-400 text-sm">Jl. Contoh No. 123, Jakarta</p>
              </div>
            </div>
            
            <div class="flex items-center space-x-3">
              <div class="w-10 h-10 bg-pink-500 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
              </div>
              <div>
                <p class="text-white font-semibold">Telepon</p>
                <p class="text-slate-400 text-sm">(021) 1234-5678</p>
              </div>
            </div>
            
            <div class="flex items-center space-x-3">
              <div class="w-10 h-10 bg-pink-500 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
              </div>
              <div>
                <p class="text-white font-semibold">Email</p>
                <p class="text-slate-400 text-sm">info@dp3ap2kb.go.id</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Bottom Footer -->
        <div class="border-t border-slate-700 pt-8 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
          <p class="text-slate-400 text-sm">
            &copy; 2025 DP3AP2KB. Semua hak dilindungi undang-undang.
          </p>
          <p class="text-slate-400 text-sm flex items-center">
            Dikembangkan dengan 
            <svg class="w-4 h-4 mx-1 text-pink-400" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
            untuk Indonesia yang lebih baik
          </p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

// Reactive state
const isScrolled = ref(false)
const sidebarVisible = ref(false)
const activeIndex = ref('1')
const mobileDropdownOpen = ref(null)

// Menu items dengan dropdown
const menuItems = ref([
  {
    index: '1',
    label: 'Beranda',
    icon: 'HomeIcon',
    dropdown: null
  },
  {
    index: '2',
    label: 'Profil',
    icon: 'UserGroupIcon',
    dropdown: [
      {
        name: 'Tentang Kami',
        description: 'Sejarah dan visi misi',
        href: '/tentang',
        icon: 'InformationCircleIcon'
      },
      {
        name: 'Struktur Organisasi',
        description: 'Susunan pengurus',
        href: '/struktur',
        icon: 'UserGroupIcon'
      },
      {
        name: 'Tugas & Fungsi',
        description: 'Peran dan tanggung jawab',
        href: '/tugas',
        icon: 'ClipboardDocumentListIcon'
      }
    ]
  },
  {
    index: '3',
    label: 'Layanan',
    icon: 'CogIcon',
    dropdown: [
      {
        name: 'Program Pelatihan',
        description: 'Pelatihan pemberdayaan',
        href: '/pelatihan',
        icon: 'AcademicCapIcon'
      },
      {
        name: 'Pengaduan Online',
        description: 'Layanan pengaduan',
        href: '/pengaduan',
        icon: 'ExclamationTriangleIcon'
      },
      {
        name: 'Konsultasi',
        description: 'Konsultasi gratis',
        href: '/info/konsultasi',
        icon: 'ChatBubbleLeftRightIcon'
      },
      {
        name: 'Pendampingan',
        description: 'Pendampingan kasus',
        href: '/pendampingan',
        icon: 'HandRaisedIcon'
      }
    ]
  },
  {
    index: '4',
    label: 'Informasi',
    icon: 'NewspaperIcon',
    dropdown: [
      {
        name: 'Berita',
        description: 'Berita terkini',
        href: '/berita',
        icon: 'NewspaperIcon'
      },
      {
        name: 'Pengumuman',
        description: 'Pengumuman resmi',
        href: '/pengumuman',
        icon: 'SpeakerWaveIcon'
      },
      {
        name: 'Agenda Kegiatan',
        description: 'Jadwal kegiatan',
        href: '/agenda',
        icon: 'CalendarDaysIcon'
      },
      {
        name: 'Galeri',
        description: 'Dokumentasi kegiatan',
        href: '/galeri',
        icon: 'PhotoIcon'
      }
    ]
  },
  {
    index: '5',
    label: 'Kontak',
    icon: 'PhoneIcon',
    dropdown: null
  }
])

// Footer data
const footerColumns = ref([
  {
    title: 'Layanan',
    links: [
      { name: 'Program Pelatihan', href: '/pelatihan' },
      { name: 'Pengaduan Online', href: '/pengaduan' },
      { name: 'Konsultasi', href: '/info/konsultasi' },
      { name: 'Pendampingan', href: '/pendampingan' }
    ]
  },
  {
    title: 'Dukungan',
    links: [
      { name: 'Pusat Bantuan', href: '/bantuan' },
      { name: 'FAQ', href: '/faq' },
      { name: 'Hubungi Kami', href: '/kontak' },
      { name: 'Feedback', href: '/feedback' }
    ]
  }
])

const socialLinks = ref([
  {
    name: 'Facebook',
    href: '#',
    icon: 'FacebookIcon'
  },
  {
    name: 'Twitter',
    href: '#',
    icon: 'TwitterIcon'
  },
  {
    name: 'Instagram',
    href: '#',
    icon: 'InstagramIcon'
  },
  {
    name: 'YouTube',
    href: '#',
    icon: 'YouTubeIcon'
  }
])

// Methods
const handleScroll = () => {
  isScrolled.value = window.scrollY > 10
}

const handleSelect = (index) => {
  activeIndex.value = index
  // Add navigation logic here
}

const toggleSidebar = () => {
  sidebarVisible.value = !sidebarVisible.value
}

const toggleMobileDropdown = (index) => {
  mobileDropdownOpen.value = mobileDropdownOpen.value === index ? null : index
}

// Lifecycle
onMounted(() => {
  window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>