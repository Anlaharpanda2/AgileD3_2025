<template>
  <DefaultLayout>
    <!-- Hero Slider Section -->
    <section class="hero-section">
      <Slider />
    </section>

    <div class="container py-5">
      <div class="text-center mb-5">
        <h2 class="section-heading">LAYANAN KAMI</h2>
      </div>
      <!-- Services Section -->
      <section class="services-section">
        <div class="row g-4 justify-content-center">
          <div class="col-md-6 col-lg-4">
            <Layanan1></Layanan1>
          </div>
          <div class="col-md-6 col-lg-4">
            <Layanan2></Layanan2>
          </div>
          <div class="col-md-6 col-lg-4">
            <Layanan3></Layanan3>
          </div>
        </div>
      </section>
    </div>

    <!-- Latest News & Announcements Section -->
    <section class="featured-activity-section py-5">
      <div class="container">
        <div class="row align-items-stretch">
          <!-- Latest News Slider Section -->
          <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="news-slider-card">
              <h2 class="card-section-title">BERITA TERBARU</h2>
              <div v-if="latestNews.length > 0" class="news-slider-container-main">
                <transition name="news-slide-transition" mode="out-in">
                  <div :key="currentNewsItem.id" class="news-slide-item">
                    <div class="news-slide-image-wrapper">
                      <img
                        :src="STORAGE_URL + currentNewsItem.foto"
                        :alt="currentNewsItem.judul"
                        class="img-fluid rounded"
                      />
                    </div>
                    <div class="news-slide-content">
                      <h3 class="news-slide-title">{{ currentNewsItem.judul }}</h3>
                      <span class="news-slide-date">{{ formatDate(currentNewsItem.created_at) }}</span>
                      <p class="news-slide-description">{{ currentNewsItem.isi.substring(0, 150) + '...' }}</p>
                      <a href="#" class="btn btn-detail mt-3">
                        <i class="fas fa-info-circle me-2"></i>Baca Selengkapnya
                      </a>
                    </div>
                  </div>
                </transition>
                <div class="news-slider-nav">
                  <button @click="showPrevNews" :disabled="latestNews.length <= 1" class="nav-arrow-btn prev-btn">
                    <i class="fas fa-chevron-left"></i>
                  </button>
                  <button @click="showNextNews" :disabled="latestNews.length <= 1" class="nav-arrow-btn next-btn">
                    <i class="fas fa-chevron-right"></i>
                  </button>
                </div>
              </div>
              <div v-else class="text-center text-muted py-5">
                <p>Tidak ada berita terbaru saat ini.</p>
              </div>
            </div>
          </div>

          <!-- News & Announcements Section (Right Side) -->
          <div class="col-lg-6">
            <div class="news-announcements-card">
              <div class="tab-controls">
                <button class="tab-button active" data-tab="pengumuman">
                  <i class="fas fa-bullhorn me-2"></i>PENGUMUMAN
                </button>
                <button class="tab-button" data-tab="agenda">
                  <i class="fas fa-calendar me-2"></i>AGENDA KEGIATAN
                </button>
              </div>

              <div class="tab-content-display" id="pengumuman">
                <div class="news-list-scrollable">
                  <div class="news-entry">
                    <h4>PETUNJUK PENDAFTARAN PELATIHAN SECARA ONLINE</h4>
                    <span class="news-date">14 Juni 2025</span>
                  </div>
                  <div class="news-entry">
                    <h4>Jadwal Pendaftaran dan Pelatihan Angkatan XXXXX</h4>
                    <span class="news-date">12 Juni 2025</span>
                  </div>
                  <div class="news-entry">
                    <h4>Syarat dan Ketentuan untuk Mengikuti Kegiatan Pelatihan</h4>
                    <span class="news-date">10 Juni 2025</span>
                  </div>
                  <div class="news-entry">
                    <h4>Keputusan Presiden tentang Keanggotaan KKI</h4>
                    <span class="news-date">8 Juni 2025</span>
                  </div>
                  <div class="news-entry">
                    <h4>Peraturan Pemerintah RI No. 28 Tahun 2024 tentang Peraturan Pelaksanaan UU Kesehatan</h4>
                    <span class="news-date">5 Juni 2025</span>
                  </div>
                </div>
                <div class="text-center mt-4">
                  <a href="#" class="btn btn-outline-custom">
                    <i class="fas fa-plus me-2"></i>Pengumuman Lainnya
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact & Maps Section -->
    <section class="contact-maps-section py-5">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-5 mb-4 mb-lg-0">
            <div class="contact-info-block">
              <h2 class="contact-title-heading">
                <i class="fas fa-phone-alt me-3"></i>Kontak Resmi
              </h2>
              <h3 class="office-name-subheading">DP3AP2KB Kota Padang</h3>
              <div class="contact-details-list">
                <div class="contact-detail-item">
                  <i class="fas fa-map-marker-alt me-3"></i>
                  <div>
                    <strong>Alamat:</strong><br>
                    Jl. Rasuna Said No.74, Rimbo Kaluang, Kec. Padang Bar., Kota Padang, Sumatera Barat
                  </div>
                </div>
                <div class="contact-detail-item">
                  <i class="fas fa-envelope me-3"></i>
                  <div>
                    <strong>Email:</strong><br>
                    dp3ap2kb@padang.go.id
                  </div>
                </div>
                <div class="contact-detail-item">
                  <i class="fas fa-phone me-3"></i>
                  <div>
                    <strong>Telepon:</strong><br>
                    (0751) 123456
                  </div>
                </div>
              </div>
              <button class="btn btn-light-custom mt-4">
                <i class="fas fa-directions me-2"></i>Kantor Terdekat
              </button>
            </div>
          </div>

          <div class="col-lg-7">
            <div class="map-display-container">
              <div class="map-header-bar">
                <h4><i class="fas fa-map me-2"></i>Lokasi Kantor</h4>
              </div>
              <div class="map-embed-wrapper">
                <iframe
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.6601!2d100.3543!3d-0.9492!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd4b7c9d8a12345%3A0x1234567890abcdef!2sJl.%20Rasuna%20Said%20No.74%2C%20Rimbo%20Kaluang%2C%20Kec.%20Padang%20Bar.%2C%20Kota%20Padang%2C%20Sumatera%20Barat!5e0!3m2!1sid!2sid!4v1234567890123!5m2!1sid!2sid"
                  width="100%"
                  height="400"
                  style="border:0; border-radius: 0 0 10px 10px;"
                  allowfullscreen=""
                  loading="lazy"
                  referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                <div class="map-info-overlay">
                  <div class="office-location-marker">
                    <i class="fas fa-building"></i>
                    <div class="marker-details">
                      <strong>Dinas Pemberdayaan Perempuan...</strong>
                      <small>Jl. Rasuna Said No.74, Rimbo Kaluang</small>
                      <a href="#" class="btn btn-sm btn-directions mt-1">
                        <i class="fas fa-directions me-1"></i>Directions
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </DefaultLayout>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue';
import DefaultLayout from '../../layouts/DefaultLayout.vue';
import Slider from '../../components/Home/Slider.vue';
import { ElMessage } from 'element-plus';
import api from '@/api.js';
import {STORAGE_URL} from '@/api.js';
import FormTambahDataPendaftaran from '../../components/Home/FormTambahDataPendaftaran.vue';
import Layanan1 from '../../components/Home/Layanan1.vue';
import Layanan2 from '../../components/Home/Layanan2.vue';
import Layanan3 from '../../components/Home/Layanan3.vue';

