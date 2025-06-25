<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import {
  ElCard,
  ElRow,
  ElCol,
  ElIcon,
  ElImage,
  ElTag,
  ElButton
} from 'element-plus'
import { ArrowRight, ArrowLeft } from '@element-plus/icons-vue'
import AOS from 'aos'
import 'aos/dist/aos.css' // Impor CSS AOS

// Data untuk berita (diperbanyak untuk demo carousel)
const news = ref([
  {
    id: 1,
    title: 'Pelatihan Kewirausahaan untuk Perempuan Dimulai Bulan Ini',
    summary: 'Program pelatihan kewirausahaan khusus perempuan akan dimulai dengan 100 peserta dari berbagai daerah.',
    image: 'https://placehold.co/600x400/FFC0CB/000000?text=Berita+1',
    date: '2025-06-20',
    category: 'Pelatihan'
  },
  {
    id: 2,
    title: 'Seminar Perlindungan Anak dan Pencegahan Kekerasan',
    summary: 'Seminar edukasi tentang perlindungan anak dan pencegahan kekerasan akan diselenggarakan secara hybrid.',
    image: 'https://placehold.co/600x400/ADD8E6/000000?text=Berita+2',
    date: '2025-06-18',
    category: 'Seminar'
  },
  {
    id: 3,
    title: 'Launching Aplikasi Pengaduan Online Terbaru',
    summary: 'Sistem pengaduan online telah diperbarui dengan fitur keamanan dan privasi yang lebih baik.',
    image: 'https://placehold.co/600x400/90EE90/000000?text=Berita+3',
    date: '2025-06-15',
    category: 'Teknologi'
  },
  {
    id: 4,
    title: 'Workshop Digital Marketing untuk UMKM Perempuan',
    summary: 'Pelatihan digital marketing khusus untuk mendukung UMKM yang dijalankan oleh perempuan.',
    image: 'https://placehold.co/600x400/FFD700/000000?text=Berita+4',
    date: '2025-06-12',
    category: 'Pelatihan'
  },
  {
    id: 5,
    title: 'Peluncuran Program Beasiswa Pendidikan Anak',
    summary: 'Program beasiswa pendidikan untuk anak-anak dari keluarga kurang mampu resmi diluncurkan.',
    image: 'https://placehold.co/600x400/FF6347/000000?text=Berita+5',
    date: '2025-06-10',
    category: 'Pendidikan'
  },
  {
    id: 6,
    title: 'Kampanye Anti Kekerasan Dalam Rumah Tangga',
    summary: 'Kampanye nasional untuk meningkatkan kesadaran tentang bahaya kekerasan dalam rumah tangga.',
    image: 'https://placehold.co/600x400/9370DB/000000?text=Berita+6',
    date: '2025-06-08',
    category: 'Kampanye'
  },
  {
    id: 7,
    title: 'Pelatihan Keterampilan Menjahit untuk Ibu Rumah Tangga',
    summary: 'Program pelatihan keterampilan menjahit untuk meningkatkan ekonomi keluarga.',
    image: 'https://placehold.co/600x400/20B2AA/000000?text=Berita+7',
    date: '2025-06-05',
    category: 'Pelatihan'
  },
  {
    id: 8,
    title: 'Konseling Psikologi Gratis untuk Korban Kekerasan',
    summary: 'Layanan konseling psikologi gratis untuk membantu korban kekerasan pulih dari trauma.',
    image: 'https://placehold.co/600x400/FF69B4/000000?text=Berita+8',
    date: '2025-06-03',
    category: 'Layanan'
  }
])

// State untuk carousel
const currentIndex = ref(0)
const itemsPerPage = 3
const carouselContainer = ref<HTMLElement | null>(null)

// Computed properties
const totalPages = computed(() => Math.ceil(news.value.length / itemsPerPage))
const canGoPrev = computed(() => currentIndex.value > 0)
const canGoNext = computed(() => currentIndex.value < totalPages.value - 1)

