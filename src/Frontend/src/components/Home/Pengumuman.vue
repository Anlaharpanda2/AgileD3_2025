<template>
  <div class="bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header Section -->
      <div class="text-center mb-15 md:mb-16" data-aos="fade-up">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
          Pengumuman
        </h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
          Informasi penting dan jadwal kegiatan terkini
        </p>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center items-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-pink-500"></div>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="text-center py-12">
        <div class="bg-red-50 border border-red-200 rounded-lg p-6 max-w-md mx-auto shadow-sm">
          <p class="text-red-600 font-medium">{{ error }}</p>
        </div>
      </div>

      <!-- No Announcements State -->
      <div v-else-if="announcements.length === 0" class="text-center py-12">
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 max-w-md mx-auto shadow-sm">
          <ElIcon class="text-5xl text-gray-400 mb-4 opacity-75"><Bell /></ElIcon>
          <p class="text-gray-600 font-medium">Belum ada pengumuman tersedia saat ini.</p>
        </div>
      </div>

      <!-- Announcements List -->
      <div v-else class="max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="200">
        <div 
          class="h-[500px] overflow-y-auto scrollbar-thin scrollbar-thumb-pink-300 scrollbar-track-gray-100 space-y-4 pr-3 py-1 scroll-left"
        >
          <ElCard
            v-for="(announcement, index) in announcements"
            :key="announcement.id"
            class="border-0 shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 rounded-2xl cursor-pointer"
            shadow="never"
            data-aos="slide-right"
            :data-aos-delay="index * 100"
          >
            <div>
              <div class="flex items-start justify-between gap-4">
                <!-- Icon Placeholder -->
                <div class="flex-shrink-0 mt-1">
                  <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center">
                    <ElIcon class="text-xl text-pink-500"><Bell /></ElIcon>
                  </div>
                </div>

                <!-- Announcement Content -->
                <div class="flex-grow min-w-0">
                  <h4 class="text-lg font-semibold text-gray-900 mb-1 leading-tight">
                    {{ announcement.judul }}
                  </h4>
                  <p class="text-gray-600 text-sm mb-2 line-clamp-2">
                    {{ announcement.isi }}
                  </p>
                  <span class="text-sm text-gray-500">
                    {{ formatDate(announcement.created_at) }}
                  </span>
                </div>

                <!-- Tag -->
                <div class="flex-shrink-0 mt-1">
                  <ElTag 
                    :type="getAnnouncementType(announcement.created_at)"
                    class="font-medium px-3 py-1 rounded-full text-xs"
                    size="small"
                  >
                    {{ getAnnouncementLabel(announcement.created_at) }}
                  </ElTag>
                </div>
              </div>
            </div>
          </ElCard>
        </div>
        
        <!-- Scroll Hint -->
        <div v-if="announcements.length > 3" class="text-center mt-6">
          <p class="text-sm text-gray-500 flex items-center justify-center gap-2">
            <span>Gulir untuk melihat pengumuman lainnya</span>
            <svg class="w-5 h-5 text-gray-400 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { onMounted, nextTick } from 'vue'; // Import nextTick
import { ElCard, ElIcon, ElTag } from 'element-plus';
import { Bell } from '@element-plus/icons-vue';
import AOS from 'aos';
import 'aos/dist/aos.css';

// Impor composable dan service
import { useAnnouncements } from '../../services/useAnnouncements'; // Menggunakan path relatif sesuai kode Anda
import { formatDate, getAnnouncementType, getAnnouncementLabel } from '../../services/dateFormatter'; // Menggunakan path relatif sesuai kode Anda

// Menggunakan composable
const { announcements, loading, error, fetchAnnouncements } = useAnnouncements();