// --- News Slider Logic ---
const latestNews = ref([]);
const currentNewsIndex = ref(0); // Index berita yang sedang ditampilkan
const showTambah = ref(false)
// Computed property untuk berita yang sedang aktif
const currentNewsItem = computed(() => {
  if (latestNews.value.length > 0) {
    return latestNews.value[currentNewsIndex.value];
  }
  return null;
});

// Fungsi untuk menampilkan berita berikutnya
const showNextNews = () => {
  if (latestNews.value.length > 1) {
    currentNewsIndex.value = (currentNewsIndex.value + 1) % latestNews.value.length;
  }
};

// Fungsi untuk menampilkan berita sebelumnya
const showPrevNews = () => {
  if (latestNews.value.length > 1) {
    currentNewsIndex.value = (currentNewsIndex.value - 1 + latestNews.value.length) % latestNews.value.length;
  }
};

const fetchLatestNews = async () => {
  try {
    const response = await api.get('/kelola/berita');

    const data = Array.isArray(response) ? response : response?.data;

    if (Array.isArray(data)) {
      latestNews.value = data.slice(0, 5); // 5 berita terbaru
    } else {
      console.warn('Struktur data tidak sesuai ekspektasi:', response);
      latestNews.value = [];
    }
  } catch (error) {
    console.error('Gagal fetch berita:', error);
    ElMessage.error('Gagal memuat berita terbaru.');
    latestNews.value = [];
  }
};


