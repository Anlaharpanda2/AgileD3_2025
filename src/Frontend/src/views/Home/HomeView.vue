<script setup lang="ts">
import { markRaw, ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import {
  ElButton,
  ElCard,
  ElRow,
  ElCol,
  ElIcon,
  ElDivider
} from 'element-plus'
import {
  Female,
  Lock,
  DataBoard,
  Document,
  User,
  Trophy,
  ArrowRight,
  Phone,
  Location,
  Message,
  ChatDotRound
} from '@element-plus/icons-vue'
import AOS from 'aos'
import 'aos/dist/aos.css' // Impor CSS AOS

// Impor komponen Layout dari folder layouts
import Layout from '../../layouts/Layout.vue'
// Impor komponen Lokasi dari folder components/Home
import Lokasi from '../../components/Home/Lokasi.vue'
// Impor komponen Pengumuman dari folder components/Home
import Pengumuman from '../../components/Home/Pengumuman.vue'
// Impor komponen BeritaTerbaru dari folder components/Home
import BeritaTerbaru from '../../components/Home/BeritaTerbaru.vue'


// Router Vue untuk navigasi
const router = useRouter()

// Data untuk fitur utama
const mainFeatures = ref([
  {
    title: 'Ikut Pelatihan',
    description: 'Bergabunglah dalam program pelatihan pemberdayaan perempuan untuk meningkatkan keterampilan dan kemampuan diri.',
    icon: Female,
    color: '#ec4899',
    bgColor: 'rgba(236, 72, 153, 0.1)',
    route: '/pelatihan'
  },
  {
    title: 'Pengaduan',
    description: 'Laporkan kasus kekerasan terhadap perempuan dan anak melalui sistem pengaduan yang aman dan terpercaya.',
    icon: Lock,
    color: '#8b5cf6',
    bgColor: 'rgba(139, 92, 246, 0.1)',
    route: '/pengaduan'
  }
])

// Data untuk layanan
const services = ref([
  {
    title: 'Dashboard Analytics',
    description: 'Pantau progress dan statistik kegiatan pemberdayaan perempuan secara real-time.',
    icon: DataBoard,
    color: '#06b6d4'
  },
  {
    title: 'Sistem Evaluasi',
    description: 'Evaluasi komprehensif untuk mengukur efektivitas program pelatihan yang diikuti.',
    icon: Document,
    color: '#10b981'
  },
  {
    title: 'Manajemen Peserta',
    description: 'Kelola data peserta pelatihan dan program pemberdayaan dengan mudah.',
    icon: User,
    color: '#f59e0b'
  },
  {
    title: 'Program Unggulan',
    description: 'Akses berbagai program pelatihan berkualitas sesuai kebutuhan pemberdayaan.',
    icon: Trophy,
    color: '#ef4444'
  }
])

// Data informasi kontak
const contactInfo = ref({
  address: 'Jl. Sudirman No. 123, Jakarta Pusat 10270',
  phone: '(021) 1234-5678',
  email: 'info@dp3ap2kb.go.id',
  whatsapp: '+62812-3456-7890'
})

// Metode untuk navigasi ke fitur tertentu
const navigateToFeature = (route: string) => {
  router.push(route)
}

// Lifecycle hook: saat komponen dimount
onMounted(() => {
  AOS.init({
    duration: 800, // Durasi animasi
    easing: 'ease-in-out', // Fungsi easing
    once: true, // Animasi hanya berjalan sekali
    offset: 100, // Offset pemicu animasi
    delay: 0 // Penundaan animasi
  })
})
</script>

<template>
  <Layout>
    <!-- Hero Section -->
    <section class="hero-section">
      <div class="hero-content" data-aos="fade-up">
        <div class="hero-text">
          <h1 class="hero-title">
            Dinas Pemberdayaan Perempuan,
            <span class="text-accent">Perlindungan Anak</span>
            dan Keluarga Berencana
          </h1>
          <p class="hero-subtitle">
            Membangun masa depan yang lebih baik melalui pemberdayaan perempuan,
            perlindungan anak, dan program keluarga berencana yang berkelanjutan.
          </p>
          <div class="hero-actions">
            <ElButton type="primary" size="large" class="cta-button">
              Mulai Bergabung
              <ElIcon class="ml-2"><ArrowRight /></ElIcon>
            </ElButton>
            <ElButton size="large" class="secondary-button">
              Pelajari Program
            </ElButton>
          </div>
        </div>
        <div class="hero-illustration" data-aos="fade-left" data-aos-delay="200">
          <div class="floating-card main-card">
            <ElIcon size="60" color="#ec4899"><Female /></ElIcon>
            <p>Pemberdayaan<br>Perempuan</p>
          </div>
          <div class="floating-card" style="top: 60%; left: 15%;">
            <ElIcon size="48" color="#8b5cf6"><Lock /></ElIcon>
            <p>Perlindungan<br>Anak</p>
          </div>
          <div class="floating-card" style="top: 20%; right: 10%;">
            <ElIcon size="48" color="#10b981"><Trophy /></ElIcon>
            <p>Program<br>Unggulan</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Fitur Utama -->
    <section class="features-section">
      <div class="container">
        <div class="section-header" data-aos="fade-up">
          <h2 class="section-title">Fitur Utama</h2>
          <p class="section-subtitle">
            Akses langsung ke layanan utama untuk pemberdayaan dan perlindungan
          </p>
        </div>
        <ElRow :gutter="32" justify="center">
          <ElCol
            :xs="24"
            :md="12"
            :lg="10"
            v-for="(feature, index) in mainFeatures"
            :key="index"
            data-aos="zoom-in"
            :data-aos-delay="index * 100"
          >
            <ElCard
              class="feature-card main-feature"
              shadow="hover"
              @click="navigateToFeature(feature.route)"
            >
              <div class="feature-icon" :style="{
                backgroundColor: feature.bgColor,
                color: feature.color
              }">
                <ElIcon size="60" :component="feature.icon" />
              </div>
              <h3 class="feature-title">{{ feature.title }}</h3>
              <p class="feature-description">{{ feature.description }}</p>
              <ElButton type="primary" class="feature-button">
                Mulai Sekarang
                <ElIcon class="ml-1"><ArrowRight /></ElIcon>
              </ElButton>
            </ElCard>
          </ElCol>
        </ElRow>
      </div>
    </section>

    <!-- Tentang Kami -->
    <section class="about-section">
      <div class="container">
        <ElRow :gutter="40" align="middle">
          <ElCol :xs="24" :md="12" data-aos="fade-right">
            <div class="about-content">
              <h2 class="section-title">Tentang Kami</h2>
              <p class="about-text">
                Dinas Pemberdayaan Perempuan, Perlindungan Anak dan Keluarga Berencana (DP3AP2KB)
                berkomitmen untuk menciptakan masyarakat yang adil gender, melindungi hak-hak anak,
                dan mendukung program keluarga berencana yang berkelanjutan.
              </p>
              <p class="about-text">
                Melalui berbagai program inovatif dan pelayanan terintegrasi, kami berupaya
                memberdayakan perempuan untuk berperan aktif dalam pembangunan, melindungi
                anak dari segala bentuk kekerasan, dan mendukung keluarga Indonesia yang sejahtera.
              </p>
              <div class="stats-grid">
                <div class="stat-item">
                  <h3>15K+</h3>
                  <p>Perempuan Terberdayakan</p>
                </div>
                <div class="stat-item">
                  <h3>500+</h3>
                  <p>Kasus Terselesaikan</p>
                </div>
                <div class="stat-item">
                  <h3>95%</h3>
                  <p>Tingkat Kepuasan</p>
                </div>
              </div>
            </div>
          </ElCol>
          <ElCol :xs="24" :md="12" data-aos="fade-left">
            <div class="about-illustration">
              <div class="illustration-bg">
                <ElIcon size="140" color="#ec4899"><Female /></ElIcon>
              </div>
            </div>
          </ElCol>
        </ElRow>
      </div>
    </section>

    <!-- Bagian Layanan -->
    <section class="services-section">
      <div class="container">
        <div class="section-header" data-aos="fade-up">
          <h2 class="section-title">Layanan & Program</h2>
          <p class="section-subtitle">
            Berbagai layanan terintegrasi untuk mendukung pemberdayaan dan perlindungan
          </p>
        </div>
        <ElRow :gutter="24">
          <ElCol
            :xs="24"
            :sm="12"
            :lg="6"
            v-for="(service, index) in services"
            :key="index"
            data-aos="fade-up"
            :data-aos-delay="index * 100"
          >
            <ElCard class="service-card" shadow="hover">
              <div class="service-icon" :style="{ color: service.color }">
                <ElIcon size="40" :component="service.icon" />
              </div>
              <h3 class="service-title">{{ service.title }}</h3>
              <p class="service-description">{{ service.description }}</p>
              <ElButton text class="service-link">
                Pelajari Lebih Lanjut
                <ElIcon class="ml-1"><ArrowRight /></ElIcon>
              </ElButton>
            </ElCard>
          </ElCol>
        </ElRow>
      </div>
    </section>

    <!-- Bagian Berita Terbaru (menggunakan komponen BeritaTerbaru) -->
    <BeritaTerbaru />

    <!-- Bagian Pengumuman dan Lokasi -->
    <section class="announcements-locations-section">
      <div class="container">
        <ElRow :gutter="32">
          <!-- Bagian Pengumuman (menggunakan komponen Pengumuman) -->
          <ElCol :xs="24" :lg="12">
            <Pengumuman />
          </ElCol>

          <!-- Bagian Lokasi (menggunakan komponen Lokasi) -->
          <ElCol :xs="24" :lg="12">
            <Lokasi />
          </ElCol>
        </ElRow>
      </div>
    </section>

    <!-- Bagian Kontak -->
    <section class="contact-section">
      <div class="container">
        <div class="section-header" data-aos="fade-up">
          <h2 class="section-title">Hubungi Kami</h2>
          <p class="section-subtitle">
            Dapatkan informasi lebih lanjut atau sampaikan pertanyaan Anda
          </p>
        </div>
        <ElRow :gutter="32" justify="center">
          <ElCol :xs="24" :md="20" :lg="16">
            <ElCard class="contact-card" data-aos="zoom-in">
              <ElRow :gutter="24">
                <ElCol :xs="24" :md="12">
                  <div class="contact-item">
                    <ElIcon size="24" color="#ec4899"><Location /></ElIcon>
                    <div class="contact-text">
                      <h4>Alamat</h4>
                      <p>{{ contactInfo.address }}</p>
                    </div>
                  </div>
                  <ElDivider />
                  <div class="contact-item">
                    <ElIcon size="24" color="#ec4899"><Phone /></ElIcon>
                    <div class="contact-text">
                      <h4>Telepon</h4>
                      <p>{{ contactInfo.phone }}</p>
                    </div>
                  </div>
                </ElCol>
                <ElCol :xs="24" :md="12">
                  <div class="contact-item">
                    <ElIcon size="24" color="#ec4899"><Message /></ElIcon>
                    <div class="contact-text">
                      <h4>Email</h4>
                      <p>{{ contactInfo.email }}</p>
                    </div>
                  </div>
                  <ElDivider />
                  <div class="contact-item">
                    <ElIcon size="24" color="#ec4899"><ChatDotRound /></ElIcon>
                    <div class="contact-text">
                      <h4>WhatsApp</h4>
                      <p>{{ contactInfo.whatsapp }}</p>
                    </div>
                  </div>
                </ElCol>
              </ElRow>
            </ElCard>
          </ElCol>
        </ElRow>
      </div>
    </section>
  </Layout>