const visibleNews = computed(() => {
  const start = currentIndex.value * itemsPerPage
  const end = start + itemsPerPage
  return news.value.slice(start, end)
})

// Metode untuk navigasi carousel
const goToPrev = () => {
  if (canGoPrev.value) {
    currentIndex.value--
  }
}

const goToNext = () => {
  if (canGoNext.value) {
    currentIndex.value++
  }
}

// Metode untuk memformat tanggal
const formatDate = (dateString: string) => {
  const options: Intl.DateTimeFormatOptions = {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  }
  return new Date(dateString).toLocaleDateString('id-ID', options)
}

// Auto-slide (opsional)
const autoSlide = ref(true)
const slideInterval = ref<NodeJS.Timeout | null>(null)

const startAutoSlide = () => {
  if (autoSlide.value) {
    slideInterval.value = setInterval(() => {
      if (canGoNext.value) {
        goToNext()
      } else {
        currentIndex.value = 0 // Kembali ke awal
      }
    }, 5000) // Slide setiap 5 detik
  }
}

const stopAutoSlide = () => {
  if (slideInterval.value) {
    clearInterval(slideInterval.value)
    slideInterval.value = null
  }
}

// Lifecycle hook: saat komponen dimount
onMounted(() => {
  AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: true,
    offset: 100,
    delay: 0
  })
  
  // Mulai auto-slide
  startAutoSlide()
})

// Cleanup saat komponen di-unmount
import { onUnmounted } from 'vue'
onUnmounted(() => {
  stopAutoSlide()
})
</script>

<template>
  <div class="news-section-container">
    <div class="section-header" data-aos="fade-up">
      <h2 class="section-title">Berita Terbaru</h2>
      <p class="section-subtitle">
        Informasi terkini seputar kegiatan dan program pemberdayaan
      </p>
    </div>

    <!-- Carousel Container -->
    <div class="carousel-wrapper" 
         @mouseenter="stopAutoSlide" 
         @mouseleave="startAutoSlide">
      
      <!-- Navigation Buttons -->
      <div class="carousel-nav">
        <ElButton 
          :disabled="!canGoPrev"
          @click="goToPrev"
          class="nav-button prev-button"
          circle
          size="large"
        >
          <ElIcon><ArrowLeft /></ElIcon>
        </ElButton>
        
        <ElButton 
          :disabled="!canGoNext"
          @click="goToNext"
          class="nav-button next-button"
          circle
          size="large"
        >
          <ElIcon><ArrowRight /></ElIcon>
        </ElButton>
      </div>

      <!-- News Cards -->
      <div class="carousel-container" ref="carouselContainer">
        <ElRow :gutter="24" class="news-row">
          <ElCol
            :xs="24"
            :md="8"
            v-for="(newsItem, index) in visibleNews"
            :key="newsItem.id"
            data-aos="fade-up"
            :data-aos-delay="index * 100"
          >
            <ElCard class="news-card" shadow="hover">
              <div class="news-image">
                <ElImage
                  :src="newsItem.image"
                  fit="cover"
                  class="news-img"
                  :alt="newsItem.title"
                />
                <ElTag 
                  :type="newsItem.category === 'Pelatihan' ? 'success' : 
                         newsItem.category === 'Seminar' ? 'primary' :
                         newsItem.category === 'Teknologi' ? 'info' :
                         newsItem.category === 'Pendidikan' ? 'warning' : 'danger'" 
                  class="news-tag"
                >
                  {{ newsItem.category }}
                </ElTag>
              </div>
              <div class="news-content">
                <h3 class="news-title">{{ newsItem.title }}</h3>
                <p class="news-summary">{{ newsItem.summary }}</p>
                <div class="news-meta">
                  <span class="news-date">{{ formatDate(newsItem.date) }}</span>
                  <ElButton text class="news-link">
                    Baca Selengkapnya
                    <ElIcon class="ml-1"><ArrowRight /></ElIcon>
                  </ElButton>
                </div>
              </div>
            </ElCard>
          </ElCol>
        </ElRow>
      </div>

      <!-- Pagination Dots -->
      <div class="carousel-pagination">
        <span 
          v-for="(page, index) in totalPages" 
          :key="index"
          :class="['pagination-dot', { active: currentIndex === index }]"
          @click="currentIndex = index"
        ></span>
      </div>

      <!-- Carousel Info -->
      <div class="carousel-info">
        <span class="info-text">
          {{ currentIndex + 1 }} / {{ totalPages }} 
          ({{ news.length }} berita total)
        </span>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Container untuk komponen berita */