// Format date function
const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(dateString).toLocaleDateString('id-ID', options);
};

// Fetch news when component is mounted
onMounted(() => {
  fetchLatestNews();
});
</script>

<style scoped>
body {
  font-family: 'Inter', sans-serif; /* Pastikan font Inter digunakan */
  color: #333;
  background-color: #FFFFFF;
}

/* Global Section Headings */
.section-heading {
  font-size: 2.2rem;
  font-weight: 700;
  color: #69C5C2; /* Judul bagian menggunakan warna sekunder */
  position: relative;
  display: inline-block; /* Agar underline pas */
  padding-bottom: 10px;
  margin-bottom: 30px;
}

.section-heading::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 80px;
  height: 4px;
  background-color: #69C5C2;
  border-radius: 2px;
}

/* Service Card Styles */
.service-card-container {
  border: none;
  background: transparent;
  padding: 0; /* Hapus padding default Element Plus */
}

.service-card-inner {
  border-radius: 18px;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); /* Bayangan lebih ringan */
  background: #FFFFFF;
  transition: transform 0.35s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.35s cubic-bezier(0.2, 0.8, 0.2, 1);
  display: flex;
  flex-direction: column;
  height: 100%; /* Pastikan kartu punya tinggi yang sama */
}

.service-card-container:hover .service-card-inner {
  transform: translateY(-10px); /* Efek lift yang lebih jelas */
  box-shadow: 0 18px 40px rgba(105, 197, 194, 0.25); /* Bayangan hover yang lebih menonjol */
}

.service-card-image {
  width: 100%;
  height: 200px;
  object-fit: cover;
  transition: transform 0.4s ease-out; /* Transisi lebih halus */
}

.service-card-container:hover .service-card-image {
  transform: scale(1.08); /* Zoom in yang lebih jelas */
}

.service-card-content {
  padding: 1.5rem;
  flex-grow: 1; /* Konten akan mengisi ruang yang tersedia */
}

.service-card-title {
  font-size: 1.4rem;
  font-weight: 700;
  margin-bottom: 0.75rem;
  color: #333;
}

.service-card-description {
  color: #666;
  font-size: 0.98rem;
  line-height: 1.6;
}

.service-card-actions {
  padding: 1.25rem 1.5rem;
  text-align: right;
  border-top: 1px solid #e0e0e0; /* Garis pemisah */
}

.submit-btn {
  background-color: #69C5C2;
  border-color: #69C5C2;
  color: #FFFFFF;
  font-weight: 600;
  padding: 0.75rem 1.5rem;
  transition: all 0.3s ease-out;
  box-shadow: none; /* Hilangkan bayangan default */
}

.submit-btn:hover {
  background-color: #5B9B98; /* Efek gelap */
  border-color: #5B9B98;
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(105, 197, 194, 0.45);
}

/* Featured Activity Section */
.featured-activity-section {
  background-color: #FFFFFF;
  padding: 4rem 0;
}

/* News Slider Card (Left Column) */
.news-slider-card {
  background: #FFFFFF;
  border-radius: 20px;
  padding: 30px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
  height: 100%;
  display: flex;
  flex-direction: column;
  position: relative; /* Untuk posisi tombol navigasi */
  overflow: hidden; /* Penting agar slide tidak keluar batas */
}

/* Kontainer utama untuk item slide, untuk mengelola posisi absolut saat transisi */
.news-slider-container-main {
  position: relative;
  flex-grow: 1;
  /* Tambahkan min-height untuk mencegah layout bergeser saat transisi */
  min-height: 450px; /* Sesuaikan berdasarkan tinggi konten slide Anda */
}

.news-slide-item {
  position: absolute; /* Penting untuk transisi out-in */
  width: calc(100% - 60px); /* Kurangi padding card kiri/kanan (30px * 2) */
  left: 30px; /* Offset sesuai padding kiri card */
  top: 0; /* Dimulai dari bagian atas news-slider-container-main */
  text-align: center;
  display: flex; /* Untuk menumpuk gambar dan konten vertikal */
  flex-direction: column;
}

.news-slide-image-wrapper {
  width: 100%;
  height: 250px; /* Tinggi tetap untuk gambar slider */
  overflow: hidden;
  border-radius: 15px;
  margin-bottom: 20px;
}

.news-slide-image-wrapper img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease-out;
}

.news-slide-image-wrapper:hover img {
  transform: scale(1.05);
}

