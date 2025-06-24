<script setup lang="ts">
import { markRaw, ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import {
  ElMenu,
  ElMenuItem,
  ElButton,
  ElIcon,
  ElDrawer
} from 'element-plus'
import {
  House,
  DataBoard,
  Document,
  User,
  Trophy,
  Files,
  DataLine,
  Lock,
  Menu as MenuIcon
} from '@element-plus/icons-vue'
import { useWindowScroll, useDark } from '@vueuse/core'

// Router Vue untuk navigasi
const router = useRouter()

// State reaktif untuk menu aktif dan visibilitas sidebar
const activeIndex = ref('1')
const sidebarVisible = ref(false)
const { y: scrollY } = useWindowScroll() // Mendapatkan posisi scroll Y
const isDark = useDark() // Mengelola mode gelap (opsional, dari useDark)

// Properti terhitung untuk menentukan apakah halaman sudah discroll
const isScrolled = computed(() => scrollY.value > 50)

// Data menu navigasi
const menuItems = ref([
  { index: '1', label: 'BERANDA', icon: markRaw(House), route: '/' },
  { index: '2', label: 'DASHBOARD', icon: markRaw(DataBoard), route: '/dashboard' },
  { index: '3', label: 'PRE/POSTTEST', icon: markRaw(Document), route: '/preposttest' },
  { index: '4', label: 'PENDAFTAR', icon: markRaw(User), route: '/pendaftar' },
  { index: '5', label: 'PELATIHAN', icon: markRaw(Trophy), route: '/pelatihan' },
  { index: '6', label: 'PELAPORAN', icon: markRaw(Files), route: '/pelaporan' },
  { index: '7', label: 'KELOLA DATA', icon: markRaw(DataLine), route: '/kelola-data' },
  { index: '8', label: 'KELOLA AKSES', icon: markRaw(Lock), route: '/kelola-akses' }
])

// Metode untuk menangani pemilihan item menu
const handleSelect = (key: string) => {
  activeIndex.value = key
  const menuItem = menuItems.value.find(item => item.index === key)
  if (menuItem?.route) {
    router.push(menuItem.route) // Navigasi ke rute yang sesuai
  }
}

// Metode untuk mengaktifkan/menonaktifkan sidebar mobile
const toggleSidebar = () => {
  sidebarVisible.value = !sidebarVisible.value
}
</script>

<template>
  <div class="layout-container">
    <!-- Navbar (Header) -->
    <header class="navbar-container" :class="{ 'scrolled': isScrolled }">
      <div class="navbar-content">
        <div class="logo">
          <h2>DP3AP2KB</h2>
          <span class="logo-subtitle">Pemberdayaan Perempuan</span>
        </div>

        <!-- Menu Desktop -->
        <ElMenu
          :default-active="activeIndex"
          mode="horizontal"
          @select="handleSelect"
          class="navbar-menu desktop-menu"
        >
          <ElMenuItem
            v-for="item in menuItems"
            :key="item.index"
            :index="item.index"
          >
            <ElIcon><component :is="item.icon" /></ElIcon>
            <span>{{ item.label }}</span>
          </ElMenuItem>
        </ElMenu>

        <!-- Tombol Menu Mobile -->
        <ElButton
          class="mobile-menu-btn"
          @click="toggleSidebar"
          :icon="MenuIcon"
          size="large"
          text
        />
      </div>
    </header>

    <!-- Sidebar Mobile -->
    <ElDrawer
      v-model="sidebarVisible"
      title="Menu Navigasi"
      size="280px"
      direction="ltr"
    >
      <ElMenu
        :default-active="activeIndex"
        @select="handleSelect"
        class="sidebar-menu"
      >
        <ElMenuItem
          v-for="item in menuItems"
          :key="item.index"
          :index="item.index"
          @click="sidebarVisible = false"
        >
          <ElIcon><component :is="item.icon" /></ElIcon>
          <span>{{ item.label }}</span>
        </ElMenuItem>
      </ElMenu>
    </ElDrawer>

    <!-- Slot untuk konten yang akan dimasukkan dari komponen parent (Home.vue) -->
    <main class="content-area">
      <slot />
    </main>

    <!-- Footer -->
    <footer class="footer">
      <div class="container">
        <div class="footer-content">
          <div class="footer-brand">
            <h3>DP3AP2KB</h3>
            <p>Dinas Pemberdayaan Perempuan, Perlindungan Anak dan Keluarga Berencana</p>
            <p class="footer-motto">
              "Membangun Indonesia yang Adil Gender dan Ramah Anak"
            </p>
          </div>
          <div class="footer-links">
            <div class="footer-column">
              <h4>Layanan</h4>
              <ul>
                <li><a href="/pelatihan">Program Pelatihan</a></li>
                <li><a href="/pengaduan">Pengaduan Online</a></li>
                <li><a href="/konsultasi">Konsultasi</a></li>
                <li><a href="/pendampingan">Pendampingan</a></li>
              </ul>
            </div>
            <div class="footer-column">
              <h4>Informasi</h4>
              <ul>
                <li><a href="/berita">Berita</a></li>
                <li><a href="/pengumuman">Pengumuman</a></li>
                <li><a href="/agenda">Agenda Kegiatan</a></li>
                <li><a href="/galeri">Galeri</a></li>
              </ul>
            </div>
            <div class="footer-column">
              <h4>Dukungan</h4>
              <ul>
                <li><a href="/bantuan">Pusat Bantuan</a></li>
                <li><a href="/faq">FAQ</a></li>
                <li><a href="/kontak">Hubungi Kami</a></li>
                <li><a href="/feedback">Feedback</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="footer-bottom">
          <p>&copy; 2025 DP3AP2KB. Semua hak dilindungi undang-undang.</p>
          <p class="footer-credit">Dikembangkan dengan ❤️ untuk Indonesia yang lebih baik</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<style scoped>
/* Reset dasar */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.layout-container {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  background-color: #ffffff;
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
  line-height: 1.6;
}

.content-area {
  flex-grow: 1; /* Memastikan konten utama memenuhi sisa ruang */
}

/* Gaya Navbar */
.navbar-container {
  position: sticky;
  top: 0;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(12px);
  border-bottom: 1px solid #f1f5f9;
  z-index: 1000;
  transition: all 0.3s ease;
}

.navbar-container.scrolled {
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.navbar-content {
  max-width: 1400px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 2rem;
  height: 70px;
}

.logo {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.logo h2 {
  color: #ec4899;
  font-weight: 800;
  font-size: 1.5rem;
  line-height: 1;
}

.logo-subtitle {
  color: #64748b;
  font-size: 0.75rem;
  font-weight: 500;
  margin-top: -2px;
}

.desktop-menu {
  border-bottom: none;
  flex: 1;
  justify-content: center;
  max-width: 900px;
}

.navbar-menu .el-menu-item {
  color: #64748b;
  font-weight: 600;
  font-size: 0.875rem;
  padding: 0 1rem;
  transition: all 0.3s ease;
  border-radius: 8px;
  margin: 0 2px;
}

.navbar-menu .el-menu-item:hover,
.navbar-menu .el-menu-item.is-active {
  color: #ec4899;
  background-color: rgba(236, 72, 153, 0.08);
}

.navbar-menu .el-menu-item span {
  margin-left: 0.5rem;
}

.mobile-menu-btn {
  display: none; /* Sembunyikan secara default untuk desktop */
  color: #64748b;
}

/* Gaya Sidebar Mobile */
.sidebar-menu {
  border-right: none;
}

.sidebar-menu .el-menu-item {
  color: #64748b;
  font-weight: 500;
  padding: 1rem 1.5rem;
  transition: all 0.3s ease;
}

.sidebar-menu .el-menu-item:hover,
.sidebar-menu .el-menu-item.is-active {
  color: #ec4899;
  background-color: rgba(236, 72, 153, 0.08);
}

/* Gaya Footer */
.footer {
  background-color: #1e293b;
  color: #cbd5e1;
  padding: 4rem 0 2rem 0;
  border-top-left-radius: 24px;
  border-top-right-radius: 24px;
  margin-top: 4rem; /* Memberikan jarak dari konten di atasnya */
}

.footer-content {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  gap: 2rem;
  margin-bottom: 3rem;
}

.footer-brand {
  flex: 1;
  min-width: 250px;
}

.footer-brand h3 {
  font-size: 2rem;
  font-weight: 800;
  color: #ec4899;
  margin-bottom: 1rem;
}

.footer-brand p {
  font-size: 0.95rem;
  line-height: 1.6;
  margin-bottom: 0.75rem;
}

.footer-motto {
  font-style: italic;
  font-size: 0.85rem;
  color: #94a3b8;
}

.footer-links {
  display: flex;
  flex-wrap: wrap;
  gap: 2rem 4rem;
}

.footer-column {
  min-width: 150px;
}

.footer-column h4 {
  font-size: 1.1rem;
  font-weight: 700;
  color: #ffffff;
  margin-bottom: 1rem;
}

.footer-column ul {
  list-style: none;
}

.footer-column ul li {
  margin-bottom: 0.75rem;
}

.footer-column ul li a {
  color: #cbd5e1;
  text-decoration: none;
  font-size: 0.95rem;
  transition: color 0.3s ease;
}

.footer-column ul li a:hover {
  color: #ec4899;
}

.footer-bottom {
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  padding-top: 2rem;
  text-align: center;
  font-size: 0.85rem;
  color: #94a3b8;
}

.footer-bottom p {
  margin-bottom: 0.5rem;
}

.footer-credit {
  font-style: italic;
}

/* Media Queries untuk Responsif */
@media (max-width: 1024px) {
  .desktop-menu {
    display: none;
  }

  .mobile-menu-btn {
    display: block;
  }

  .navbar-content {
    padding: 0 1.5rem;
  }

  .hero-content {
    grid-template-columns: 1fr;
    text-align: center;
    gap: 2rem;
    padding: 0 1.5rem;
  }

  .hero-text {
    align-items: center;
    gap: 1.5rem;
  }

  .hero-title {
    font-size: 2.5rem;
  }

  .hero-subtitle {
    font-size: 1.1rem;
  }

  .hero-illustration {
    height: 350px;
  }

  .floating-card.main-card {
    padding: 2.5rem 2rem;
  }

  .floating-card {
    padding: 1.5rem;
  }

  .floating-card p {
    font-size: 0.8rem;
  }

  .floating-card[style] {
    position: absolute !important; /* Override inline styles */
    top: auto !important;
    left: auto !important;
    right: auto !important;
    bottom: auto !important;
    transform: none !important;
  }

  .features-section,
  .about-section,
  .services-section,
  .news-section,
  .announcements-section,
  .testimonials-section,
  .contact-section {
    padding: 4rem 0;
  }

  .container {
    padding: 0 1.5rem;
  }

  .section-title {
    font-size: 2rem;
  }

  .section-subtitle {
    font-size: 1rem;
  }

  .about-content {
    padding-right: 0;
  }

  .about-illustration {
    margin-top: 3rem;
  }

  .stats-grid {
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 1rem;
  }

  .footer-content {
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  .footer-links {
    flex-direction: column;
    align-items: center;
    gap: 1.5rem;
  }
}

@media (max-width: 768px) {
  .hero-title {
    font-size: 2rem;
  }

  .hero-subtitle {
    font-size: 1rem;
  }

  .cta-button,
  .secondary-button {
    font-size: 1rem;
    padding: 0.8rem 1.8rem;
  }

  .section-title {
    font-size: 1.8rem;
  }

  .section-subtitle {
    font-size: 0.95rem;
  }

  .feature-card {
    padding: 2.5rem 1.5rem;
  }

  .feature-title {
    font-size: 1.3rem;
  }

  .feature-description {
    font-size: 0.9rem;
  }

  .service-card {
    padding: 2rem 1.5rem;
  }

  .service-title {
    font-size: 1.1rem;
  }

  .service-description {
    font-size: 0.85rem;
  }

  .news-card {
    margin-bottom: 1.5rem;
  }

  .announcement-card {
    flex-direction: column;
    text-align: center;
    gap: 0.75rem;
  }

  .announcement-icon {
    margin-bottom: 0.5rem;
  }

  .contact-item {
    flex-direction: column;
    text-align: center;
  }

  .contact-text {
    margin-left: 0;
    margin-top: 0.5rem;
  }

  .footer-brand h3 {
    font-size: 1.75rem;
  }

  .footer-brand p {
    font-size: 0.85rem;
  }
}
</style>