.news-section-container {
  padding: 6rem 0;
  background: white;
}

/* Header Bagian */
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

/* Carousel Styles */
.carousel-wrapper {
  position: relative;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 2rem;
}

.carousel-container {
  overflow: hidden;
  border-radius: 20px;
}

.news-row {
  transition: transform 0.3s ease;
}

/* Navigation Buttons */
.carousel-nav {
  display: flex;
  justify-content: space-between;
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  transform: translateY(-50%);
  z-index: 10;
  pointer-events: none;
}

.nav-button {
  pointer-events: all;
  background: white;
  border: 2px solid #e2e8f0;
  color: #64748b;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

.nav-button:hover:not(:disabled) {
  background: #ec4899;
  color: white;
  border-color: #ec4899;
  transform: scale(1.1);
}

.nav-button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.prev-button {
  margin-left: -1rem;
}

.next-button {
  margin-right: -1rem;
}

/* Pagination */
.carousel-pagination {
  display: flex;
  justify-content: center;
  gap: 0.5rem;
  margin-top: 2rem;
}

.pagination-dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background: #cbd5e1;
  cursor: pointer;
  transition: all 0.3s ease;
}

.pagination-dot.active {
  background: #ec4899;
  transform: scale(1.2);
}

.pagination-dot:hover {
  background: #ec4899;
  opacity: 0.7;
}

/* Carousel Info */
.carousel-info {
  text-align: center;
  margin-top: 1rem;
}

.info-text {
  color: #94a3b8;
  font-size: 0.9rem;
  font-weight: 500;
}

/* Gaya Bagian Berita */
.news-card {
  border-radius: 20px;
  border: none;
  overflow: hidden;
  height: 100%;
  transition: all 0.3s ease;
}

.news-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
}

.news-image {
  position: relative;
  height: 200px;
  overflow: hidden;
}

.news-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.news-tag {
  position: absolute;
  top: 1rem;
  left: 1rem;
  font-weight: 600;
}

.news-content {
  padding: 2rem;
}

.news-title {
  font-size: 1.1rem;
  font-weight: 600;
  color: #1e293b;
  margin-bottom: 1rem;
  line-height: 1.4;
}

.news-summary {
  color: #64748b;
  font-size: 0.9rem;
  line-height: 1.6;
  margin-bottom: 1.5rem;
}

.news-meta {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.news-date {
  color: #94a3b8;
  font-size: 0.85rem;
  font-weight: 500;
}

.news-link {
  color: #ec4899;
  font-weight: 600;
  font-size: 0.9rem;
}

/* Media Queries untuk Responsif */
@media (max-width: 1024px) {
  .section-title {
    font-size: 2rem;
  }

  .section-subtitle {
    font-size: 1rem;
  }

  .carousel-wrapper {
    padding: 0 1rem;
  }

  .nav-button {
    display: none; /* Sembunyikan tombol navigasi di tablet */
  }
}

@media (max-width: 768px) {
  .section-title {
    font-size: 1.8rem;
  }

  .section-subtitle {
    font-size: 0.95rem;
  }

  .carousel-wrapper {
    padding: 0 0.5rem;
  }

  /* Di mobile, tampilkan 1 berita per slide */
  .news-row .el-col {
    flex: 0 0 100%;
    max-width: 100%;
  }

  .news-card {
    margin-bottom: 1.5rem;
  }
}

/* Smooth scrolling untuk mobile */
@media (max-width: 768px) {
  .carousel-container {
    scroll-behavior: smooth;
  }
}
</style>