.news-slide-content {
  flex-grow: 1; /* Memastikan konten mengisi ruang */
  padding: 0 20px; /* Sedikit padding horizontal */
  text-align: left; /* Sesuaikan perataan teks */
}

.news-slide-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #333;
  margin-bottom: 10px;
  line-height: 1.4;
}

.news-slide-date {
  color: #95a5a6;
  font-size: 0.9rem;
  display: block; /* Agar di baris baru */
  margin-bottom: 15px;
}

.news-slide-description {
  color: #666;
  font-size: 0.95rem;
  line-height: 1.6;
  margin-bottom: 20px;
}

.news-slider-nav {
  position: absolute;
  top: calc(30px + 250px / 2); /* Mengatur posisi vertikal di tengah gambar */
  left: 0;
  right: 0;
  transform: translateY(-50%);
  display: flex;
  justify-content: space-between;
  padding: 0 10px; /* Padding dari sisi card */
  z-index: 10;
}

.nav-arrow-btn {
  background: rgba(255, 255, 255, 0.9);
  border: none;
  width: 45px;
  height: 45px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s ease-out;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  color: #69C5C2;
}

.nav-arrow-btn:hover {
  background-color: #69C5C2;
  color: #FFFFFF;
  transform: scale(1.15); /* Lebih besar */
  box-shadow: 0 6px 15px rgba(105, 197, 194, 0.25);
}

.nav-arrow-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
  transform: none;
  box-shadow: none;
}

/* Vue Transition Styles (Specific for image and content children) */

/* Base transition for the image and content wrappers */
.news-slide-image-wrapper,
.news-slide-content {
  transition: transform 0.5s cubic-bezier(0.2, 0.8, 0.2, 1), opacity 0.5s ease-out;
}

/* When the overall news-slide-item enters */
.news-slide-transition-enter-from .news-slide-image-wrapper {
  transform: translateX(100%);
  opacity: 0;
}

.news-slide-transition-enter-from .news-slide-content {
  opacity: 0;
}

/* When the overall news-slide-item leaves */
.news-slide-transition-leave-to .news-slide-image-wrapper {
  transform: translateX(-100%);
  opacity: 0;
}

.news-slide-transition-leave-to .news-slide-content {
  opacity: 0;
}

/* Ensure the absolute positioning for transitions */
.news-slide-transition-enter-active,
.news-slide-transition-leave-active {
  position: absolute;
  width: calc(100% - 60px); /* Sesuaikan lebar dengan padding card */
  left: 30px; /* Sesuaikan posisi kiri dengan padding card */
  top: 0; /* Posisikan di bagian atas news-slider-container-main */
}


.card-section-title {
  color: #69C5C2;
  font-weight: 700;
  margin-bottom: 30px;
  position: relative;
  padding-bottom: 15px;
  font-size: 1.8rem;
}

.card-section-title::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 70px;
  height: 4px;
  background-color: #69C5C2;
  border-radius: 2px;
}

/* News & Announcements Section (Right Column) */
.news-announcements-card {
  background: #FFFFFF;
  border-radius: 20px;
  padding: 30px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
  height: 100%; /* Penting untuk align-items-stretch */
  display: flex;
  flex-direction: column;
  margin-left: 0; /* Hilangkan margin-left yang ada */
}

.tab-controls {
  display: flex;
  margin-bottom: 25px;
  border-bottom: 2px solid #e0e0e0;
  gap: 10px; /* Jarak antar tombol tab */
}

.tab-button {
  background: none;
  border: none;
  padding: 12px 20px;
  font-weight: 600;
  color: #666;
  cursor: pointer;
  transition: all 0.3s ease;
  border-bottom: 3px solid transparent;
  font-size: 1.05rem;
}

.tab-button.active {
  color: #69C5C2;
  border-bottom-color: #69C5C2;
}

.tab-button:hover:not(.active) {
  color: #69C5C2;
}

.news-list-scrollable {
  max-height: 400px; /* Batasi tinggi untuk scroll */
  overflow-y: auto;
  padding-right: 10px; /* Ruang untuk scrollbar */
}

/* Existing news-entry styles for the right column (Announcements/Agenda) */
.news-announcements-card .news-entry {
  padding: 18px 0;
  border-bottom: 1px solid #e0e0e0;
  transition: all 0.3s ease;
  cursor: pointer;
}

.news-announcements-card .news-entry:last-child {
  border-bottom: none; /* Hapus border bawah item terakhir */
}