// Lifecycle hook: saat komponen dimount
onMounted(async () => {
  // 1. Ambil data pengumuman terlebih dahulu
  await fetchAnnouncements();

  // 2. Setelah data diambil dan DOM diperbarui oleh Vue,
  //    gunakan nextTick untuk memastikan AOS diinisialisasi
  //    atau disegarkan setelah DOM stabil.
  nextTick(() => {
    AOS.init({
      duration: 800,       // Durasi animasi dalam ms
      easing: 'ease-in-out', // Fungsi easing
      once: true,          // Apakah animasi harus berjalan hanya sekali?
      offset: 100,         // Offset (dalam px) dari posisi elemen untuk memicu animasi
      delay: 0             // Delay umum untuk semua animasi AOS
    });
    // Jika AOS sudah diinisialisasi di tempat lain (misal di main.ts),
    // Anda bisa mencoba AOS.refresh() di sini alih-alih AOS.init()
    // atau gunakan kondisi: if (!AOS.initialized) { AOS.init() } else { AOS.refresh() }
    // Untuk kasus ini, karena Anda memanggil AOS.init di sini, ini akan re-initialize jika dipanggil lagi,
    // yang mungkin bukan perilaku yang ideal. Cara paling aman adalah memastikan hanya satu inisialisasi.
    // Jika Anda memastikan AOS hanya diinisialisasi sekali di aplikasi Anda (misal di main.ts),
    // maka di sini Anda hanya perlu memanggil AOS.refresh().
    // Untuk demo ini, saya akan tetap menggunakan AOS.init() di sini dengan asumsi ini adalah tempat utama inisialisasi.
    // Namun, pendekatan terbaik untuk aplikasi yang lebih besar adalah menginisialisasi AOS global sekali,
    // lalu menggunakan AOS.refresh() di komponen dinamis.
  });
});
</script>

<style scoped>
/*
  Bagian STYLE tetap sama seperti yang Anda berikan,
  dengan sedikit penyesuaian untuk konsistensi dan readability.
*/

/* Custom styles untuk line-clamp jika tidak tersedia di Tailwind
   Ini memastikan teks tidak melebihi 2 baris dan menampilkan elipsis. */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis; /* Menambahkan elipsis */
}

/* Hover effects untuk card ElCard */
.el-card:hover {
  border-color: rgba(236, 72, 153, 0.2); /* Border pink saat hover */
}

/* Custom scrollbar styles untuk browser berbasis WebKit (Chrome, Safari) */
.scrollbar-thin {
  scrollbar-width: thin; /* Untuk Firefox */
}

.scroll-left::-webkit-scrollbar {
  width: 8px; /* Lebar scrollbar */
}

.scroll-left::-webkit-scrollbar-track {
  background: #f3f4f6; /* Warna latar belakang track */
  border-radius: 4px; /* Sudut membulat track */
}

.scroll-left::-webkit-scrollbar-thumb {
  background: #f9a8d4; /* Warna thumb (penggulir) */
  border-radius: 4px; /* Sudut membulat thumb */
  border: 1px solid #f3f4f6; /* Border tipis pada thumb */
}

.scroll-left::-webkit-scrollbar-thumb:hover {
  background: #f472b6; /* Warna thumb saat hover */
}

/* Memaksa scrollbar muncul di sisi kiri pada elemen dengan direction: rtl */
.scroll-left {
  direction: rtl; /* Mengatur arah teks menjadi kanan-ke-kiri untuk menempatkan scrollbar di kiri */
}

.scroll-left > * {
  direction: ltr; /* Mengatur kembali arah teks di dalam elemen konten menjadi kiri-ke-kanan */
}

/* Custom tag colors untuk konsistensi dengan tema pink */
/* Menggunakan :deep() untuk menargetkan kelas internal dari komponen Element Plus */
:deep(.el-tag--success) {
  background-color: rgba(34, 197, 94, 0.1); /* bg-green-100 */
  border-color: rgba(34, 197, 94, 0.2); /* border-green-200 */
  color: rgb(22, 163, 74); /* text-green-700 */
}

:deep(.el-tag--warning) {
  background-color: rgba(245, 158, 11, 0.1); /* bg-yellow-100 */
  border-color: rgba(245, 158, 11, 0.2); /* border-yellow-200 */
  color: rgb(217, 119, 6); /* text-yellow-700 */
}

:deep(.el-tag--info) {
  background-color: rgba(236, 72, 153, 0.1); /* custom pink-100 */
  border-color: rgba(236, 72, 153, 0.2); /* custom pink-200 */
  color: rgb(219, 39, 119); /* custom pink-700 */
}

/* Smooth scroll behavior untuk elemen dengan overflow-y-auto */
.overflow-y-auto {
  scroll-behavior: smooth;
}

/* Firefox scrollbar styling */
/* Ini diperlukan karena Firefox menggunakan properti scrollbar-color yang berbeda */
.scrollbar-thin {
  scrollbar-width: thin;
  scrollbar-color: #f9a8d4 #f3f4f6; /* thumb color track color */
}

/* Enhanced card animation dalam scroll container untuk pengalaman pengguna yang lebih baik */
@media (prefers-reduced-motion: no-preference) {
  .el-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important; /* Contoh shadow-xl yang lebih menonjol */
    transform: translateY(-4px) !important; /* Mengangkat sedikit kartu */
    transition: all 0.1s ease-in-out !important; /* Transisi cepat untuk efek responsif */
  }
}
</style>
