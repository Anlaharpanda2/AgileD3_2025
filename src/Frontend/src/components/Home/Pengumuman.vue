<script setup lang="ts">
import { ref, onMounted } from 'vue'
import {
  ElCard,
  ElIcon,
  ElTag
} from 'element-plus'
import { Bell } from '@element-plus/icons-vue'
import AOS from 'aos'
import 'aos/dist/aos.css' // Impor CSS AOS

// Data untuk pengumuman
const announcements = ref([
  {
    id: 1,
    title: 'Pendaftaran Pelatihan Batch 2 Dibuka',
    date: '2025-06-25',
    type: 'info'
  },
  {
    id: 2,
    title: 'Maintenance Sistem Tanggal 30 Juni 2025',
    date: '2025-06-30',
    type: 'warning'
  },
  {
    id: 3,
    title: 'Webinar Gratis: Pemberdayaan Ekonomi Perempuan',
    date: '2025-07-05',
    type: 'success'
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
  <div class="announcements-container">
    <div class="section-header" data-aos="fade-up">
      <h2 class="section-title">Pengumuman</h2>
      <p class="section-subtitle">
        Informasi penting dan jadwal kegiatan terkini
      </p>
    </div>
    <div class="announcements-list" data-aos="fade-up" data-aos-delay="200">
      <ElCard
        v-for="(announcement, index) in announcements"
        :key="announcement.id"
        class="announcement-card"
        shadow="hover"
        data-aos="slide-right"
        :data-aos-delay="index * 100"
      >
        <div class="announcement-content">
          <ElIcon class="announcement-icon"><Bell /></ElIcon>
          <div class="announcement-text">
            <h4>{{ announcement.title }}</h4>
            <span class="announcement-date">{{ formatDate(announcement.date) }}</span>
          </div>
          <ElTag :type="announcement.type" class="announcement-tag">
            {{ announcement.type === 'info' ? 'Info' :
               announcement.type === 'warning' ? 'Penting' : 'Baru' }}
          </ElTag>
        </div>
      </ElCard>
    </div>
  </div>
</template>

<style scoped>
/* Container untuk komponen pengumuman */
.announcements-container {
  /* No specific padding here, handled by parent section */
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

/* Gaya Bagian Pengumuman */
.announcements-list {
  max-width: 800px; /* Lebar maksimum untuk daftar pengumuman */
  margin: 0 auto;
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  padding-bottom: 2rem; /* Jarak bawah jika hanya ada satu kolom */
}

.announcement-card {
  border-radius: 16px;
  border: none;
  padding: 1.5rem 2rem;
  transition: all 0.3s ease;
}

.announcement-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
}

.announcement-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
}

.announcement-icon {
  font-size: 2rem;
  color: #ec4899;
  flex-shrink: 0;
}

.announcement-text {
  flex-grow: 1;
}

.announcement-text h4 {
  font-size: 1.1rem;
  font-weight: 600;
  color: #1e293b;
  margin-bottom: 0.25rem;
}

.announcement-date {
  font-size: 0.9rem;
  color: #94a3b8;
}

.announcement-tag {
  font-weight: 600;
  min-width: 60px;
  text-align: center;
}

/* Media Queries untuk Responsif */
@media (max-width: 1024px) {
  .section-title {
    font-size: 2rem;
  }

  .section-subtitle {
    font-size: 1rem;
  }

  .announcements-list {
    max-width: 100%; /* Full width on smaller screens */
    padding-bottom: 4rem; /* Add more space when stacked */
  }
}

@media (max-width: 768px) {
  .section-title {
    font-size: 1.8rem;
  }

  .section-subtitle {
    font-size: 0.95rem;
  }

  .announcement-card {
    flex-direction: column;
    text-align: center;
    gap: 0.75rem;
  }

  .announcement-icon {
    margin-bottom: 0.5rem;
  }
}
</style>
