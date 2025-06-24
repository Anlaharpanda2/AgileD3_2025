<script setup lang="ts">
import { ref, onMounted } from 'vue'
import {
  ElCard,
  ElRow,
  ElCol,
  ElIcon,
  ElImage,
  ElTag,
  ElButton
} from 'element-plus'
import { ArrowRight } from '@element-plus/icons-vue'
import AOS from 'aos'
import 'aos/dist/aos.css' // Impor CSS AOS

// Data untuk berita
const news = ref([
  {
    id: 1,
    title: 'Pelatihan Kewirausahaan untuk Perempuan Dimulai Bulan Ini',
    summary: 'Program pelatihan kewirausahaan khusus perempuan akan dimulai dengan 100 peserta dari berbagai daerah.',
    image: 'https://placehold.co/600x400/FFC0CB/000000?text=Berita+1', // Gambar placeholder
    date: '2025-06-20',
    category: 'Pelatihan'
  },
  {
    id: 2,
    title: 'Seminar Perlindungan Anak dan Pencegahan Kekerasan',
    summary: 'Seminar edukasi tentang perlindungan anak dan pencegahan kekerasan akan diselenggarakan secara hybrid.',
    image: 'https://placehold.co/600x400/ADD8E6/000000?text=Berita+2', // Gambar placeholder
    date: '2025-06-18',
    category: 'Seminar'
  },
  {
    id: 3,
    title: 'Launching Aplikasi Pengaduan Online Terbaru',
    summary: 'Sistem pengaduan online telah diperbarui dengan fitur keamanan dan privasi yang lebih baik.',
    image: 'https://placehold.co/600x400/90EE90/000000?text=Berita+3', // Gambar placeholder
    date: '2025-06-15',
    category: 'Teknologi'
  }
])

// Metode untuk memformat tanggal
const formatDate = (dateString: string) => {
  const options: Intl.DateTimeFormatOptions = {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  }
  return new Date(dateString).toLocaleDateString('id-ID', options)
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
  <div class="news-section-container">
    <div class="section-header" data-aos="fade-up">
      <h2 class="section-title">Berita Terbaru</h2>
      <p class="section-subtitle">
        Informasi terkini seputar kegiatan dan program pemberdayaan
      </p>
    </div>
    <ElRow :gutter="24">
      <ElCol
        :xs="24"
        :md="8"
        v-for="(newsItem, index) in news"
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
            <ElTag :type="newsItem.category === 'Pelatihan' ? 'success' : 'primary'" class="news-tag">
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

  .news-card {
    margin-bottom: 1.5rem; /* Tambahkan jarak antar kartu berita saat ditumpuk */
  }
}

@media (max-width: 768px) {
  .section-title {
    font-size: 1.8rem;
  }

  .section-subtitle {
    font-size: 0.95rem;
  }
}
</style>
