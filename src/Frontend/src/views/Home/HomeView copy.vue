<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { 
  ElMenu, 
  ElMenuItem, 
  ElButton, 
  ElCard, 
  ElRow, 
  ElCol,
  ElCarousel,
  ElCarouselItem,
  ElIcon
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
  Star,
  CircleCheck,
  ArrowRight
} from '@element-plus/icons-vue'
import AOS from 'aos'

const activeIndex = ref('1')

const services = ref([
  {
    title: 'Dashboard Analytics',
    description: 'Pantau progress dan statistik pembelajaran secara real-time dengan visualisasi data yang menarik.',
    icon: DataBoard
  },
  {
    title: 'Pre/Post Test',
    description: 'Sistem evaluasi terintegrasi untuk mengukur kemampuan sebelum dan sesudah pelatihan.',
    icon: Document
  },
  {
    title: 'Manajemen Pendaftar',
    description: 'Kelola data peserta pelatihan dengan mudah dan efisien dalam satu platform.',
    icon: User
  },
  {
    title: 'Program Pelatihan',
    description: 'Akses berbagai program pelatihan berkualitas yang disesuaikan dengan kebutuhan.',
    icon: Trophy
  }
])

const testimonials = ref([
  {
    name: 'Sarah Wijaya',
    role: 'HR Manager',
    company: 'PT. Digital Innovation',
    content: 'Platform ini sangat membantu dalam mengelola program pelatihan karyawan. Interface yang clean dan fitur yang lengkap.',
    rating: 5
  },
  {
    name: 'Ahmad Rizki',
    role: 'Training Coordinator',
    company: 'CV. Teknologi Maju',
    content: 'Sistem pre/post test dan reporting yang detail memudahkan evaluasi efektivitas pelatihan yang kami lakukan.',
    rating: 5
  },
  {
    name: 'Linda Sari',
    role: 'Learning & Development',
    company: 'PT. Solusi Prima',
    content: 'Dashboard analytics memberikan insight yang valuable untuk pengembangan program pelatihan selanjutnya.',
    rating: 5
  }
])

const handleSelect = (key: string) => {
  activeIndex.value = key
}

onMounted(() => {
  AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: true
  })
})
</script>