.news-announcements-card .news-entry:hover {
  background: #f9fbfb; /* Background yang sangat terang saat hover */
  padding-left: 15px;
  border-left: 4px solid #69C5C2; /* Border kiri dengan warna sekunder */
}

.news-announcements-card .news-entry h4 {
  color: #333;
  font-size: 1.05rem;
  font-weight: 600;
  margin-bottom: 6px;
  line-height: 1.4;
}

.news-announcements-card .news-date {
  color: #95a5a6;
  font-size: 0.85rem;
}

.btn-outline-custom {
  color: #69C5C2;
  border-color: #69C5C2;
  font-weight: 600;
  padding: 0.7rem 1.4rem;
  border-radius: 8px;
  transition: all 0.3s ease-out;
}

.btn-outline-custom:hover {
  background-color: #69C5C2;
  color: #FFFFFF;
  box-shadow: 0 5px 15px rgba(105, 197, 194, 0.45);
  transform: translateY(-2px);
}

/* Contact Section */
.contact-maps-section {
  background-color: #69C5C2; /* Warna sekunder sebagai latar belakang */
  color: #FFFFFF; /* Teks putih di atas latar belakang sekunder */
  position: relative;
  overflow: hidden;
  padding: 4rem 0;
}

.contact-info-block {
  position: relative;
  z-index: 2;
}

.contact-title-heading {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 20px;
}

.office-name-subheading {
  font-size: 1.8rem;
  font-weight: 600;
  margin-bottom: 30px;
  color: #FFFFFF; /* Pastikan tetap putih */
}

.contact-details-list {
  list-style: none; /* Hapus bullet default */
  padding: 0;
  margin: 0;
}

.contact-detail-item {
  display: flex;
  align-items: flex-start;
  margin-bottom: 25px;
  font-size: 1.1rem;
}

.contact-detail-item i {
  color: #FFFFFF; /* Ikon putih */
  margin-top: 5px;
  flex-shrink: 0;
  font-size: 1.3rem;
}

.contact-detail-item strong {
  color: #FFFFFF;
}

.contact-detail-item div {
  padding-left: 10px; /* Jarak antara ikon dan teks */
}

.btn-light-custom {
  background-color: #FFFFFF;
  border-color: #FFFFFF;
  color: #69C5C2; /* Teks warna sekunder */
  font-weight: 600;
  padding: 0.8rem 1.8rem;
  border-radius: 10px;
  transition: all 0.3s ease-out;
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15); /* Bayangan sedang */
}

.btn-light-custom:hover {
  background-color: #f0f0f0;
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25); /* Bayangan lebih jelas */
}

/* Map Container */
.map-display-container {
  position: relative;
  z-index: 2;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); /* Bayangan untuk kotak peta */
}

.map-header-bar {
  background: rgba(0, 0, 0, 0.15); /* Lebih gelap, lebih kontras */
  color: #FFFFFF;
  padding: 15px 20px;
  border-radius: 10px 10px 0 0;
  display: flex;
  align-items: center;
}
.map-header-bar h4 {
  margin-bottom: 0;
  font-size: 1.15rem;
  font-weight: 600;
}
.map-header-bar i {
  color: #FFFFFF;
  font-size: 1.25rem;
}

.map-embed-wrapper {
  position: relative;
  height: 400px;
}

.map-embed-wrapper iframe {
  border-radius: 0 0 10px 10px; /* Sesuaikan dengan map-display-container */
}

.map-info-overlay {
  position: absolute;
  top: 20px;
  left: 20px;
  background: rgba(255, 255, 255, 0.98); /* Lebih solid */
  padding: 18px;
  border-radius: 10px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
  max-width: 280px;
}

.office-location-marker i {
  color: #69C5C2;
  font-size: 28px; /* Ukuran ikon lebih besar */
  margin-bottom: 12px;
  display: block; /* Agar ikon berada di baris sendiri */
}

.marker-details strong {
  color: #333;
  display: block;
  margin-bottom: 5px;
  font-size: 1.05rem;
}

.marker-details small {
  color: #666;
  display: block;
  margin-bottom: 12px;
  font-size: 0.88rem;
}

.btn-directions {
  background-color: #69C5C2;
  border-color: #69C5C2;
  color: #FFFFFF;
  padding: 0.5rem 1rem;
  border-radius: 6px;
  font-size: 0.85rem;
  transition: all 0.3s ease-out;
}