</template>

<style scoped>
/* Reset dasar */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/* Gaya kontainer utama */
.home-container {
  min-height: 100vh;
  background-color: #ffffff;
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
  line-height: 1.6;
}

/* Container */
.container {
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 2rem;
}

/* Header Bagian (umum untuk semua komponen yang menggunakan ini) */
.section-header {
  text-align: center;
  margin-bottom: 4rem;
}

.section-title {
  font-size: 2.5rem;
  font-weight: 700;
  color: #1e293b;
  margin-bottom: 1rem;
}

.section-subtitle {
  font-size: 1.1rem;
  color: #64748b;
  font-weight: 400;
  max-width: 600px;
  margin: 0 auto;
}

/* Gaya Hero Section */
.hero-section {
  min-height: 90vh;
  background: linear-gradient(135deg, #fef7ff 0%, #f3e8ff 25%, #fdf2f8 50%, #fff1f2 100%);
  display: flex;
  align-items: center;
  position: relative;
  overflow: hidden;
  padding: 2rem 0;
}

.hero-section::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle, rgba(236, 72, 153, 0.1) 0%, transparent 70%);
  animation: float 6s ease-in-out infinite;
}

.hero-content {
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 2rem;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 4rem;
  align-items: center;
  position: relative;
  z-index: 10;
}