<template>
  <div class="home-container">
    <!-- Navbar -->
    <header class="navbar-container">
      <div class="navbar-content">
        <div class="logo">
          <h2>EduPlatform</h2>
        </div>
        <ElMenu
          :default-active="activeIndex"
          mode="horizontal"
          class="navbar-menu"
          @select="handleSelect"
        >
          <ElMenuItem index="1">
            <ElIcon><House /></ElIcon>
            <span>BERANDA</span>
          </ElMenuItem>
          <ElMenuItem index="2">
            <ElIcon><DataBoard /></ElIcon>
            <span>DASHBOARD</span>
          </ElMenuItem>
          <ElMenuItem index="3">
            <ElIcon><Document /></ElIcon>
            <span>PRE/POSTTEST</span>
          </ElMenuItem>
          <ElMenuItem index="4">
            <ElIcon><User /></ElIcon>
            <span>PENDAFTAR</span>
          </ElMenuItem>
          <ElMenuItem index="5">
            <ElIcon><Trophy /></ElIcon>
            <span>PELATIHAN</span>
          </ElMenuItem>
          <ElMenuItem index="6">
            <ElIcon><Files /></ElIcon>
            <span>PELAPORAN</span>
          </ElMenuItem>
          <ElMenuItem index="7">
            <ElIcon><DataLine /></ElIcon>
            <span>KELOLA DATA</span>
          </ElMenuItem>
          <ElMenuItem index="8">
            <ElIcon><Lock /></ElIcon>
            <span>KELOLA AKSES</span>
          </ElMenuItem>
        </ElMenu>
      </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
      <div
        class="hero-content"
        data-aos="fade-up"
      >
        <h1 class="hero-title">
          Platform Pelatihan Digital 
          <span class="text-accent">Terdepan</span>
        </h1>
        <p class="hero-subtitle">
          Kelola program pelatihan, evaluasi kemampuan, dan pantau progress pembelajaran 
          dalam satu platform yang terintegrasi dan mudah digunakan.
        </p>
        <div class="hero-actions">
          <ElButton
            type="primary"
            size="large"
            class="cta-button"
          >
            Mulai Sekarang
            <ElIcon class="ml-2">
              <ArrowRight />
            </ElIcon>
          </ElButton>
          <ElButton
            size="large"
            class="secondary-button"
          >
            Pelajari Lebih Lanjut
          </ElButton>
        </div>
      </div>
      <div
        class="hero-illustration"
        data-aos="fade-left"
        data-aos-delay="200"
      >
        <div class="floating-card">
          <ElIcon
            size="48"
            color="#ec4899"
          >
            <Trophy />
          </ElIcon>
          <p>Program Pelatihan</p>
        </div>
        <div
          class="floating-card"
          style="top: 60%; left: 20%;"
        >
          <ElIcon
            size="48"
            color="#ec4899"
          >
            <DataBoard />
          </ElIcon>
          <p>Analytics</p>
        </div>
        <div
          class="floating-card"
          style="top: 20%; right: 10%;"
        >
          <ElIcon
            size="48"
            color="#ec4899"
          >
            <CircleCheck />
          </ElIcon>
          <p>Evaluasi</p>
        </div>
      </div>
    </section>

    <!-- About Section -->
    <section class="about-section">
      <div class="container">
        <ElRow
          :gutter="40"
          align="middle"
        >
          <ElCol
            :xs="24"
            :md="12"
            data-aos="fade-right"
          >
            <div class="about-content">
              <h2 class="section-title">
                Tentang Kami
              </h2>
              <p class="about-text">
                Kami adalah platform digital yang berfokus pada pengelolaan program pelatihan 
                dan pengembangan sumber daya manusia. Dengan teknologi terdepan dan antarmuka 
                yang intuitif, kami membantu organisasi dalam menciptakan pengalaman pembelajaran 
                yang efektif dan terukur.
              </p>
              <div class="stats-grid">
                <div class="stat-item">
                  <h3>10K+</h3>
                  <p>Peserta Aktif</p>
                </div>
                <div class="stat-item">
                  <h3>500+</h3>
                  <p>Program Pelatihan</p>
                </div>
                <div class="stat-item">
                  <h3>98%</h3>
                  <p>Tingkat Kepuasan</p>
                </div>
              </div>
            </div>
          </ElCol>
          <ElCol
            :xs="24"
            :md="12"
            data-aos="fade-left"
          >
            <div class="about-illustration">
              <div class="illustration-bg">
                <ElIcon
                  size="120"
                  color="#ec4899"
                >
                  <DataBoard />
                </ElIcon>
              </div>
            </div>
          </ElCol>
        </ElRow>
      </div>
    </section>

    <!-- Services Section -->
    <section class="services-section">
      <div class="container">
        <div
          class="section-header"
          data-aos="fade-up"
        >
          <h2 class="section-title">
            Layanan & Fitur Unggulan
          </h2>
          <p class="section-subtitle">
            Dapatkan solusi lengkap untuk kebutuhan pelatihan dan pengembangan tim Anda
          </p>
        </div>
        <ElRow :gutter="24">
          <ElCol 
            v-for="(service, index) in services" 
            :key="index" 
            :xs="24" 
            :sm="12" 
            :lg="6"
            data-aos="fade-up"
            :data-aos-delay="index * 100"
          >
            <ElCard
              class="service-card"
              shadow="hover"
            >
              <div class="service-icon">
                <ElIcon
                  size="40"
                  :component="service.icon"
                />
              </div>
              <h3 class="service-title">
                {{ service.title }}
              </h3>
              <p class="service-description">
                {{ service.description }}
              </p>
              <ElButton
                text
                class="service-link"
              >
                Pelajari Lebih Lanjut
                <ElIcon class="ml-1">
                  <ArrowRight />
                </ElIcon>
              </ElButton>
            </ElCard>
          </ElCol>
        </ElRow>
      </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
      <div class="container">
        <div
          class="section-header"
          data-aos="fade-up"
        >
          <h2 class="section-title">
            Testimoni Pengguna
          </h2>
          <p class="section-subtitle">
            Apa kata mereka yang telah menggunakan platform kami
          </p>
        </div>
        <div
          class="testimonials-carousel"
          data-aos="fade-up"
          data-aos-delay="200"
        >
          <ElCarousel
            height="300px"
            :autoplay="true"
            :interval="5000"
          >
            <ElCarouselItem
              v-for="(testimonial, index) in testimonials"
              :key="index"
            >
              <div class="testimonial-card">
                <div class="testimonial-content">
                  <div class="stars">
                    <ElIcon
                      v-for="i in testimonial.rating"
                      :key="i"
                      color="#fbbf24"
                    >
                      <Star />
                    </ElIcon>
                  </div>
                  <p class="testimonial-text">
                    "{{ testimonial.content }}"
                  </p>
                  <div class="testimonial-author">
                    <h4>{{ testimonial.name }}</h4>
                    <p>{{ testimonial.role }}</p>
                    <p class="company">
                      {{ testimonial.company }}
                    </p>
                  </div>
                </div>
              </div>
            </ElCarouselItem>
          </ElCarousel>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
      <div class="container">
        <div class="footer-content">
          <div class="footer-brand">
            <h3>EduPlatform</h3>
            <p>Platform pelatihan digital terdepan untuk pengembangan SDM yang efektif.</p>
          </div>
          <div class="footer-links">
            <div class="footer-column">
              <h4>Platform</h4>
              <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Pelatihan</a></li>
                <li><a href="#">Evaluasi</a></li>
                <li><a href="#">Laporan</a></li>
              </ul>
            </div>
            <div class="footer-column">
              <h4>Dukungan</h4>
              <ul>
                <li><a href="#">Dokumentasi</a></li>
                <li><a href="#">Tutorial</a></li>
                <li><a href="#">Kontak</a></li>
                <li><a href="#">FAQ</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="footer-bottom">
          <p>&copy; 2025 EduPlatform. Semua hak dilindungi.</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.home-container {
  min-height: 100vh;
  background-color: #ffffff;
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

/* Navbar Styles */
.navbar-container {
  position: sticky;
  top: 0;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  border-bottom: 1px solid #f1f5f9;
  z-index: 1000;
  padding: 0;
}

.navbar-content {
  max-width: 1400px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 2rem;
}

.logo h2 {
  color: #ec4899;
  font-weight: 700;
  font-size: 1.5rem;
}

.navbar-menu {
  border-bottom: none;
  flex: 1;
  justify-content: center;
  max-width: 800px;
}

.navbar-menu .el-menu-item {
  color: #64748b;
  font-weight: 500;
  font-size: 0.875rem;
  padding: 0 1rem;
  transition: all 0.3s ease;
}

.navbar-menu .el-menu-item:hover,
.navbar-menu .el-menu-item.is-active {
  color: #ec4899;
  background-color: rgba(236, 72, 153, 0.08);
}

.navbar-menu .el-menu-item span {
  margin-left: 0.5rem;
}

/* Hero Section */
.hero-section {
  min-height: 100vh;
  display: flex;
  align-items: center;
  position: relative;
  background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
  padding: 2rem;
  overflow: hidden;
}

.hero-content {
  max-width: 1400px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 4rem;
  align-items: center;
  width: 100%;
}

.hero-title {
  font-size: 3.5rem;
  font-weight: 800;
  line-height: 1.1;
  color: #1e293b;
  margin-bottom: 1.5rem;
}

.text-accent {
  color: #ec4899;
}

.hero-subtitle {
  font-size: 1.25rem;
  color: #64748b;
  line-height: 1.7;
  margin-bottom: 2.5rem;
}

.hero-actions {
  display: flex;
  gap: 1rem;
}

.cta-button {
  background: linear-gradient(135deg, #ec4899, #be185d);
  border: none;
  padding: 1rem 2rem;
  font-weight: 600;
  border-radius: 12px;
  transition: all 0.3s ease;
}

.cta-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 24px rgba(236, 72, 153, 0.3);
}

.secondary-button {
  border: 2px solid #e2e8f0;
  color: #64748b;
  font-weight: 600;
  border-radius: 12px;
  transition: all 0.3s ease;
}

.secondary-button:hover {
  border-color: #ec4899;
  color: #ec4899;
}

.hero-illustration {
  position: relative;
  height: 500px;
}

.floating-card {
  position: absolute;
  background: white;
  padding: 1.5rem;
  border-radius: 16px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
  text-align: center;
  animation: float 6s ease-in-out infinite;
}

.floating-card p {
  margin-top: 0.5rem;
  color: #64748b;
  font-weight: 500;
}

@keyframes float {
  0%, 100% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(-20px);
  }
}