.btn-directions:hover {
  background-color: #5B9B98;
  border-color: #5B9B98;
  transform: translateY(-1px);
  box-shadow: 0 3px 8px rgba(105, 197, 194, 0.45);
}

/* Responsive Design */
@media (max-width: 991.98px) { /* Medium devices (tablets) and down */
  .section-heading {
    font-size: 1.8rem;
  }
  .card-section-title {
    font-size: 1.6rem;
  }
  .news-slider-card,
  .news-announcements-card {
    padding: 20px;
  }
  .news-slide-image-wrapper { /* Adjust this for the correct class name */
    height: 200px; /* Sesuaikan tinggi gambar slider di tablet */
  }
  .news-slide-title {
    font-size: 1.3rem;
  }
  .news-list-scrollable {
    max-height: 350px;
  }
  .tab-button {
    font-size: 0.95rem;
    padding: 10px 15px;
  }
  .news-list-scrollable {
    max-height: 350px;
  }
  .contact-title-heading {
    font-size: 2rem;
  }
  .office-name-subheading {
    font-size: 1.5rem;
  }
  .contact-detail-item {
    font-size: 1rem;
  }
  .map-embed-wrapper {
    height: 350px;
  }
}

@media (max-width: 767.98px) { /* Small devices (phones) and down */
  .section-heading {
    font-size: 1.6rem;
  }
  .section-heading::after {
    width: 60px;
  }
  .service-card-inner {
    margin-bottom: 1.5rem; /* Tambah jarak antar kartu di mobile */
  }
  .news-slider-card,
  .news-announcements-card {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); /* Bayangan lebih ringan di mobile */
  }
  .card-section-title {
    font-size: 1.4rem;
  }
  .news-slide-image-wrapper { /* Adjust this for the correct class name */
    height: 180px; /* Sesuaikan tinggi gambar slider di mobile */
  }
  .news-slide-title {
    font-size: 1.2rem;
  }
  .news-slide-description {
    font-size: 0.9rem;
  }
  .news-slider-nav {
    padding: 0 5px; /* Padding lebih kecil di mobile */
  }
  .nav-arrow-btn {
    width: 40px;
    height: 40px;
  }
  .tab-controls {
    flex-direction: column;
    gap: 5px;
    border-bottom: none; /* Hilangkan border bawah di mobile */
  }
  .tab-button {
    border-bottom: 1px solid #e0e0e0;
    width: 100%;
    text-align: left;
    padding: 12px 10px;
  }
  .tab-button.active {
    border-left: 4px solid #69C5C2;
    border-bottom: 1px solid #e0e0e0; /* Jaga border bawah aktif */
    padding-left: 15px;
  }
  .news-announcements-card {
    margin-top: 20px; /* Jarak atas di mobile */
  }
  .contact-title-heading {
    font-size: 1.8rem;
  }
  .office-name-subheading {
    font-size: 1.3rem;
  }
  .map-info-overlay {
    position: static; /* Di mobile, tampilkan overlay di bawah peta */
    max-width: 100%;
    margin-top: 20px;
    margin-left: 0;
    margin-right: 0;
    border-radius: 10px;
  }
}

/* Animations */
@keyframes fadeInSlideUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.service-card-container,
.news-slider-card,
.news-announcements-card,
.contact-info-block,
.map-display-container {
  animation: fadeInSlideUp 0.6s ease-out forwards; /* Tambahkan animasi awal */
  opacity: 0; /* Sembunyikan di awal */
}

/* Delay for each card/section */
.service-card-container:nth-child(1) { animation-delay: 0.1s; }
.service-card-container:nth-child(2) { animation-delay: 0.2s; }
.service-card-container:nth-child(3) { animation-delay: 0.3s; }
.news-slider-card { animation-delay: 0.4s; }
.news-announcements-card { animation-delay: 0.5s; }
.contact-info-block { animation-delay: 0.6s; }
.map-display-container { animation-delay: 0.7s; }

/* Custom Scrollbar */
.news-list-scrollable::-webkit-scrollbar {
  width: 6px;
  background: transparent; /* Background transparan */
}

.news-list-scrollable::-webkit-scrollbar-track {
  background: #f5f5f5; /* Track lebih terang */
  border-radius: 10px;
}

.news-list-scrollable::-webkit-scrollbar-thumb {
  background: #69C5C2; /* Thumb warna sekunder */
  border-radius: 10px;
}

.news-list-scrollable::-webkit-scrollbar-thumb:hover {
  background: #5B9B98; /* Thumb lebih gelap saat hover */
}
</style>
