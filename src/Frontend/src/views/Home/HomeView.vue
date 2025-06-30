<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import {
  ElButton,
  ElIcon
} from 'element-plus'
import {
  Female,
  Lock,
  Trophy,
  ArrowRight
} from '@element-plus/icons-vue'
import AOS from 'aos'
import 'aos/dist/aos.css' 
import Layout2 from '../../layouts/Layout2.vue'
import Lokasi from '../../components/Home/Lokasi.vue'
import Pengumuman from '../../components/Home/Pengumuman.vue'
import LayananUtama from '../../components/Home/LayananUtama.vue'
import TentangKami from '../../components/Home/TentangKami.vue'
import BeritaTerbaru from '../../components/Home/BeritaTerbaru.vue'
import Kontak from '../../components/Home/Kontak.vue'
const router = useRouter()
onMounted(() => {
  AOS.init({
    duration: 800, 
    easing: 'ease-in-out', 
    once: true, 
    offset: 100, 
    delay: 0 
  })
})
</script>
<template>
  <Layout2>
    <section class="hero-section">
      <div class="hero-content" data-aos="fade-up">
        <div class="hero-text">
          <h1 class="hero-title">
            DP3AP2KB
            <div class="text-accent">Sumatera Barat</div>
            <div class="hero-title2">
              Peningkatan Ekonomi Perempuan Rentan Berspektif Gender
            </div>
          </h1>
          <p class="hero-subtitle">
            Pemberdayaan Perempuan Demi Meningkatkan Penghasilan Dan Kemandirian Ekonomi Melalui Pelatihan, Pendampingan Dan Pendekatan Berbasis Kesetaraan Gender.
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
          <div class="floating-card" style="top: 10%; right: 15%;">
            <ElIcon size="48" color="#10b981"><Trophy /></ElIcon>
            <p>Kesetaraan<br>Gender</p>
          </div>
        </div>
      </div>
    </section>
    <!-- Layanan Utama -->
    <LayananUtama />
    <!-- Tentang Kami -->
    <TentangKami />
    <!-- Bagian Berita Terbaru (menggunakan komponen BeritaTerbaru) -->
    <BeritaTerbaru />
    <!-- Bagian Pengumuman dan Lokasi -->
    <section class="announcements-locations-section">
      <div class="container">
        <ElRow :gutter="32">
          <ElCol :xs="24" :lg="12" class="mb-4 lg:mb-0">
            <div class="announcement-content">
              <Pengumuman />
            </div>
          </ElCol>
          <ElCol :xs="24" :lg="12">
            <div class="location-content">
              <Lokasi />
            </div>
          </ElCol>
        </ElRow>
      </div>
    </section>
    <!-- Bagian Kontak (menggunakan komponen Kontak yang dipisahkan) -->
    <Kontak />
  </Layout2>
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
  line-height: 1.6;
}
.container {
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 2rem;
}
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
.hero-section {
  min-height: 90vh;
  background: linear-gradient(135deg, #fef7ff 0%, #f3e8ff 25%, #fdf2f8 50%, #fff1f2 100%);
  display: flex;
  align-items: center;
  position: relative;
  overflow: hidden;
  padding-top: 5rem;
  padding-left: 0;
  padding-right: 0;
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
.hero-title2 {
  font-size: 2rem;
  font-weight: 700;
  color: #1e293b;
  line-height: 1.1;
  margin-top: 1rem;
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
  line-height: 1.2;
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
.announcement-content,
.location-content {
  transform: scale(0.95);
  font-size: 0.875rem;
  padding-left: 2.5rem;
  padding-right: 2.5rem;
}
.location-content {
  padding-left: 1.25rem;
  padding-right: 1.25rem;
}
@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-10px); }
}
.announcements-locations-section {
  padding: 2rem 0;
  background: #fafafa;
}
.mb-3 {
  margin-bottom: 1rem;
}
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
    position: static !important;
    transform: none !important;
    margin: 1rem auto;
  }
  .announcements-locations-section {
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
}
@media (max-width: 768px) {
  .hero-illustration {
    display: none;
  }
  .hero-title {
    font-size: 2rem;
  }
  .hero-title2 {
    font-size: 1.5rem;
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
  .announcement-content,
  .location-content {
    transform: scale(1);
    font-size: 1rem;
    padding-left: 1rem;
    padding-right: 1rem;
  }
  .announcements-locations-section .container {
    padding-left: 0.5rem;
    padding-right: 0.5rem;
  }
  .el-col {
    padding-left: 0.5rem !important;
    padding-right: 0.5rem !important;
  }
}
</style>