/* About Section */
.about-section {
  padding: 6rem 2rem;
  background: #f8fafc;
}

.container {
  max-width: 1400px;
  margin: 0 auto;
}

.section-title {
  font-size: 2.5rem;
  font-weight: 700;
  color: #1e293b;
  margin-bottom: 1rem;
}

.about-text {
  font-size: 1.125rem;
  color: #64748b;
  line-height: 1.8;
  margin-bottom: 2rem;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 2rem;
}

.stat-item {
  text-align: center;
}

.stat-item h3 {
  font-size: 2.5rem;
  font-weight: 800;
  color: #ec4899;
  margin-bottom: 0.5rem;
}

.stat-item p {
  color: #64748b;
  font-weight: 500;
}

.about-illustration {
  display: flex;
  justify-content: center;
  align-items: center;
}

.illustration-bg {
  width: 240px;
  height: 240px;
  background: linear-gradient(135deg, rgba(236, 72, 153, 0.1), rgba(236, 72, 153, 0.05));
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Services Section */
.services-section {
  padding: 6rem 2rem;
  background: white;
}

.section-header {
  text-align: center;
  margin-bottom: 4rem;
}

.section-subtitle {
  font-size: 1.125rem;
  color: #64748b;
  margin-top: 1rem;
}

.service-card {
  text-align: center;
  padding: 2rem;
  border-radius: 16px;
  border: 1px solid #f1f5f9;
  transition: all 0.3s ease;
  height: 100%;
}

.service-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 32px rgba(0, 0, 0, 0.1);
  border-color: rgba(236, 72, 153, 0.2);
}