.hero-text {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.hero-title {
  font-size: 3.5rem;
  font-weight: 800;
  color: #1e293b;
  line-height: 1.1;
  margin-bottom: 1rem;
}

.text-accent {
  color: #ec4899;
  background: linear-gradient(135deg, #ec4899, #8b5cf6);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.hero-subtitle {
  font-size: 1.25rem;
  color: #64748b;
  font-weight: 400;
  max-width: 600px;
  line-height: 1.7;
}

.hero-actions {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
}

.cta-button {
  background: linear-gradient(135deg, #ec4899, #8b5cf6);
  border: none;
  padding: 1rem 2rem;
  font-size: 1.1rem;
  font-weight: 600;
  border-radius: 12px;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(236, 72, 153, 0.3);
}

.cta-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(236, 72, 153, 0.4);
}

.secondary-button {
  padding: 1rem 2rem;
  font-size: 1.1rem;
  font-weight: 600;
  border: 2px solid #e2e8f0;
  color: #64748b;
  border-radius: 12px;
  transition: all 0.3s ease;
}

.secondary-button:hover {
  border-color: #ec4899;
  color: #ec4899;
  background-color: rgba(236, 72, 153, 0.05);
}

.hero-illustration {
  position: relative;
  height: 500px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.floating-card {
  position: absolute;
  background: white;
  padding: 2rem;
  border-radius: 20px;
  text-align: center;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
  animation: float 3s ease-in-out infinite;
}

.floating-card:nth-child(2) {
  animation-delay: -1s;
}

.floating-card:nth-child(3) {
  animation-delay: -2s;
}

.floating-card.main-card {
  z-index: 10;
  padding: 3rem 2.5rem;
  font-size: 1.1rem;
  font-weight: 600;
  color: #1e293b;
}

.floating-card p {
  margin-top: 1rem;
  font-weight: 600;
  color: #475569;
  font-size: 0.9rem;
}

@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-10px); }
}