.service-icon {
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg, rgba(236, 72, 153, 0.1), rgba(236, 72, 153, 0.05));
  border-radius: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1.5rem;
  color: #ec4899;
}

.service-title {
  font-size: 1.25rem;
  font-weight: 600;
  color: #1e293b;
  margin-bottom: 1rem;
}

.service-description {
  color: #64748b;
  line-height: 1.6;
  margin-bottom: 1.5rem;
}

.service-link {
  color: #ec4899;
  font-weight: 600;
}

/* Testimonials Section */
.testimonials-section {
  padding: 6rem 2rem;
  background: #f8fafc;
}

.testimonials-carousel {
  max-width: 800px;
  margin: 0 auto;
}

.testimonial-card {
  background: white;
  padding: 3rem;
  border-radius: 20px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
  margin: 1rem;
  text-align: center;
}

.stars {
  display: flex;
  justify-content: center;
  gap: 0.25rem;
  margin-bottom: 1.5rem;
}

.testimonial-text {
  font-size: 1.125rem;
  color: #1e293b;
  line-height: 1.7;
  margin-bottom: 2rem;
  font-style: italic;
}

.testimonial-author h4 {
  font-size: 1.125rem;
  font-weight: 600;
  color: #1e293b;
  margin-bottom: 0.25rem;
}

.testimonial-author p {
  color: #64748b;
  margin-bottom: 0.25rem;
}

.company {
  color: #ec4899;
  font-weight: 500;
}

/* Footer */
.footer {
  background: #1e293b;
  padding: 3rem 2rem 1rem;
  color: white;
}

.footer-content {
  display: grid;
  grid-template-columns: 1fr 2fr;
  gap: 3rem;
  margin-bottom: 2rem;
}

.footer-brand h3 {
  color: #ec4899;
  font-size: 1.5rem;
  margin-bottom: 1rem;
}

.footer-brand p {
  color: #94a3b8;
  line-height: 1.6;
}

.footer-links {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 2rem;
}

.footer-column h4 {
  color: white;
  margin-bottom: 1rem;
  font-weight: 600;
}

.footer-column ul {
  list-style: none;
}

.footer-column ul li {
  margin-bottom: 0.5rem;
}

.footer-column ul li a {
  color: #94a3b8;
  text-decoration: none;
  transition: color 0.3s ease;
}

.footer-column ul li a:hover {
  color: #ec4899;
}

.footer-bottom {
  border-top: 1px solid #334155;
  padding-top: 1rem;
  text-align: center;
  color: #94a3b8;
}

/* Responsive Design */
@media (max-width: 1024px) {
  .navbar-content {
    padding: 0 1rem;
  }
  
  .navbar-menu .el-menu-item {
    font-size: 0.75rem;
    padding: 0 0.5rem;
  }
  
  .navbar-menu .el-menu-item span {
    display: none;
  }
  
  .hero-content {
    grid-template-columns: 1fr;
    text-align: center;
  }
  
  .hero-title {
    font-size: 2.5rem;
  }
  
  .stats-grid {
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
  }
}

@media (max-width: 768px) {
  .navbar-menu {
    display: none;
  }
  
  .hero-title {
    font-size: 2rem;
  }
  
  .hero-subtitle {
    font-size: 1rem;
  }
  
  .hero-actions {
    flex-direction: column;
    align-items: center;
  }
  
  .section-title {
    font-size: 2rem;
  }
  
  .stats-grid {
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }
  
  .footer-content {
    grid-template-columns: 1fr;
  }
  
  .footer-links {
    grid-template-columns: 1fr;
  }
}

/* Element Plus Customization */
:deep(.el-carousel__indicator) {
  background-color: #e2e8f0;
}

:deep(.el-carousel__indicator.is-active) {
  background-color: #ec4899;
}

:deep(.el-card) {
  border: none;
}

.ml-1 {
  margin-left: 0.25rem;
}

.ml-2 {
  margin-left: 0.5rem;
}
</style>