/* Gaya Fitur Utama */
.features-section {
  padding: 6rem 0;
  background-color: #fafafa;
}

.feature-card {
  text-align: center;
  padding: 3rem 2rem;
  border-radius: 24px;
  border: none;
  transition: all 0.3s ease;
  cursor: pointer;
  height: 100%;
}

.feature-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.main-feature {
  border: 2px solid transparent;
  background: linear-gradient(white, white) padding-box,
              linear-gradient(135deg, #ec4899, #8b5cf6) border-box;
}

.feature-icon {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 2rem auto;
  transition: all 0.3s ease;
}

.feature-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1e293b;
  margin-bottom: 1rem;
}

.feature-description {
  color: #64748b;
  font-size: 1rem;
  line-height: 1.6;
  margin-bottom: 2rem;
}

.feature-button {
  background: linear-gradient(135deg, #ec4899, #8b5cf6);
  border: none;
  padding: 0.75rem 1.5rem;
  font-weight: 600;
  border-radius: 10px;
}

/* Gaya Bagian Tentang Kami */
.about-section {
  padding: 6rem 0;
  background: white;
}

.about-content {
  padding-right: 2rem;
}

.about-text {
  font-size: 1.1rem;
  color: #64748b;
  margin-bottom: 1.5rem;
  line-height: 1.7;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 2rem;
  margin-top: 3rem;
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
  align-items: center;
  justify-content: center;
  height: 400px;
}

.illustration-bg {
  width: 280px;
  height: 280px;
  background: linear-gradient(135deg, rgba(236, 72, 153, 0.1), rgba(139, 92, 246, 0.1));
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(1.05); }
}

/* Gaya Bagian Layanan */
.services-section {
  padding: 6rem 0;
  background: #fafafa;
}

.service-card {
  padding: 2.5rem 2rem;
  border-radius: 20px;
  border: none;
  text-align: center;
  height: 100%;
  transition: all 0.3s ease;
}

.service-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
}

.service-icon {
  width: 80px;
  height: 80px;
  background: rgba(236, 72, 153, 0.1);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1.5rem auto;
}

.service-title {
  font-size: 1.25rem;
  font-weight: 600;
  color: #1e293b;
  margin-bottom: 1rem;
}

.service-description {
  color: #64748b;
  font-size: 0.95rem;
  line-height: 1.6;
  margin-bottom: 1.5rem;
}

.service-link {
  color: #ec4899;
  font-weight: 600;
}

/* Gaya Bagian Pengumuman & Lokasi (container untuk keduanya) */
.announcements-locations-section {
  padding: 6rem 0;
  background: #fafafa;
}

/* Gaya Bagian Kontak */
.contact-section {
  padding: 6rem 0;
  background: #fafafa;
}

.contact-card {
  border-radius: 20px;
  padding: 3rem;
  border: none;
  box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
}

.contact-item {
  display: flex;
  align-items: center;
  gap: 1.5rem;
  margin-bottom: 1.5rem;
}

.contact-item .el-icon {
  font-size: 2rem;
  flex-shrink: 0;
}

.contact-text h4 {
  font-size: 1.1rem;
  font-weight: 600;
  color: #1e293b;
  margin-bottom: 0.25rem;
}

.contact-text p {
  color: #64748b;
  font-size: 0.95rem;
}

.el-divider {
  margin: 1.5rem 0;
}

/* Utilitas */
.mb-3 {
  margin-bottom: 1rem;
}

/* Media Queries untuk Responsif */
@media (max-width: 1024px) {
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
    position: static !important; /* Override inline styles */
    transform: none !important;
    margin: 1rem auto; /* Add margin for stacking */
  }

  .features-section,
  .about-section,
  .services-section,
  /* news-section dihapus dari sini karena dikelola oleh komponen BeritaTerbaru */
  .announcements-locations-section,
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

  .contact-card {
    padding: 2rem;
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
}
</style>
